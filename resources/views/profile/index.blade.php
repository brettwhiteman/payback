@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Edit Profile</h4>

            @include('alerts')

            <form method="POST" action="{{ route('profile.update') }}">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="inputName" value="{{ old('name', Auth::user()->name) }}" required>

                    @if($errors->has('name'))
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="inputEmail" value="{{ old('email', Auth::user()->email) }}" autocomplete="off">

                    @if($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="inputPassword" autocomplete="off">

                    @if($errors->has('password'))
                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="inputPasswordConfirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="inputPasswordConfirmation" autocomplete="off">

                    @if($errors->has('password_confirmation'))
                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="selectTimezone">Timezone</label>
                    <select name="timezone" class="form-control selectpicker {{ $errors->has('timezone') ? 'is-invalid' : '' }}"
                        data-live-search="true" required id="selectTimezone">
                        @foreach ($timezones as $tz)
                            <option {{ $tz == old('timezone', Auth::user()->timezone) ? 'selected' : '' }}>{{ $tz }}</option>
                        @endforeach
                    </select>

                    @if($errors->has('timezone'))
                        <div class="invalid-feedback">{{ $errors->first('timezone') }}</div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary mt-4">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
