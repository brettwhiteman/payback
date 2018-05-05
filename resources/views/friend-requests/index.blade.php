@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-4">
                Friend Requests
                <a href="{{ route('friend-requests.create') }}" class="btn btn-primary btn-sm ml-3">Send a friend request</a>
            </h4>

            @include('alerts')

            <div class="card my-4">
                <div class="card-header">Received Friend Requests</div>
                <div class="card-body">
                    @if($incoming->isNotEmpty())
                        <div class="list-group">
                            @foreach($incoming as $request)
                                <div class="list-group-item d-flex justify-content-between">
                                    <div class="p-2">{{ $request->from->name }} ({{ $request->from->email }})</div>
                                    <div class="p-2">
                                        <form action="{{ route('friend-requests.update', $request->id) }}" method="post" class="d-inline-block">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="accepted" value="1">
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>
                                        <form action="{{ route('friend-requests.update', $request->id) }}" method="post" class="d-inline-block">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="accepted" value="0">
                                            <button type="submit" class="btn btn-sm btn-danger">Decline</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="card-text">No pending friend requests</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">Sent Friend Requests</div>
                <div class="card-body">
                    @if($outgoing->isNotEmpty())
                        <div class="list-group">
                            @foreach($outgoing as $request)
                                <div class="list-group-item d-flex justify-content-between">
                                    <div class="p-2">{{ $request->to->name }} ({{ $request->to->email }})</div>
                                    <form action="{{ route('friend-requests.destroy', $request->id) }}" method="post" class="p-2 d-inline-block">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Friend Request</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="card-text">No pending friend requests</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
