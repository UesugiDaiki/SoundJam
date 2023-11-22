<?php

namespace App\Http\Controllers;

class HelloController extends Controller
{
    public function hello(): string
    {
        return 'Hello World';
    }
}
