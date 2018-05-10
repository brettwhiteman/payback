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
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="pr-2" style="flex-shrink: 0">From {{ $transaction->from_name }}</div>
                        <div class="text-center">
                            <span class="font-weight-bold" style="font-size: 18px; font-family: Arial, sans-serif">{{ number_format($transaction->amount, 2) }}</span><br>
                            <span class="font-italic" style="font-size: 12px">{{ $transaction->description }}</span><br>
                            <span style="font-size: 12px">{!! $transaction->created_at->format('j<\s\u\p>S</\s\u\p> F Y G:i') !!}</span>
                        </div>
                        <div class="pl-2" style="flex-shrink: 0">To {{ $transaction->to_name }}</div>
                    </div>
                </div>
            @empty
                No transactions yet. <a href="{{ route('transactions.create') }}">Record your first transaction.</a>
            @endforelse

            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
