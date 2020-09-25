<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\SearchQuery;
use Illuminate\Support\Facades\Auth;

class SearchMiddleware
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

        if(isset($request['query']) && ($request['query'] != "")){
            $userId = Auth::guard('web')->check() ? Auth::guard('web')->user()->id : null;
            SearchQuery::create([
                'user_id' => $userId,
                'search_query' => $request['query'],
                'search_type' => isset($request['category']) ? "combined" : 'free_text',
            ]);
        }


        return $next($request);
    }
}
