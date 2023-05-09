<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function home() {
        $save_count = count(Saved::get());
        $admin_count = count(User::where('role','admin')->get());
        $user_count = count(User::where('role','user')->get());
        $post_count = count(Post::get());
        return view('admin.home',compact('save_count','admin_count','user_count','post_count'));
    }
}
