@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Users</h1>
                </div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->last_login_date ? $user->last_login_date->toDayDateTimeString() : null}}</td>
                                <td><a href="/users/view/{{$user->id}}">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection