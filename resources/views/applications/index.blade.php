@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="text-right" style="margin-bottom:10px;"><a href="/application/create" class="btn btn-lg">New Application</a></div>
            <div class="card">
                <div class="card-header"><h1>Applications</h1></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @component('applications/application', ['applications' => $applications, 'prefix' => 'No applications'])                                                                            
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
