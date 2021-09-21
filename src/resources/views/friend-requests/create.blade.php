@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Add a Friend</h4>

            @include('alerts')

            <form method="post" action="{{ route('friend-requests.store') }}">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        aria-describedby="emailHelp" placeholder="Enter friend&apos;s email address" value="{{ old('email') }}" required>

                    @if($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif

                    <small id="emailHelp" class="form-text text-muted">This will send a friend request if an account exists with the email address specified.</small>
                </div>

                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
</div>
@endsection
