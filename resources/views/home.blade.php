@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
            @component('status')
            @endcomponent
            
            @if($isReviewer)
                @component('dashboard', ['data' => $data])
                @endcomponent
            @else
                <div class="col-md-12">
                    @component('applications.applicants-home',['applications' => $applications, 'prefix' => 'You have no applications'])
                    @endcomponent
                </div>
            @endif
</div>
@endsection
