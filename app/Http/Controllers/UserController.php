<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home() {
        $posts = Post::when(request('searchKey'),function($query){
            $query->where('desc','like','%'.request('searchKey').'%');
        })
        ->select('posts.*','users.gender as admin_gender','users.name as admin_name','users.image as profile_image','topics.name as topic_name')
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('created_at','desc')->get();
        $topics = Topic::orderBy('created_at','desc')->get();

        return view('user.home',compact('posts','topics'));
    }

    public function view($id) {
        $post = Post::select('posts.*','users.gender as admin_gender','users.name as admin_name','users.image as profile_image')
        ->leftJoin('users','posts.admin_id','users.id')
        ->where('posts.id',$id)->first();
        $topic_name = Topic::where('id',$post->topic_id)->first();
        $topic_name =$topic_name->name;
        $topics = Topic::get();
        return view('user.view',compact('post','topic_name','topics'));
    }

    //Filter with Topic
    public function topicFilter($topicId) {
        $posts = Post::select('posts.*','users.gender as admin_gender','users.name as admin_name','users.image as profile_image','topics.name as topic_name')
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('created_at','desc')->where('topic_id',$topicId)->get();
        $topics = Topic::orderBy('created_at','desc')->get();
        return view('user.home',compact('posts','topics'));
    }
}
