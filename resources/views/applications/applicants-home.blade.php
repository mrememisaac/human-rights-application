<div class="text-right" style="margin-bottom:10px;"><a href="/application/create" class="btn btn-lg">New Application</a></div>
    <div class="card">
        <div class="card-header"><h1>Your Applications</h1></div>
        <div class="card-body">
            @component('applications/application', ['applications' => $applications, 'prefix' => 'You have no applications'])
            @endcomponent                     
        </div>
    </div>
</div>