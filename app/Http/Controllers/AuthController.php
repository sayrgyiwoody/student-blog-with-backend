<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminAprrove;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Direct to dashboard to decide role
    public function dashboard() {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin#home');
        }
        if (Auth::user()->role == 'user') {
            if (Auth::check() && Auth::user()->email_verified_at === null) {

                return redirect()->route('auth#adminApprovePage');
            }
            return redirect()->route('user#home');

        }
    }


    public function adminApprovePage() {
        return view('approve-page');
    }

    public function approveRequest() {
        $status = AdminAprrove::where('user_id',Auth::user()->id)->first();
        if($status == null) {
            AdminAprrove::create(['user_id' => Auth::user()->id, 'email' => Auth::user()->email]);
            return back()->with(['message'=>'You are not still approved by admin. Wait for admin approve.']);
        }
        if($status->status != '1') {
            return back()->with(['message'=>'You are not still approved by admin. Wait for admin approve.']);
        }

        return view('send-email');

    }

    //send code
    public function sendCode() {
        $verificationCode = strval(random_int(100000, 999999));
        VerificationCode::create(['user_id' => Auth::user()->id ,'code' => $verificationCode]);
        $body = "Your verification code for UCSY students blog is: " . $verificationCode;

        Mail::send('email-verification', ['body' => $body], function($message) {
            $message->from('waiyanwoody@gmail.com', 'Admin');
            $message->to(Auth::user()->email)->subject('Verification Code');
        });
        return redirect()->route('auth#checkCodePage');
    }

    public function checkCodePage() {
        return view('verify-email');
    }

    // check code
    public function checkCode(Request $request) {
        Validator::make($request->all(), [
            'code' => 'required|numeric|exists:verification_codes,code'
        ])->validate();
        VerificationCode::where('user_id',Auth::user()->id)->delete();
        User::where('id',Auth::user()->id)->update(['email_verified_at'=>Carbon::now()]);
        return redirect()->route('user#home');
    }
}
