@extends('users.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Show Client</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Client Details</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Mobile No:</strong> {{ $user->mobile }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Gender:</strong> {{ $user->gender }}</li>
                        <li class="list-group-item"><strong>State:</strong> {{ $user->state }}</li>
                        <li class="list-group-item"><strong>City:</strong> {{ $user->city }}</li>
                        <li class="list-group-item"><strong>Address:</strong> {{ $user->address }}</li>
                        <li class="list-group-item"><strong>Youtube Video:</strong>
                            @php
                                // Extract YouTube video ID from URL
                                $videoUrl = $user->url;
                                $queryString = parse_url($videoUrl, PHP_URL_QUERY);
                                parse_str($queryString, $params);
                                $videoId = isset($params['v']) ? $params['v'] : null;
                            @endphp
                            @if ($videoId)
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
                                    allowfullscreen></iframe>
                            @else
                                <p>Invalid YouTube video URL</p>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
