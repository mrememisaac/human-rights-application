<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;

class ApplicantController extends Controller
{
    public function __construction(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->hasRole('Reviewer')){
            return static::notAuthorized();
        }
        $applicants = Applicant::orderBy('id','DESC')->get();
        return view('applicants.index', compact('applicants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $applicant = new  Applicant();
        $applicant->name = $request->user()->name;
        $request->session()->reflash();
        // if($request->session()->has('returnUrl')){
        //     $request->session()->keep(['returnUrl']);
        // }
        return view('applicants.createOrEdit', compact('applicant'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'address' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50'
        ]);
        if($validatedData){
            $applicant = new Applicant();
            $applicant->fill($validatedData);
            $applicant->created_by = $request->user()->email;
            $applicant->save();
        }        
        if($request->session()->has('returnUrl')){
            return redirect($request->session()->get('returnUrl'));
        }
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $applicant = Applicant::find($id);
        if($applicant){
            return view('applicants.createOrEdit', compact('applicants'));
        }
        return static::bounceBack("Applicant not found");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applicant = Applicant::find($id);
        if($applicant){
            return view('applicants.createOrEdit', compact('applicants'));
        }
        return static::bounceBack("Applicant not found");
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
        $requestData = $request->all();
        $applicant = Applicant::find($id);
        if($applicant){
            $applicant->update($requestData);
            return static::bounceBack("Applicant Updated");
        }
        return static::bounceBack("Applicant not found");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $applicant = $id!=null ? Applicant::find($id) : null;
        if($applicant == null){
            return static::bounceBack("Applicant not found");
        }

        //Only the applicant manager can delete an applicant
        if(!static::enforceAccessControl("ApplicantManager") and !$applicant->isCreator($request->user()->username)){
            return static::notAuthorized();
        }
    }
}
