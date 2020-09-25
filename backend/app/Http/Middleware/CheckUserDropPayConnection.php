<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\External\DropPayService;

class CheckUserDropPayConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if($user->paymentConfiguration->dp_connected == 1){
                $dropPay = new DropPayService();
                $connectionStatus = $dropPay->checkConnectionGrant($user->paymentConfiguration->dp_connection_id);
                switch($connectionStatus) {
                    case "GRANTED":
                        {
                            return $next($request);
                        }

                    case "WAITING":
                        {
                            return redirect()->route('user.droppay');
                            break;
                        }

                    case "EXPIERED":
                        {
                            $this->createNewConnectionAndSave($dropPay, $user);
                            break;
                        }

                    case "CANCELLED":
                        {
                            $this->createNewConnectionAndSave($dropPay, $user);
                            break;
                        }

                    case "REVOKED":
                        {
                            $this->createNewConnectionAndSave($dropPay, $user);
                            break;
                        }

                    case "REFUSED":
                        {
                            $this->createNewConnectionAndSave($dropPay, $user);
                            break;
                        }
                }
            }
            else{
                return redirect()->route('user.droppay');
            }
        }
        return $next($request);
    }

    private function createNewConnectionAndSave($dropPay,$user){
        $connectionId = $dropPay->createConnectionCode();
        $paymentConfiguration = $user->paymentConfiguration;
        $paymentConfiguration->dp_connected = 0;
        $paymentConfiguration->dp_connection_id = $connectionId;
        $paymentConfiguration->dp_connection_code = null;
        $paymentConfiguration->save();
        return redirect()->route('user.droppay');
    }
}
