<?php

namespace App\Http\Middleware;

use App\Models\HRworker;
use Closure;
use Illuminate\Http\Request;

class HR
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //dd($request->idCompany);
        $user = \Auth::user();
        $positionsInHRList = HRworker::where('user_id',$user->id)->get();

        if(count($positionsInHRList) == 0) {
            return abort(404);
        }

        return $next($request);
    }
}
