<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\Topic;
use App\Models\BlackList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserPostController extends Controller
{
    public function home() {
        $topics = Topic::get();
        $posts = Post::select('posts.*','users.name as admin_name','topics.name as topic_name','users.image as profile_image')
        ->where('admin_id',Auth::user()->id)
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('updated_at','desc')
        ->get();
        // dd($posts->toArray());
        return view('user.post.createPost',compact('topics','posts'));
    }

    //Create Post
    public function create(Request $request) {
        if (Auth::user()->id==$request->adminId) {
            $this->postValidationCheck($request);
            $post = $this->postGetData($request);
            if($request->hasFile('postImage')) {
                $postImageName = uniqid(). '_' . $request->file('postImage')->getClientOriginalName();
                $post['image'] = $postImageName;
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
        Validator::make($request->all(),[
            'desc' => 'required|min:10',
            'topicId' => 'required',
            'image' => 'mimes:png,jpg,jpeg,JPEG|file'
        ])->validate();
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

    //edit page
    public function editPage(Request $request) {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('created_at','desc')->get();
        $post = $post->where('id',$request->id)->first();
        $topics = Topic::get();
        // dd($post->toArray(),$topics->toArray());
        return view('user.post.edit',compact('post','topics'));
    }

    //update post
    public function edit(Request $request) {
        $post = Post::find($request->postId);
        // dd(Auth::user()->id);
        // dd(Auth::user()->id === $post->admin_id);

        if (Auth::user()->id == $post->admin_id) {
            $this->postValidationCheck($request);
            $data = $this->postGetData($request);
            //image check
            if($request->hasFile('postImage')) {
                $dbImage = post::select('image')->where('id',$id)->first();
                $dbImage = $dbImage->image;
            if($dbImage!=null) {
                Storage::delete('public/'.$dbImage);
            }
            $imageName = uniqid() . '_' . $request->file('postImage')->getClientOriginalName();
            $data['image'] = $imageName;
            $request->file('postImage')->storeAs('public/',$imageName);
        }
        // dd($data);
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
