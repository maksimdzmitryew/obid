<?php

namespace App\Http\Controllers;

use App\Festival;
use Illuminate\Http\Request;

class TestController extends Controller
{
    function index(){
        return view('layouts.test', [
            'array' => [1,2,3]
        ]);
    }
}
