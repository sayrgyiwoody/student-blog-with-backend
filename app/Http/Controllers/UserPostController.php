<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
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
        $this->postValidationCheck($request);
        $post = $this->postGetData($request);
        if($request->hasFile('postImage')) {
            $postImageName = uniqid(). '_' . $request->file('postImage')->getClientOriginalName();
            $post['image'] = $postImageName;
            $request->file('postImage')->storeAs('public/',$postImageName);
        }
        Post::create($post);
        return redirect()->route('user#postHome')->with(['message'=>'Post created successfully']);
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
            'admin_id' => $request->adminId,
            'desc' => $request->desc,
            'topic_id' => $request->topicId
        ];
    }

    //edit page
    public function editPage($id) {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
        ->leftJoin('users','posts.admin_id','users.id')
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->orderBy('created_at','desc')->get();
        $post = $post->where('id',$id)->first();
        $topics = Topic::get();
        return view('user.post.edit',compact('post','topics'));
    }

    //update post
    public function edit(Request $request,$id) {
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
        post::where('id',$id)->update($data);
        return redirect()->route('user#postHome')->with(['message'=>'Post edited successfully']);
    }

    //delete post
    public function delete(Request $request) {
        $dbImage = Post::select('image')->where('id',$request->post_id)->first();
        $dbImage = $dbImage->image;
            if($dbImage!=null) {
                Storage::delete('public/'.$dbImage);
            }
        Saved::where('post_id',$request->post_id)->delete();
        Post::where('id',$request->post_id)->delete();
        return response()->json(200);
    }
}
