<?php

namespace App\External;

use App\Models\DropPayConfiguration;
use App\Models\Store;
use App\Models\StorePaymentConfig;
use App\Models\UserPaymentConfig;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp;
use App\Models\User;
use App\External\DropPayEndpoints;
use Illuminate\Support\Facades\File;


class DropPayService
{
    private $applicationKey;
    private $applicationSecret;
    private $connectionCode;
    private $accessToken;
    private $refreshToken;
    private $expiresKey;
    private $posId;
    private $httpClient;

   public function __construct(){
   		$this->applicationKey = env('DROPPAY_APP_KEY');
   		$this->applicationSecret = env('DROPPAY_APP_SECRET');
   		$this->connectionCode = env('DROPPAY_CONNECTION_CODE');
   		$this->posId = env('DROPPAY_CONNECTION_CODE');
        $this->httpClient = new Client();
        $this->getAccesKeys();
   }



   public function getAccessToken(){
        $response = $this->httpClient->post('https://api.drop-pay.io/oa2/v1/ac/token',[
            GuzzleHttp\RequestOptions::JSON => [
                'grant_type' => 'authorization_code',
                'code' => $this->connectionCode,
                'client_id' => $this->applicationKey,
                'client_secret' => $this->applicationSecret,
                'scope' => 'app'
            ]

        ]);

        $responseJson = json_decode($response->getBody());
        $this->accessToken = $responseJson->access_token;
        $this->refreshToken = $responseJson->refresh_token;
        $this->expiresKey = $responseJson->expires_in;
        $this->saveAccessKeys();
   }

   public function updateAccessToken(){
       $headers = [
           'Authorization' => 'Bearer '.$this->accessToken,
           'Accept' => 'application/json',
       ];

       $response = $this->httpClient->put('https://api.drop-pay.io/oa2/v1/ac/token',[
           GuzzleHttp\RequestOptions::JSON => [
               'grant_type' => 'authorization_code',
               'code' => $this->connectionCode,
               'client_id' => $this->applicationKey,
               'client_secret' => $this->applicationSecret,
               'scope' => 'app',
               'refresh_token' => $this->refreshToken,
           ]
       ]);

       $responseJson = json_decode($response->getBody());
       $this->accessToken = $response->access_token;
       $this->refreshToken = $response->refresh_token;
       $this->expiresKey = $responseJson->expires_in;
   }



    public function createConnectionCode(){
         $headers = [
                   'Authorization' => 'Bearer '.$this->accessToken,
                   'Accept' => 'application/json',
          ];

          $response = $this->httpClient->post('https://api.drop-pay.io/oa2/v1/connection',[
            'headers' => $headers,
            GuzzleHttp\RequestOptions::JSON => [
                "webhooks" => [
                    "ALL" => route('webhook.droppay_user_connection'),
                ],
                "loopback_uri" => "#",
            ]
          ]);

          $responseJson = json_decode($response->getBody());
          return $responseJson->id;
    }

    public function createStoreConnectionCode(){
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
        ];

        $response = $this->httpClient->post('https://api.drop-pay.io/oa2/v1/connection',[
            'headers' => $headers,
            GuzzleHttp\RequestOptions::JSON => [
                "webhooks" => [
                    "ALL" => route('webhook.droppay_store_connection'),
                ],
                "loopback_uri" => "#",
            ]
        ]);

        $responseJson = json_decode($response->getBody());
        return $responseJson->id;
    }

    public function checkConnectionGrant($connectionCode){
        $headers = [
           'Authorization' => 'Bearer '.$this->accessToken,
           'Accept' => 'application/json',
        ];

        $response = $this->httpClient->get('https://api.drop-pay.io/oa2/v1/connection/'.$connectionCode, [
            'headers' => $headers
        ]);

        $jsonResponse = json_decode($response->getBody());
        return $jsonResponse->status;
    }


    public function deleteConnectionChallenge($connectionCode){
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
        ];

       try{
           $this->httpClient->delete("https://api.drop-pay.io/oa2/v1/connection/".$connectionCode,[
               'headers' => $headers
           ]);
       } catch(\Exception $e){
       }
    }

    public function createPullRequestForStore(){
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
        ];

        $response = $this->httpClient->post('https://api.drop-pay.io/bank/v1/pull',[
            'headers' => $headers,
            GuzzleHttp\RequestOptions::JSON => [
                "description" => "Autorizzazione Cashback",
                "transfer_amount_policy" => "OPEN",
                "policy" => "TRANSFERABLE",
                "date_end" => Carbon::now()->addYears(2)->format("20y-m-d"),
                "webhooks" => [
                    "all" => route('webhook.droppay_store_pull'),
                ],
                "recipient" => [
                    "id" => "DPI1349JMZV6J",
                    "username" => "393356098390",
                    "account_iban" => "IT48Z3606401600I14379871008",
                    "account" => "IT48Z3606401600I14379871008"
                ],
                "status" => "READY"
            ]
        ]);

        $jsonResponse = json_decode($response->getBody());
        return $jsonResponse->id;
    }

    public function checkPullStatus($pullId){
        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
        ];

        $response = $this->httpClient->get('https://api.drop-pay.io/bank/v1/pull/'.$pullId, [
            'headers' => $headers
        ]);

        $jsonResponse = json_decode($response->getBody());
        return $jsonResponse->status;
    }


    public function authenticateAsStore($storeConnectionCode){
        $response = $this->httpClient->post('https://api.drop-pay.io/oa2/v1/ac/token',[
            GuzzleHttp\RequestOptions::JSON => [
                'grant_type' => 'authorization_code',
                'code' => $storeConnectionCode,
                'client_id' => $this->applicationKey,
                'client_secret' => $this->applicationSecret,
                'scope' => 'app'
            ]
        ]);
        $responseJson = json_decode($response->getBody());
        return $responseJson->access_token;
    }

    public function getStoreDetails($accessToken){
       $headers = [
         'Authorization' => 'Bearer '.$accessToken,
         'Accept' => 'application/json',
       ];
       $response = $this->httpClient->get('https://api.drop-pay.io/bank/v1/registry/account',['headers'=>$headers]);

       return json_decode($response->getBody());

    }

    public function createPullRequestByStore($storeConnectionCode,$import,$storeName){ //ONLINE TRANSACTION
       $storeAccesToken = $this->authenticateAsStore($storeConnectionCode);
       $storeDetails = $this->getStoreDetails($storeAccesToken);

        $headers = [
            'Authorization' => 'Bearer '.$storeAccesToken,
            'Accept' => 'application/json',
        ];

        try{
            $response = $this->httpClient->post('https://api.drop-pay.io/bank/v1/pull',[
                'headers' => $headers,
                GuzzleHttp\RequestOptions::JSON => [
                    "description" => "Acquisto Online",
                    "transfer_amount_policy" => "FIXED",
                    "policy" => "TRANSFERRED",
                    "transfer_amount" => $import,
                    "webhooks" => [
                        "all" => route('webhook.droppay_store_online_tr'),
                    ],
                    "recipient" => [
                        "id" => $storeDetails->id,
                        "username" => $storeName,
                        "account_iban" => $storeDetails->bank_account->iban,
                        "account" => $storeDetails->bank_account->iban,
                    ],
                    "status" => "READY"
                ]
            ]);
        } catch(\Exception $exception){
            return $exception->getMessage();
        }

        $responseInJson = json_decode($response->getBody());
        return $responseInJson->id;

    }



    public function createPullRequestByStoreOffline($storeConnectionCode,$import,$storeName){ //OFFLINE TRANSACTION
        $storeAccesToken = $this->authenticateAsStore($storeConnectionCode);
        $storeDetails = $this->getStoreDetails($storeAccesToken);

        $headers = [
            'Authorization' => 'Bearer '.$storeAccesToken,
            'Accept' => 'application/json',
        ];

        try{
            $response = $this->httpClient->post('https://api.drop-pay.io/bank/v1/pull',[
                'headers' => $headers,
                GuzzleHttp\RequestOptions::JSON => [
                    "description" => "Acquisto da ".$storeName,
                    "transfer_amount_policy" => "FIXED",
                    "policy" => "TRANSFERRED",
                    "transfer_amount" => $import,
                    "webhooks" => [
                        "all" => route('webhook.droppay_store_offline_tr'),
                    ],
                    "recipient" => [
                        "id" => $storeDetails->id,
                        "username" => $storeName,
                        "account_iban" => $storeDetails->bank_account->iban,
                        "account" => $storeDetails->bank_account->iban,
                    ],
                    'loopback_uri' => 'free://www.freeback.it',
                    "status" => "READY"
                ]
            ]);
        } catch(\Exception $exception){
            return $exception->getMessage();
        }

        $responseInJson = json_decode($response->getBody());
        return $responseInJson->id;
    }


    public function checkPullStatusByStore($storeConnectionCode, $pullId){
       $storeAccessToken = $this->authenticateAsStore($storeConnectionCode);
        $headers = [
            'Authorization' => 'Bearer '.$storeAccessToken,
            'Accept' => 'application/json',
        ];

        $response = $this->httpClient->get('https://api.drop-pay.io/bank/v1/pull/'.$pullId, [
            'headers' => $headers
        ]);

        $jsonResponse = json_decode($response->getBody());
        return $jsonResponse->status;
    }



    public function cashbackPullRequest($storeId,$import){
       $store = Store::where('id',$storeId)->firstOrFail();
       $paymentConfig = StorePaymentConfig::where('store_id',$store->id)->firstOrFail();

        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
        ];

       try{
            $response = $this->httpClient->post('https://api.drop-pay.io/bank/v1/pull/'.$paymentConfig->dp_pull_id.'/transfer',[
                'headers' => $headers,
                GuzzleHttp\RequestOptions::JSON => [
                    "description" => "Cashback",
                    "amount" => $import,
                ]
            ]);
        } catch(\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function authenticateAsUser($userConnectionCode){
        $response = $this->httpClient->post('https://api.drop-pay.io/oa2/v1/ac/token',[
            GuzzleHttp\RequestOptions::JSON => [
                'grant_type' => 'authorization_code',
                'code' => $userConnectionCode,
                'client_id' => $this->applicationKey,
                'client_secret' => $this->applicationSecret,
                'scope' => 'app'
            ]
        ]);
        $responseJson = json_decode($response->getBody());
        return $responseJson->access_token;
    }


    public function getUserDetails($accessToken){
        $headers = [
            'Authorization' => 'Bearer '.$accessToken,
            'Accept' => 'application/json',
        ];
        $response = $this->httpClient->get('https://api.drop-pay.io/bank/v1/registry/account',['headers'=>$headers]);
        return json_decode($response->getBody());
    }


    public function distributeCashback($userId,$import){
       $user = User::where('id',$userId)->firstOrFail();
       $userPaymentConfig = UserPaymentConfig::where('user_id',$user->id)->firstOrFail();
       $userConnectionCode = $userPaymentConfig->dp_connection_code;
       $userAccessToken = $this->authenticateAsUser($userConnectionCode);
       $userDetails = $this->getUserDetails($userAccessToken);

        $headers = [
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
        ];

        try{
            $response = $this->httpClient->post('https://api.drop-pay.io/bank/v1/push',[
                'headers' => $headers,
                GuzzleHttp\RequestOptions::JSON => [
                    "amount" => $import,
                    "description" => "Cashback da Freeback",
                    "tarnsfer_description" => "Cashback da Freeback",
                    "recipient" => [
                        'account' => $userDetails->bank_account->iban,
                     ],
                    "source" => [
                        "id" => "DPI1349JMZV6J",
                        "username" => "393356098390",
                        "account_iban" => "IT48Z3606401600I14379871008",
                        "account" => "IT48Z3606401600I14379871008"
                    ],
                    "status" => "READY"
                ]
            ]);
            File::put('distribute_request.txt',$response->getBody());
        } catch(\Exception $exception){
            //return $exception->getMessage();
            File::put('distribute_error.txt',$exception->getMessage());
            return $exception->getMessage();
        }
    }


    public function saveAccessKeys(){
       $dropPayConfig = DropPayConfiguration::create([
           'access_token' => $this->accessToken,
           'refresh_token' => $this->refreshToken,
           'expires_in' => $this->expiresKey,
           'valid' => 1,
       ]);
    }

    public function getAccesKeys(){
       $dropPayConfigCount = DropPayConfiguration::where('valid',1)->count();
       if($dropPayConfigCount == 1) {
           $dropPayConfig = DropPayConfiguration::where('valid',1)->first();
           $this->accessToken = $dropPayConfig->access_token;
           $this->refreshToken = $dropPayConfig->refresh_token;
           $this->expiresKey = $dropPayConfig->expires_in;
       } else {
           $dropPayConfigs = DropPayConfiguration::all();
           foreach($dropPayConfigs as $dp) {
               $dp->valid = 0;
               $dp->save();
           }
           $this->getAccessToken();
       }
    }

}




