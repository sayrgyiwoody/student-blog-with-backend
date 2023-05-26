<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\Topic;
use App\Models\BlackList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserPostController extends Controller
{
    public function home(Request $request) {
        $token = Str::random(32);

        $request->session()->put('post_token', $token);

        $topics = Topic::get();
        $posts = Post::select('posts.*', 'users.name as admin_name', 'topics.name as topic_name', 'users.image as profile_image')
            ->where('admin_id', Auth::user()->id)
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->leftJoin('topics', 'posts.topic_id', 'topics.id')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user.post.createPost', compact('topics', 'posts', 'token'));
    }


    //edit page
    public function editPage(Request $request , $id) {
        $token = Str::random(32);

        $request->session()->put('post_token', $token);
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('created_at','desc')->get();
        $post = $post->where('id',$id)->first();
        $topics = Topic::get();
        return view('user.post.edit',compact('post','topics','token'));
    }

    //Create Post
    public function create(Request $request) {
        if (Auth::user()->id==$request->adminId) {
            $token = $request->input('token');
            $storedToken = $request->session()->get('post_token');

            // Validate the one-time token
            if ($token !== $storedToken) {
                return back()->with(['error' => 'Invalid token.']);
            }
            $this->postValidationCheck($request);
            $post = $this->postGetData($request);
            if($request->hasFile('postImage')) {
                $postImageName = md5($request->file('postImage')->getClientOriginalName()). ".jpg";
                $post['image'] = $postImageName ;
                $request->file('postImage')->storeAs('public/',$postImageName);
            }
            $currentDate = Carbon::now()->format('Y-m-d');
            $maxPostsPerDay = 5;
            $postCount = Post::where('admin_id', Auth::user()->id)
            ->whereDate('created_at', $currentDate)
            ->count();
            if ($postCount >= $maxPostsPerDay) {
                return back()->with(['error'=>'Maximum posts reached for today']);
            }elseif($postCount < $maxPostsPerDay) {
                Post::create($post);

            return redirect()->route('user#postHome')->with(['message'=>'Post created successfully']);
            }
        }else {
            BlackList::create(['email'=>Auth::user()->email]);
            User::where('id',Auth::user()->id)->delete();
            Post::where('admin_id',Auth::user()->id)->delete();
            Saved::where('user_id',Auth::user()->id)->delete();
            Auth::logout();
            return redirect()->route('login')->with(['reject'=>'I know what you doing']);
        }

    }

    //validate post data
    private function postValidationCheck($request) {
        $validator = Validator::make($request->all(), [
            'desc' => 'required|min:10|max:10000',
            'topicId' => 'required',
            'token' => 'required|in:' . $request->session()->get('post_token'),
            'image' => 'mimes:png,jpg,jpeg,gif|file'
        ])->after(function ($validator) use ($request) {
            $image = $request->file('postImage');
            if ($image) {
                $extension = strtolower($image->getClientOriginalExtension());
                $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];

                if (!in_array($extension, $allowedExtensions)) {
                    $validator->errors()->add('postImage', 'Invalid image file.');
                }
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Validation passed, continue processing the post creation
    }


    //get data from post input
    private function postGetData($request) {
        return [
            'id' => $request->postId,
            'admin_id' => $request->adminId,
            'desc' => $request->desc,
            'topic_id' => $request->topicId,
        ];
    }



    //update post
    public function edit(Request $request) {

        $post = Post::find($request->postId);


        if (Auth::user()->id == $post->admin_id) {
            $token = $request->input('token');

            $storedToken = $request->session()->get('post_token');
            // Validate the one-time token
            if ($token !== $storedToken) {
                return back()->with(['error' => 'Invalid token.']);
            }

            $this->postValidationCheck($request);
            $data = $this->postGetData($request);

            if($request->hasFile('postImage')) {
                $dbImage = post::select('image')->where('id',$request->postId)->first();
                $dbImage = $dbImage->image;
                // dd($dbImage);
            if($dbImage!=null) {
                Storage::delete('public/'.$dbImage);
            }
            $postImageName = md5($request->file('postImage')->getClientOriginalName()). ".jpg";

            $data['image'] = $postImageName ;
            $request->file('postImage')->storeAs('public/',$postImageName);
            }

        post::where('id',$data['id'])->update($data);

        return redirect()->route('user#postHome')->with(['message'=>'Post edited successfully']);
        } else {
            BlackList::create(['email'=>Auth::user()->email]);
            User::where('id',Auth::user()->id)->delete();
            Post::where('admin_id',Auth::user()->id)->delete();
            Saved::where('user_id',Auth::user()->id)->delete();
            Auth::logout();
            return redirect()->route('login')->with(['reject'=>'I know what you doing']);
        }

    }

    //delete post
    public function delete(Request $request) {
        $post = Post::where('id',$request->post_id)->first();

        if (Auth::user()->id == $post->admin_id) {
            $dbImage = Post::select('image')->where('id',$request->post_id)->first();
            $dbImage = $dbImage->image;
            if($dbImage!=null) {
                Storage::delete('public/'.$dbImage);
            }
        Saved::where('post_id',$request->post_id)->delete();
        Post::where('id',$request->post_id)->delete();
        return response()->json(200);
        }else {
            BlackList::create(['email'=>Auth::user()->email]);
            User::where('id',Auth::user()->id)->delete();
            Post::where('admin_id',Auth::user()->id)->delete();
            Saved::where('user_id',Auth::user()->id)->delete();
            Auth::logout();
            return redirect()->route('login')->with(['reject'=>'I know what you doing']);
        }

    }
}
