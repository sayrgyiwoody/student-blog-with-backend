<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\AdminAprrove;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //Direct change password page
    public function changePasswordPage() {
        return view('admin.account.changePasswordPage');
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
        return redirect()->route('admin#home')->with(['changePw'=>'Password changed successfully']);
    }

    //check password validation
    private function passwordValidationCheck($request) {
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword'
        ])->validate();
    }

    //Direct to admin account information page
    public function informationPage() {
        return view('admin.account.informationPage');
    }

    //Direct to Update account page
    public function updateAccountPage() {
        return view('admin.account.updateAccountPage');
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
                Storage::delete('public/'.$dbImage);
            }
            $imageName = uniqid() . $request->file('image')->getClientOriginalName();
            $data['image'] = $imageName;
            $request->file('image')->storeAs('public/',$imageName);
        }
        User::where('id',$id)->update($data);
        return redirect()->route('admin#informationPage')->with(['updateAlert' => 'Admin information updated.']);
    }

    // Direct to admin accounts list
    public function adminList() {
        $accounts = User::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%')
                  ->where('role','admin');
        })
        ->where('role','admin')
        ->orderBy('created_at','desc')
        ->paginate(5);
        return view('admin.account.adminList',compact('accounts'));

    }

    // Direct to user accounts list
    public function userList() {
        $accounts = User::when(request('searchKey'),function($query){
            $query->where('name','like','%'.request('searchKey').'%')
                ->where('role','user');
        })
        ->where('role','user')
        ->orderBy('created_at','desc')
        ->paginate(5);

        $approveStatus = [];
        foreach($accounts as $account) {
            $status = DB::table('admin_aprroves')->where('user_id', $account->id)
            ->where('email', $account->email)
            ->first();

            $approveStatus[$account->id] = $status;
        }

        return view('admin.account.userList',compact('accounts','approveStatus'));

    }


    //change admin to user role
    public function changeUserRole($id) {
        User::where('id',$id)->update([
            'role' => 'user'
        ]);
        return back()->with(['adminRoleChangeAlert' => 'Admin to User role changed successfully.']);
    }

    //change admin to user role
    public function changeAdminRole($id) {
        User::where('id',$id)->update([
            'role' => 'admin'
        ]);
        return back()->with(['adminRoleChangeAlert' => 'User to Admin role changed successfully.']);
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

    //delete account
    public function delete(Request $request) {
        User::where('id',$request->account_id)->delete();
        Post::where('admin_id',$request->account_id)->delete();
        Saved::where('user_id',$request->account_id)->delete();
        return response()->json(200);
    }

    public function approve($id) {
        DB::table('admin_aprroves')->where('user_id',$id)->update(['status'=>'1']);
        $body = "You are now approved by admin . Continue to the website and verify your email. We apologize our register steps because of our security. ";
        $userEmail = User::where('id',$id)->first();
        $userEmail = $userEmail->email;
        // dd($userEmail);
        Mail::send('approved-message', ['body' => $body], function($message) use ($userEmail) {
            $message->from('waiyanwoody@gmail.com', 'Admin');
            $message->to($userEmail)->subject('Account Verified');
        });
        return back()->with(['adminRoleChangeAlert' => 'User approved.']);
    }
 }
