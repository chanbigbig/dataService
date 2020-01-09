<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function test()
    {
        Log::info("hello-world");
        return $this->success();
    }

}