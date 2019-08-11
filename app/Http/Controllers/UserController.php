<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller
{
    public function __construct(){
        return $this->middleware('auth');
    }

    public function index(Request $request){
        if(!$request->user()->hasRole('Admin')){
            return static::notAuthorized();
        }
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function view(Request $request, $id){
        if(!$request->user()->hasRole('Admin')){
            return static::notAuthorized();
        }
        $user = User::find($id);
        
        if($user){
            $roles = Role::all();
            return view('users.view', compact('user', 'roles'));
        }else{
            return static::bounceBack('User not found');
        }
    }
}
