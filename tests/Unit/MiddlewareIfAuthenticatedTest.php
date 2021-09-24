<?php

declare(strict_types=1);

namespace Tests\Unit;

use                                       Tests\TestCase;
use                         App\Http\Middleware\RedirectIfAuthenticated as Middleware;
use                             Illuminate\Http\Request;

class MiddlewareIfAuthenticatedTest extends TestCase
{
    public function testGuest()
    {

        $request = new Request;
        $s_proceed = 'plese, go on';

        $middleware = new Middleware;
        $response = $middleware->handle($request, function () use ($s_proceed) { return $s_proceed; }, 'web');
        $this->assertEquals($response, $s_proceed);
    }
/*
    public function testGuest()
    {

        $request = new Request;
        $s_proceed = 'plese, go on';

#        $request->merge([
#            'title' => 'Title is in mixed CASE'
#        ]);

        $middleware = new Middleware;

#        $middleware->handle($request, function ($req) {
#            $this->assertEquals('Title  Is In Mixed Case', $req->title);
#        });


#$middleware->handle($request, function($r) use ($after){
#dd($after);
#$this->assertEquals('lift',       $r->input('command'));
#$this->assertEquals('foo bar baz',$r->input('text'));
#});


$response = $middleware->handle($request, function () use ($s_proceed) { return $s_proceed; }, 'web');
dd($response);

#$this->assertEquals($response->getStatusCode(), 302); // для редиректа
#$this->assertEquals($response, null); // ничего не делаем с объектом request

    }
*/
}
