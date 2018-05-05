@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4 class="mb-4">Add Transaction</h4>

            @include('alerts')

            <form method="post" action="{{ route('transactions.store') }}">
                @csrf

                <div class="form-check">
                    <input class="form-check-input {{ $errors->has('type') ? 'is-invalid' : '' }}" type="radio" name="type" id="optionPaid" value="paid" {{ old('type') == 'paid' || old('type') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="optionPaid">Paid to</label>
                </div>

                <div class="form-check mb-2">
                    <input class="form-check-input {{ $errors->has('type') ? 'is-invalid' : '' }}" type="radio" name="type" id="optionReceived" value="received" {{ old('type') == 'received' ? 'checked' : '' }}>
                    <label class="form-check-label" for="optionReceived">Received from</label>

                    @if($errors->has('type'))
                        <div class="invalid-feedback">{{ $errors->first('type') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <select name="user" class="form-control selectpicker {{ $errors->has('user') ? 'is-invalid' : '' }}" data-live-search="true">
                        <option></option>

                        @foreach ($friends as $user)
                            <option value="{{ $user->id }}" {{ old('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>

                    @if($errors->has('user'))
                        <div class="invalid-feedback">{{ $errors->first('user') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <input type="number" step=".01" name="amount" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" placeholder="Amount" value="{{ old('amount') }}">

                    @if($errors->has('amount'))
                        <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" placeholder="Description">{{ old('description') }}</textarea>

                    @if($errors->has('description'))
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    @endif
                </div>

                <div class="mb-4">Transactions cannot be modified or deleted once saved.</div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
