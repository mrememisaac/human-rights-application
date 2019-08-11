<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use App\Action;
use App\User;
use Carbon\Carbon;

class ApplicationController extends Controller
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
        if(!$request->user()->hasRole('Reviewer')){
            return static::notAuthorized();
        }
        $applications = Application::orderBy('id','DESC')->get();
        return view('applications.index', compact('applications'));
    }

    public function statusOptions(User $user){
        if($user->hasRole("Reviewer")){
            $status_options = ["Under Review","Accepted", "OnHold", "Action Required", "Scheduled", "In Process", "Rejected", "Closed"];
        }else{
            $status_options = ["Applicant Feedback"];
        }
        return $status_options;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $application = new  Application();
        $readonly = false;
        $buttonText = "Submit";
        $status_options = $this->statusOptions($request->user());
        return view('applications.createOrEdit', compact('application', 'readonly', 'status_options', 'buttonText'));
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
            'summary' => 'required|max:450',
            'subject' => 'required|max:150',
            'body' => 'required|max:4000'
        ]);
        if($validatedData){
            $application = new Application();
            $application->fill($validatedData);
            $application->created_by = $request->user()->email;
            $currentProfile = $request->user()->currentProfile();
            if($currentProfile){
                $application->applicant_id = $currentProfile->id;
            }else{
                return redirect()->route('applicant.create');
            }
            $application->save();
            return redirect('/home');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $application = Application::find($id);
        // dd($application->actions);
        $title = "View or Update Application " . $application->id;
        
        $isMine = strtolower($request->user()->email) != strtolower($application->created_by);
        $actionTaken = sizeof($application->actions) > 0;
        
        $readonly = $actionTaken ? true : $isMine;
        
        // dd($readonly);
        $isReviewer = $request->user()->hasRole("Reviewer");
        if($application){
            $this->viewed($request, $application);
            $status_options = $this->statusOptions($request->user()); 
            $buttonText = "Update";
            return view('applications.createOrEdit', compact('application', 'title', 'readonly', 'status_options', 'buttonText', 'isReviewer'));
        }
        return static::bounceBack("Application not found");
    }

    public function viewed($request, $application){
        if($request->user()->hasRole('Reviewer')){
            if(!Action::where('created_by', $request->user()->email)->whereDay('created_at', Carbon::now()->day)->exists()){
                $action = new Action();
                $action->status = "Viewed";
                $action->remarks = "Seen by " . $request->user()->name . " on " . Carbon::now()->toDateString() . " at " . Carbon::now()->toTimeString();
                $action->created_by = $request->user()->email;
                $action->application_id = $application->id;
                $action->save();
            }
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $application = Application::find($id);
        if($application){
            $this->viewed($request, $application);
            return view('applications.createOrEdit', compact('applications'));
        }
        return static::bounceBack("Application not found");
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
        $application = Application::find($id);
        if($application){
            $application->update($requestData);
            return static::bounceBack("Application Updated");
        }
        return static::bounceBack("Application not found");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $application = $id!=null ? Application::find($id) : null;
        if($application == null){
            return static::bounceBack("Application not found");
        }

        //Only the application manager can delete an application
        if(!static::enforceAccessControl("ApplicationManager") and !$application->isCreator($request->user()->username)){
            return static::notAuthorized();
        }
    }
}
