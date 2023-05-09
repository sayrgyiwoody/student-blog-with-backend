<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Direct to dashboard to decide role
    public function dashboard() {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin#home');
        }
        if (Auth::user()->role == 'user') {
            return redirect()->route('user#home');
        }
    }
}
