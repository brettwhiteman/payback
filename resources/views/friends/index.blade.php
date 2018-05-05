@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-4">Friends</h4>

            @if($friends->isNotEmpty())
                <div class="list-group">
                    @foreach($friends as $friend)
                        <a href="#" class="list-group-item list-group-item-action">{{ $friend->name }}</a>
                    @endforeach
                </div>
            @else
                No friends. Why not <a href="{{ route('friend-requests.create') }}">add one now?</a>
            @endif
        </div>
    </div>
</div>
@endsection
