@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-4">
                Friends
                <a href="{{ route('friend-requests.create') }}" class="btn btn-primary btn-sm ml-3">Add a friend</a>
            </h4>

            @include('alerts')

            @if($friends->isNotEmpty())
                <div class="list-group">
                    @foreach($friends as $friend)
                        <div class="list-group-item d-flex justify-content-between
                            {{ $friend->getObligationToCurrentUser() ? 'owes-you' : '' }} {{ $friend->getObligationFromCurrentUser() ? 'you-owe' : '' }}">
                            <div class="p-2">
                                {{ $friend->name }}<br>

                                @if($friend->hasObligationToCurrentUser())
                                    <span style="color: #3a3">Owes you {{ number_format($friend->getObligationToCurrentUser()->amount, 2) }}</span>
                                @elseif($friend->hasObligationFromCurrentUser())
                                    <span style="color: #c33">You owe {{ number_format($friend->getObligationFromCurrentUser()->amount, 2) }}</span>
                                @endif
                            </div>
                            <form action="{{ route('friends.destroy', $friend->id) }}" method="post" class="p-2 d-inline-block">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Remove Friend</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                No friends. Why not <a href="{{ route('friend-requests.create') }}">add one now?</a>
            @endif
        </div>
    </div>
</div>
@endsection
