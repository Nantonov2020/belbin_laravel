<?php

namespace App\Http\Middleware;

use App\Models\HRworker;
use Closure;
use Illuminate\Http\Request;

class HRmakeSession
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
        $user = \Auth::user();
        $idCompany = (HRworker::where('user_id', $user->id)->first())->company_id;
        session(['idCompanyForHR' => $idCompany]);

        return $next($request);
    }
}
