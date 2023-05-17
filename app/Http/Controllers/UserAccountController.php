<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserAccountController extends Controller
{
    //Direct change password page
    public function changePasswordPage() {
        $topics = Topic::get();
        return view('user.account.changePasswordPage',compact('topics'));
    }

    //Change new password
    public function changePassword(Request $request) {
        $this->passwordValidationCheck($request);
        $dbHashPassword = Auth::user()->password;
        if(Hash::check($request->oldPassword, $dbHashPassword)) {
            $newPassword = hash::make($request->newPassword);
            $user = User::where('id',Auth::user()->id)->update([
                'password' => $newPassword
            ]);
        }
        return redirect()->route('user#home')->with(['changePw'=>'Password changed successfully']);
    }

    //check password validation
    private function passwordValidationCheck($request) {
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword'
        ])->validate();
    }

    //Direct to user account information page
    public function informationPage() {
        $topics = Topic::get();
        return view('user.account.informationPage',compact('topics'));
    }

    //Direct to Update account page
    public function updateAccountPage() {
        $topics = Topic::get();
        return view('user.account.updateAccountPage',compact('topics'));
    }


    //Update account information
    public function updateAccount($id,Request $request) {
        //check validation
        $this->accountValidationCheck($request,$id);
        $data = $this->getAccountData($request);
        if($request->hasFile('image')) {
            $dbImage = User::select('image')->where('id',$id)->first();
            $dbImage =$dbImage->image;
            if($dbImage!=null) {
                Storage::delete('public/profileImages/'.$dbImage);
            }
            $imageName = uniqid() . $request->file('image')->getClientOriginalName();
            $data['image'] = $imageName;
            $request->file('image')->storeAs('public/profileImages/',$imageName);
        }
        User::where('id',$id)->update($data);
        return redirect()->route('user#informationPage')->with(['updateAlert' => 'Admin information updated.']);
    }

    //Account input validation check
    private function accountValidationCheck($request,$id) {
        Validator::make($request->all(),[
            'name' => 'required|min:3|max:20',
            'email' => 'required|max:40|unique:users,email,'.$id,
            'gender' => 'required',
            'image' => 'mimes:png,jpg,jpeg,JPEG|file',
        ])->validate();
    }

    //get account data as object format
    private function getAccountData($request) {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => Carbon::now(),
            'gender' => $request->gender,
        ];
    }
}
