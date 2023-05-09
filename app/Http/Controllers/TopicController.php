<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    // Direct topic list
    public function listPage() {
        $topic = Topic::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%');
        })
        ->orderBy('created_at','desc')->paginate(5);
        return view('admin.topic.list',compact('topic'));
    }

    //filter ascending
    public function filterAsc() {
        $topic = Topic::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%');
        })
        ->orderBy('created_at','asc')->paginate(5);
        return view('admin.topic.list',compact('topic'));
    }

    // Direct topic create page
    public function createPage() {
        return view('admin.topic.create');
    }

    public function create(Request $request) {
        $this->topicValidationCheck($request);
        Topic::create([
            'name' => $request->name
        ]);
        return redirect()->route('topic#listPage')->with(['createMessage'=>'Topic created successfully']);
    }

    private function topicValidationCheck($request,$id = 0) {
        Validator::make($request->all(),[
            'name' => 'required|min:3|unique:topics,name,'. $id
        ])->validate();
    }

    // Direct topic edit page
    public function editPage($id) {
        $topic = Topic::where('id',$id)->first();
        return view('admin.topic.edit',compact('topic'));
    }

    //Edit topic
    public function edit(Request $request,$id) {
        $this->topicValidationCheck($request,$id);
        Topic::where('id',$id)->update([
            'name' => $request->name
        ]);
        return redirect()->route('topic#listPage')->with(['editMessage'=>'Topic edited successfully']);
    }

    //delete topic
    public function delete(Request $request) {
        Topic::where('id',$request->topic_id)->delete();
        return response()->json(200);
    }
}
