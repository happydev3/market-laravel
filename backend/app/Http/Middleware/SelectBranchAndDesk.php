<?php

namespace App\Http\Middleware;

use App\Models\StoreBranch;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SelectBranchAndDesk
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
        if(Auth::guard('store')->check()){
            if((Session::has('branch_id')) && (Session::has('desk_id'))){
                $branchId = Session::get('branch_id');
                $deskId = Session::get('desk_id');

                $branch = StoreBranch::where('id',$branchId)->where('active',1)->first();
                if($branch->store_id == Auth::guard('store')->user()->id){
                    if($branch->cashDesks()->where('id',$deskId)->where('active',1)->first()){
                        return $next($request);
                    }
                }
            } else {
                return redirect()->route('store.branch.select');
            }
        }

        return $next($request);

    }
}
