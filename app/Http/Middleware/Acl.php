<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Libraries\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //
        $user =  auth::user();
        $role = Helper::role($user);
        // echo '<pre>'; print_r('here'); exit;
        if($role == 'SuperAdmin')
        {
            return $next($request);
        }

        if($role == 'Buyer')
        {
            $controllerAction = class_basename(Route::currentRouteAction());
// echo '<pre>'; print_r($controllerAction); exit;
            if(strpos($controllerAction, 'data'))
            {
                return $next($request);
            }

            if( $controllerAction == 'PropertyController@index')
            {
                return $next($request);

            }

            if( $controllerAction == 'BidController@bidBuyer')
            {
                return $next($request);

            }

            return abort(403);
        }

        if($role == 'Agent')
        {

            $controllerAction = class_basename(Route::currentRouteAction());

            if(strpos($controllerAction, 'data'))
            {
                return $next($request);
            }

            if( $controllerAction == 'PropertyController@index')
            {
                return $next($request);

            }

            if( $controllerAction == 'PropertyController@show')
            {
                return $next($request);
            }

            if( $controllerAction == 'PropertyController@store')
            {
                return $next($request);

            }


            ////Bid

            if( $controllerAction == 'BidController@index')
            {
                return $next($request);

            }

            if( $controllerAction == 'BidController@status')
            {
                return $next($request);

            }

            return abort(403);
        }
    }
}
