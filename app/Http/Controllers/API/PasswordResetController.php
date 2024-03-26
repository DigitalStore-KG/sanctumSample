<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
Use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Url;

class PasswordResetController extends Controller
{
    /*--------------------- Password reset functionality require smtp service available ---------------------*/
    public function passwordResetSendMail(Request $request){
        $request->validate([
            'email'=>'required',
        ]);

        $record= User::where('email',$request->email)->first();

        if($record){
            $token= Str::random(40);
            $url= URL::to('/api/user').'/'.$token;
            $data=[
                'email'=> $request->email,
                'token'=> $token,
                'created_at'=>Carbon::now(),
            ];
            PasswordReset::create($data);
            $data=['url'=>$url];
            $user=['email'=>$record->email, 'subject'=>'password reset'];
            Mail::send('resetEmail',$data,function($messages) use ($user){
                $messages->to($user['email']);
                $messages->subject($user['subject']);
                $messages->from('noreply@example.com');
            });
            $message="Email has been sent, Please verify your email";
            $status=true;
            return response(['message'=>$message,'status'=>$status]);
        }else{
            $message="Your email does not match";
            $status=false;
            return response(['message'=>$message, 'status'=>$status]);
        }
    }
    
    public function passwordReset(Request $request, $token){
        
        $request->validate([
            'email'=>'required',
            'password'=> 'required',
        ]);
        $record=PasswordReset::where('email',$request->email)->first();
        $data=['password'=> Hash::make($request->password)];
        if($record->token ===$token){
            
            $user= User::where('email',$request->email)->first();
            $changed= $user->update($data);
            if($changed){PasswordReset::where('email',$request->email)->delete();}
            

            $message="Your password has been changed successfully";
            $status=true;
            return response(['message'=>$message,'status'=>$status]);
        }else{
            $message="Unable to change your password";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
    }
}
