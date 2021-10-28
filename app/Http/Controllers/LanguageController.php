<?php

namespace App\Http\Controllers;

use Cookie;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request, $locale)
    {
        if (in_array($locale, config('translatable.locales'))) {
            session(['lang' => $locale]);
            app()->setLocale($locale);
#            setlocale(LC_TIME, $locale);

			$cookie_name='lang';
			$cookie_value=$locale;
			$cookie_expired_in=2629800;//in mins = 5 years
			$cookie_path=config('session.path'); // available to all pages of website.
			$cookie_host=(config('session.domain') ?? $request->getHttpHost());
			$http_only=config('session.http_only');
			$secure=config('session.secure');
			$raw=false;
//			$samesite=config('session.same_site');
			$my_cookie = cookie($cookie_name, $cookie_value, $cookie_expired_in,$cookie_path,$cookie_host,$http_only);
			Cookie::queue($my_cookie);
        }
        return back()->withCookie($my_cookie);
    }
}
