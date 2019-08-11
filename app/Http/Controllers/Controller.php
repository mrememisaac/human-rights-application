<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Session;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function enforceAccessControl(string $roleName){
        return !Auth::user()->hasRole($roleName);
    }

    public static function getFromRequest(Request $request, string $field_name){
        if($request->has($field_name)){
            return $request->input($field_name);
        }
        return null;
    }

    public static function bounceBack(string $message){
        Session::flash('status', $message);
        return redirect()->back();
    }

    public static function redirect(string $message, string $route){
        Session::flash('status', $message);
        return redirect($route);
    }

    public static function notAuthorized(){
        return static::bounceBack("You are not authorized to perform this action");
    }
}
