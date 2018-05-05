@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-4">Add Transaction</h4>

            @include('alerts')

            <form method="post" action="{{ route('transactions.store') }}">
                @csrf

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
