<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
            'email'     =>  'required|email',
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
            $message="Unable to fetch record";
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
}
