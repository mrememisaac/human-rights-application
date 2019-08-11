<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use App\Http\Requests;
use App\Action;
use App\Application;
use Auth;
use Illuminate\Support\Faces\Validator;

class ActionController extends Controller
{
    public function __construction(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $application_id=null)
    {
        if(!$application_id){
            $actions = [];    
        }
        else{
            $actions = Action::where('application_id', $application_id)->get();
        }
        return view('actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                "application_id" => "integer|required|min:1",
                "status" => "required|max:50",
                "remarks" => "max:450"
            ]
        );
        // dd($validatedData);
        if($validatedData){
            $action = new Action();
            $action->fill($validatedData);
            $action->created_by = $request->user()->email;
            $action->save();
            return static::bounceBack("Status Updated");
        }
        return static::bounceBack("Status Updated");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
