<?php

namespace App\Http\Controllers\Api;

class TestController
{
    public function index()
    {
        return response()->json(['message' => 'Hello, World!']);
    }
}
