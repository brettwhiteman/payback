@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-4">
                Transactions
                <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm ml-3">Add transaction</a>
            </h4>

            @include('alerts')

            @forelse($transactions as $transaction)
                <div class="card mb-2">
                    <div class="card-body d-flex justify-content-between">
                        <span>{{ $transaction->from_name }}</span>
                        <span>{{ number_format($transaction->amount, 2) }}</span>
                        <span>{{ $transaction->to_name }}</span>
                    </div>
                </div>
            @empty
                No transactions yet. <a href="{{ route('transactions.create') }}">Record your first transaction.</a>
            @endforelse
        </div>
    </div>
</div>
@endsection
