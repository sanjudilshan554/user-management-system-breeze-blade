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
}
