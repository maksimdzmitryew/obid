<?php
namespace App\Http\Middleware;

use Closure;
use Config;
use Cookie;

use Illuminate\Session\Middleware\StartSession as BaseStartSession;

class StartSessionMiddleware extends BaseStartSession
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        # http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm
        if (Cookie::get( config('cookie-consent.cookie_name') ) === null)
        {
            Config::set('session.driver', 'array');
        }
        return parent::handle($request, $next);
    }
}