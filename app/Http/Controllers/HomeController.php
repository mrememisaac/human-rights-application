<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use App\Applicant;
use App\Datum;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $applicant = Applicant::where('created_by', $request->user()->email)->orderBy('id', 'desc')->first();
        if($applicant == null){
            //user lacks a profile, prompt him to create one
            //Session::add('returnUrl', '/home');
            return redirect()->route('applicant.create')->with('returnUrl', '/home');
        }
        $applications = Application::where('created_by', $request->user()->email)->orderBy('id', 'desc')->get();
        
        $isReviewer = $request->user()->hasRole("Reviewer");
        $data = $this->getData();        
        return view('home', compact('applications', 'isReviewer', 'data'));
    }

    public function getData(){
        $labels = ["New", "Under Review", "On Hold", "Accepted", "Scheduled", "In Progress", "Concluded", "Positive", "Negative", "Rejected"];
        for ($i=0; $i < 10; $i++) { 
            # code...
            $datum = new Datum();
            $datum->value = Application::where(function($q){
                $q->actions->orderBy('id, desc')->first()->status = $labels[$i];
            })-count();
            $datum->label = $labels[$i];
            $data[] = $datum;
        }        
        return $data;
        //select count(*) from applications
    }
    public function fakeData(){
        $data = [];        
        $labels = ["New", "Under Review", "On Hold", "Accepted", "Scheduled", "In Progress", "Concluded", "Positive", "Negative", "Rejected"];
        for ($i=0; $i < 10; $i++) { 
            # code...
            $datum = new Datum();
            $datum->value = rand(10, 500);// $labels[$i];
            $datum->label = $labels[$i];
            $data[] = $datum;
        }        
        return $data;
    }
}
