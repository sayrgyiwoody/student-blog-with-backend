<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // public function home() {
    //     $posts = Post::when(request('searchKey'),function($query){
    //         $query->where('desc','like','%'.request('searchKey').'%');
    //     })
    //     ->select('posts.*','users.gender as admin_gender','users.role as role','users.name as admin_name','users.image as profile_image','topics.name as topic_name')
    //     ->leftJoin('users','posts.admin_id','users.id')
    //     ->leftJoin('topics','posts.topic_id','topics.id')
    //     ->orderBy('created_at','desc')->get();
    //     $topics = Topic::orderBy('created_at','desc')->get();
    //     $saveStatus = [];
    //     foreach($posts as $post) {
    //         $status = Saved::where('user_id', Auth::user()->id)
    //             ->where('post_id', $post->id)
    //             ->exists();

    //         $saveStatus[$post->id] = $status;
    //     }
    //     return view('user.home',compact('posts','topics','saveStatus'));
    // }

    public function home() {
        $searchKey = request('searchKey');
        $query = Post::select('posts.*', 'users.gender as admin_gender', 'users.role as role', 'users.name as admin_name', 'users.image as profile_image', 'topics.name as topic_name')
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->leftJoin('topics', 'posts.topic_id', 'topics.id')
            ->orderBy('posts.created_at', 'desc');
        if ($searchKey) {
            $query->where('desc', 'like', '%' . $searchKey . '%');
        }
        $posts = $query->paginate(10);
        $topics = Topic::orderBy('created_at', 'desc')->get();
        $saveStatus = [];
        // dd(Auth::check());
        if(Auth::check()) {
            foreach ($posts as $post) {
                $status = Saved::where('user_id', Auth::user()->id)
                    ->where('post_id', $post->id)
                    ->exists();

                $saveStatus[$post->id] = $status;
            }
        }
        return view('user.home', compact('posts', 'topics', 'saveStatus'));
    }


    public function view($id) {
        $post = Post::select('posts.*','users.role as role','users.gender as admin_gender','users.name as admin_name','users.image as profile_image')
        ->leftJoin('users','posts.admin_id','users.id')
        ->where('posts.id',$id)->first();
        $topic_name = Topic::where('id',$post->topic_id)->first();
        $topic_name =$topic_name->name;
        $topics = Topic::get();
        return view('user.view',compact('post','topic_name','topics'));
    }

    //Filter with Topic
    public function topicFilter($topicId) {
        $posts = Post::select('posts.*','users.role as role','users.gender as admin_gender','users.name as admin_name','users.image as profile_image','topics.name as topic_name')
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('created_at','desc')->where('topic_id',$topicId)->paginate(10);
        $saveStatus = [];
        if(Auth::check()) {
            foreach($posts as $post) {
                $status = Saved::where('user_id', Auth::user()->id)
                    ->where('post_id', $post->id)
                    ->exists();

                $saveStatus[$post->id] = $status;
            }
        }
        $topics = Topic::orderBy('created_at','desc')->get();
        return view('user.home',compact('posts','topics','saveStatus'));
    }


    public function sendResetLink(Request $request) {
        Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ])->validate();

        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // $token = DB::table('password_reset_tokens')->select('token')->where('email',$request->email)->first();
        // dd($token);

        $action_link = route('reset.password.form',['token'=>$token,'email'=>$request->email]);
        $body = "We are received a request to reset the password for <b>UCSY students blog</b> account associated with " .$request->email .
        ". You can reset your password by clicking the link below";

        Mail::send('email-forgot',['action_link'=>$action_link,'body'=>$body],function($message) use ($request){
            $message->from('waiyanwoody@gmail.com','admin');
            $message->to($request->email,'admin')
                    ->subject('Reset Password');
        });

        return back()->with('success','We have e-mailed your password reset link!');
    }

    public function showResetForm(Request $request, $token = null) {
        return view('auth.reset-password')->with(['token'=>$token,'email'=>$request->email]);
    }

    public function resetPassword(Request $request) {
        Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ])->validate();

        $check_token = \DB::table('password_reset_tokens')
        ->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if(!$check_token) {
            return back()->withInput()->with('fail','Invalid token');
        }else {
            User::where('email',$request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

            \DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email
            ])->delete();

            return redirect()->route('login')->with('info','Your password has been changed! You can login with new password ')
            ->with('verifiedEmail',$request->email);
        }

    }
}
