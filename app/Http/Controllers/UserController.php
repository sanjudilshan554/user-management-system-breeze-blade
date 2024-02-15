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

    public function get(){
        $users=$this->user->all();
        return response()->json($users);
    }
}
