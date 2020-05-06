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
			$cookie_path='/'; // available to all pages of website.
			$cookie_host=$request->getHttpHost(); // domain or website you are setting this cookie.
			$http_only=false;
			$secure=false;
			$raw=false;
			$samesite=null;
			$my_cookie = cookie($cookie_name, $cookie_value, $cookie_expired_in,$cookie_path,$cookie_host,$http_only);
			Cookie::queue($my_cookie);
        }
        return back()->withCookie($my_cookie);
    }
}
