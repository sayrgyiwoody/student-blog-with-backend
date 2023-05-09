<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function form(){
        $topics = Topic::get();
        return view('user.feedback',compact('topics'));
    }

    public function send(Request $request) {
        Feedback::create([
            'name'=>$request->name,
            'email' => $request->email,
            'subject'=>$request->subject,
            'message'=>$request->message
        ]);
        return redirect()->route('user#home')->with(['feedbackSent'=>'Feedback poh lte p nww']);
    }

    //Direct to Admin feedback page
    public function adminPage() {
        $message = Feedback::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%');
        })
        ->orderBy('created_at','desc')->paginate(5);
        // $total_message = count(Feedback::get());
        return view('admin.feedback.list',compact('message'));
    }

    //Delete feedback message admin
    public function delete(Request $request) {
        Feedback::where('id',$request->message_id)->delete();
        return response()->json(200);
    }

    //Delete all message admin
    public function deleteAll() {
        Feedback::truncate();
        return response()->json(200);
    }

    //view all information
    public function view($id) {
        $message = Feedback::where('id',$id)->first();
        return view('admin.feedback.viewPage',compact('message'));
    }

}
