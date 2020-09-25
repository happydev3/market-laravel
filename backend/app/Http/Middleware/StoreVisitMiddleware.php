<?php

namespace App\Http\Middleware;

use App\Models\StoreVisits;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class StoreVisitMiddleware
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
        if(isset($request['permalink'])){
            $storeVisit = new StoreVisits();
            if(Auth::guard('web')->check()){
                $storeVisit->user_id = Auth::guard('web')->user()->id;
            }
            $store = Store::where('permalink',$request['permalink'])->first();
            if($store){
                $storeVisit->store_id = $store->id;
                $storeVisit->save();
            }
        }

        return $next($request);
    }
}
