<div class="card">
    <div class="card-header">
        <h1>Dashboard</h1>
    </div>
    <div class="card-body">
        @foreach($data as $datum)
            <div class="data-point rounded">
                <div class="data-point-value">{{$datum->value}}</div>
                <div class="data-point-label">{{$datum->label}}</div>
            </div>
        @endforeach
    </div>
</div>