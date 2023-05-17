<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //Direct post list page
    public function listPage() {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
        ->when(request('searchKey'),function($query){
            $query->orWhere('topics.name','like','%'.request('searchKey').'%')
            ->orWhere('posts.desc','like','%'.request('searchKey').'%');
        })
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->leftJoin('users','posts.admin_id','users.id')
        ->orderBy('posts.created_at','desc')->paginate(5);
        return view('admin.post.list',compact('post'));
    }

    //Filter Ascending
    public function filterAsc() {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
        ->when(request('searchKey'),function($query){
            $query->orWhere('topics.name','like','%'.request('searchKey').'%')
            ->orWhere('posts.desc','like','%'.request('searchKey').'%');
        })
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->leftJoin('users','posts.admin_id','users.id')
        ->orderBy('posts.created_at','asc')->paginate(5);
        return view('admin.post.list',compact('post'));
    }

    //filter most saved
    public function mostSaved() {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
        ->when(request('searchKey'),function($query){
            $query->orWhere('topics.name','like','%'.request('searchKey').'%')
            ->orWhere('posts.desc','like','%'.request('searchKey').'%');
        })
        ->leftJoin('topics','posts.topic_id','topics.id')
        ->leftJoin('users','posts.admin_id','users.id')
        ->orderBy('posts.save_count','desc')->paginate(5);
        return view('admin.post.list',compact('post'));
    }

    // Direct post create page
    public function createPage() {
        $topic = Topic::select('id','name')->get();
        return view('admin.post.create',compact('topic'));
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
        return redirect()->route('post#listPage')->with(['createMessage'=>'Post created successfully']);
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

    //view detail post
    public function view($id) {
        $post = Post::select('posts.*','users.gender as admin_gender','users.name as admin_name','users.image as profile_image')
        ->leftJoin('users','posts.admin_id','users.id')
        ->where('posts.id',$id)->first();
        $topic_name = Topic::where('id',$post->topic_id)->first();
        $topic_name =$topic_name->name;
        return view('admin.post.view',compact('post','topic_name'));
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

    //edit page
    public function editPage($id) {
        $post = Post::select('posts.*','users.name as admin_name')
        ->leftJoin('users','posts.admin_id','users.id')->get();
        $post = $post->where('id',$id)->first();
        $topic = Topic::get();
        return view('admin.post.edit',compact('post','topic'));
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
        return redirect()->route('post#listPage')->with(['editMessage'=>'Post edited successfully']);
    }
}
