<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index()
    {
        // $users = User::all();
        $users = DB::select('select * from users');
        return $users;
    }
}
