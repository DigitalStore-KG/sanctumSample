<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class BaseApiController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::get();
        if($users){
            $message="Records feched successfully";
            $status=true;
            return response(['message'=> $message,'status'=> $status,'users'=> $users]);
        }else{
            $message="Unable to fetch records";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created record in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'      =>  'required',
            'email'     =>  'required|email|unique:users',
            'password'  =>  'required',
        ]);
        $data=[
            'name'  =>  $request->name,
            'email'  =>  $request->email,
            'password'  =>  Hash::make($request->password),
            'city'  =>  $request->city,
            'country'  =>  $request->country,
        ];
        $record = User::create($data);
        if($record){
            $message="Record stored successfully";
            $status=true;
            return response(['message'=> $message,'status'=> $status,'record'=> $record]);
        }else{
            $message="Unable to store record";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
    }

    public function login(Request $request){
        $data= $request->validate([
            'email' =>  'required|email',
            'password'  =>  'required'
        ]);
        $user= User::where('email',$request->email)->first();
        if($user){
            if(auth()->attempt($data)){
                $token= $user->createToken($user->email)->plainTextToken;
                $message="Logged in successfully";
                $status=true;
                return response(['message'=> $message,'status'=> $status,'token'=> $token,'user'=>$user]);
            }
        }else{
            $message="User does not exist";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
        
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        $message="Logged out successfully";
        $status=true;
        return response(['message'=>$message,'status'=>$status]);
        
    }

    /**
     * To show detail of specific user.
     */
    public function show(String $id)
    {
        $record = User::find($id);
        if($record){
            $message="Feched record sussfully";
            $status=true;
            return response(['message'=>$message,'status'=>$status,'record'=>$record]);
        }else{
            $message="Record not found";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * To update records of user.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        if($user){
            $message="Updated record sussfully";
            $status=true;
            return response(['message'=>$message,'status'=>$status,'user'=>$user]);
        }else{
            $message="Unable to update record";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
        
    }

    /**
     * Function to remove specific user from database.
     */
    public function destroy(string $id)
    {
        $user   = User::find($id);
        $record = $user->delete();
        if($record){
            $message="Deleted record sussfully";
            $status=true;
            return response(['message'=>$message,'status'=>$status]);
        }else{
            $message="Unable to delete record";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
    }
    public function loggedUser(){
        $loggedUser= auth()->user();
        $message="Detail of Currently logged user";
        $status=true;
        return response(['message'=>$message,'status'=>$status,'user'=>$loggedUser]);
    }

    /*------------------ Change Password function----------------------------- */

    public function changePassword(Request $request){
        $validated=$request->validate([
            'oldPassword'   => 'required',
            'newPassword'   =>  'required',
        ]);
        $user= auth()->user();
        if(Hash::check($request->oldPassword,$user->password)){
            $user->password=Hash::make($request->newPassword);
            $user->update();
            $message="Password Changed Successfully";
            $status=true;
            return response(['message'=>$message,'status'=>$status]);
        }else{
            $message="Your previous password does not match";
            $status=false;
            return response(['message'=>$message,'status'=>$status]);
        }
        
    }
}
