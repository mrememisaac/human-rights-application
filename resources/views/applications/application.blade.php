@if($applications!=null and sizeof($applications))
    @foreach($applications as $application)
        <div class="card">
            <div class="card-header inner-card">
                <h3># {{$application->id}} - {{$application->subject}}</h3>
            </div>
            <div class="card-body">
                <p>{{$application->created_at->toDayDateTimeString()}} by {{$application->author->name}}</p>
                <p>{{$application->summary}}</p>
                <a href="/application/show/{{$application->id}}" class="btn btn-lg">Open</a>
            </div>
        </div>
    @endforeach
@endif
@if($applications!=null and sizeof($applications) == 0)
    <div>{{$prefix}}</div>
@endif
