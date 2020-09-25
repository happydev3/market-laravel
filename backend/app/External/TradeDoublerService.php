<?php

namespace App\External;

use GuzzleHttp\Client;
use GuzzleHttp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class TradeDoublerService {


    private $tdToken;
    private $httpClient;



    public function __construct()
    {
        $this->tdToken = env("TD_TOKEN");
        $this->httpClient = new Client();
    }

    public function createListener($userName,$programId,$siteId,$userId){
        $createListenerUrl = "https://api.tradedoubler.com/1.0/conversions/subscriptions?token=".$this->tdToken;

        $headers = [
            'Content-Type' => 'application/json',
        ];


        $response = $this->httpClient->post($createListenerUrl,[
            'headers' => $headers,
            GuzzleHttp\RequestOptions::JSON => [
                'subscriptionName' => $userName."_subscription_".str_random(10),
                'filter' => [
                    "programIds" => [$programId],
                    "siteIds" => [$siteId],
                    "eventTypeIds" => [5,10],
                    "messageTypeIds" => [1,3,4,5,6,8,9],
                ],
                "receivers" => [
                    [
                        "httpMethod" => "GET",
                        "receiverUrl" => URL::to('/')."/webhook/td/notify/".$userId. '/?import=${publisherCommission}&program_id=${programId}&advertiser=${advertiserId}&order_value=${orderValue}&transaction_id=${transactionId}',
                    ]
                ],
                "currencyConversion" => [
                    "to" => "EUR"
                ],
            ]
        ]);

        $jsonResponse = json_decode($response->getBody());
        return $jsonResponse->subscriptionId;
    }
}