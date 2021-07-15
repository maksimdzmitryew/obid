<?php

declare(strict_types=1);

namespace Tests\Unit;

use                                       Tests\TestCase;
use                         App\Http\Middleware\TrimStrings as Middleware;
use                             Illuminate\Http\Request;

class MiddlewareTrimStringsTest extends TestCase
{

    protected $s_sample = '  String Surrounded by Spaces  ';

    public function testTransformParameterAndTrimSurroundingSpaces() : void
    {
        $request = new Request;

        $request->merge([
            'last_name' => $this->s_sample
        ]);

        $middleware = new Middleware;

        $middleware->handle($request, function ($req) {
            $this->assertEquals(trim($this->s_sample), $req->last_name);
        });
    }

    public function testKeepWhitespacesIfParameterNameIsListedAsExclusion() : void
    {
        $request = new Request;

        $request->merge([
                'password' => $this->s_sample
        ]);

        $middleware = new Middleware;

        $middleware->handle($request, function ($req) {
            $this->assertEquals($this->s_sample, $req->password);
        });
    }

}
