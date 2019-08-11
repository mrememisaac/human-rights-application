@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1>{{$user->name}}'s Roles</h1>
            </div>
            <div class="card-body ">
                <form action="/users/update">
                    <input  type="hidden" class="hidden" name="id" value="{{$user->id}}"/>
                    @foreach($roles as $role)
                            <input type="checkbox" style="vertical-align:middle;" name="{{$role->name}}" {{$user->hasRole($role->name) ? 'checked' : ''}} >{{$role->name}}<br/>
                    @endforeach
                    <input type="submit" value="Update" class="btn" style="margin-top:20px;"/>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection