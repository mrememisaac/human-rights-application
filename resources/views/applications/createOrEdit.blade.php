@extends('layouts.app')

@section('content')
<div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
            @component('status')
            @endcomponent
            <div class="card">
                <div class="card-header"><h1>{{ __('Create New Application') }}</h1></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('application.store') }}" aria-label="{{ __('Application Form') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Subject') }}</label>

                            <div class="col-md-10">
                                <input id="subject" type="text" {{$readonly ? 'readonly':''}} class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" name="subject" value="{{ old('subject', isset($application->subject) ? $application->subject : null) }}" required autofocus>

                                @if ($errors->has('subject'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="summary" class="col-md-2 col-form-label text-md-right">{{ __('Summary') }}</label>

                            <div class="col-md-10">
                                <textarea id="summary" rows="5" {{$readonly ? 'readonly':''}} class="form-control{{ $errors->has('summary') ? ' is-invalid' : '' }}" name="summary" required>{{ old('summary', isset($application->summary) ? $application->summary : null) }}</textarea>

                                @if ($errors->has('summary'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('summary') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="body" class="col-md-2 col-form-label text-md-right">{{ __('Body') }}</label>

                            <div class="col-md-10">
                                <textarea id="body" rows="15" {{$readonly ? 'readonly':''}} class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" required>{{ old('body', isset($application->body) ? $application->body : null) }}</textarea>

                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 pull-right">
                                <button type="submit" style="float:right;  {{$readonly ? 'display:none':''}}" class="btn btn-primary">
                                    {{ __($buttonText) }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="clearfix"></div>
                        <div class="card">
                            @if($application->actions)
                                <div class="card-header">
                                    <h1>Actions</h1>
                                </div>
                                <div class="card-body">
                                    @foreach($application->actions as $action)
                                        <div class="col-md-12">
                                            <h3 style="border-bottom:solid 5px maroon;">{{$action->status}}</h3>
                                            @if($action->status != "Viewed")
                                            <span>{{$action->remarks}}</span>
                                            @endif                                            
                                            <p>{{$action->created_at->toDateString()}} @ {{$action->created_at->toTimeString()}} by {{$action->author->name}}</p>
                                            <hr/>
                                        </div>
                                    @endforeach
                                </div>                                
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h1>Update Application Status</h1>
                                </div>
                                <div class="card-body">
                                <form method="POST" action="{{ route('action.store')}}">
                                    @csrf
                                    <input type="hidden" class="hidden" value="{{$application->id}}" name="application_id"/>
                                    <div class="form-group row" >
                                        <label for="status" class="col-md-2 col-form-label text-md-right">{{__('Status')}}</label>
                                        <div class="col-md-10">
                                            <select id="status" name="status" class="form-control">
                                                <option value="0">Choose a status</option>
                                                @foreach($status_options as $option)
                                                    <option value="{{$option}}">{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="remarks" class="col-md-2 col-form-label text-md-right">{{__('Remarks')}}</label>
                                        <div class="col-md-10">
                                            <textarea name="remarks" id="remarks" rows="5" class="form-control{{ $errors->has('remarks') ? ' is-invalid' : '' }}" name="body" required>{{ old('remarks') }}</textarea>
                                        </div>
                                        @if ($errors->has('remarks'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('remarks') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 pull-right">
                                            <button type="submit" style="float:right;" class="btn btn-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection