<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    protected $user;

    public function __construct(){
        $this->user =new User();
    }

    public function store(Request $request){
        $response= $this->user->create($request->all());
        return $response;
    }

    public function get(Request $request){
        $sortBy = $request->input('sortBy', 'username');

        $users=$this->user->orderBy($sortBy)->get();
        return response()->json($users);
    }

    public function delete(Request $request){

        $id=$request->userId;

        $this->user->where('id',$id)->delete();
    }

    public function find(Request $request){
        $user=$this->user->find($request->userId);

        return response()->json($user);
    }


    public function update(Request $request){
      
        $formData = $request->input('formData');

        parse_str($formData, $formDataArray);

        $userId = $formDataArray['userId'];
        $name = $formDataArray['name'];
        $email = $formDataArray['email'];
        $username = $formDataArray['username'];
        $usertypeUpdate = $formDataArray['usertypeUpdate'];
        $status = $formDataArray['statusUpdate'];
    

        $user=$this->user->where('id',$userId)->update([
            'username'=> $username,
            'name'=>  $name,
            'email'=> $email ,
            'user_type'=>$usertypeUpdate ,
            'status'=>$status,
        ]);


        return response()->json(['data'=>$user,'message'=>'data has been save successfully' ]);
    }
}
