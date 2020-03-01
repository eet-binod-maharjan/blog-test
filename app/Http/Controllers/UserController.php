<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($name)
    {
        $user = User::findByName($name);
        $tweets = $user->tweets;
        return view('users.show',compact('tweets'));
    }
}
