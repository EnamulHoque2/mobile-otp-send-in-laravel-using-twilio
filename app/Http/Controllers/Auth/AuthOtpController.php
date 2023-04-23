<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserOtp;

class AuthOtpController extends Controller
{
    public function login(){
        return view('otplogin');
    }
    public function generate(Request $request){
        $request->validate([
            'mobile_no'=>'required|exists:users,mobile_no'
        ]);
        $userOtp=$this->generateOtp($request->mobile_no);
        $userOtp->sendOtp($request->mobile_no);
        return redirect()->route('otp.verify',[$userOtp->user_id])->with('success', 'Otp has been send to your mobile no');
    }
    public function generateOtp($mobile_no){
       $user = User::where('mobile_no',$mobile_no)->latest()->first();
       $userOtp = UserOtp::where('user_id',$user->id)->latest()->first();
       $now = now();
       if($userOtp && $now->isBefore($userOtp->expire_at)){
        return $userOtp;
       }
       return UserOtp::updateOrCreate(
        ['user_id'   => $user->id,],
        [
        'user_id' => $user->id,
        'otp' => rand(111111,999999),
        'expire_at' => $now->addMinutes(10),
        ]);
    }
    public function verification($user_id){
        return view('otpverification',['user_id'=>$user_id]);
    }
    public function loginwithotp(Request $request){
        $request->validate([
            'otp'=>'required',
            'user_id'=>'required'
        ]);
        $userOtp = UserOtp::where('user_id',$request->user_id)->where('otp',$request->otp)->first();
        $now = now();
        if(!$userOtp){
            return redirect()->back()->with('error','Your otp is not correct');
        }elseif($userOtp && $now->isAfter($userOtp->expire_at)){
            return redirect()->back()->with('error','Your otp has been Expired');
        }
        $user = User::whereId($request->user_id)->first();
        if($user){
            $userOtp->update([
                'expire_at' => now()
            ]);
            Auth::login($user);
            return redirect('/');
        }
        return redirect()->route('otp.login')->with('error','Your otp is invalid');
    }
}
