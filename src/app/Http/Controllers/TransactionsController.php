<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Obligation;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

        $transactions = Transaction::where('transactions.from_id', $userId)->orWhere('transactions.to_id', $userId)
            ->join('users AS from_user', 'from_user.id', '=', 'transactions.from_id')
            ->join('users AS to_user', 'to_user.id', '=', 'transactions.to_id')
            ->select('from_user.name AS from_name', 'to_user.name AS to_name', 'transactions.amount', 'transactions.description', 'transactions.created_at')
            ->orderBy('transactions.created_at', 'desc')
            ->paginate(10);

        return view('transactions.index')->with('transactions', $transactions);
    }

    public function create()
    {
        return view('transactions.create')->with('friends', auth()->user()->friends);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:paid,received',
            'user' => 'required|exists:users,id',
            'amount' => 'required|numeric|max:1000000000|min:0.01',
            'description' => 'string|max:5000|nullable'
        ]);

        if ($request->type == 'paid') {
            $transactionFrom = auth()->user();
            $transactionTo = User::findOrFail($request->user);
        } else {
            $transactionFrom = User::findOrFail($request->user);
            $transactionTo = auth()->user();
        }

        $amount = (double)$request->amount;

        if ($transactionFrom->id > $transactionTo->id) {
            $idStr = $transactionTo->id . '_' . $transactionFrom->id;
        } else {
            $idStr = $transactionFrom->id . '_' . $transactionTo->id;
        }

        $hash = hash('sha256', $idStr);

        DB::transaction(function() use(&$request, &$transactionFrom, &$transactionTo, $amount, $hash) {
            $transaction = new Transaction;
            $transaction->from_id = $transactionFrom->id;
            $transaction->to_id = $transactionTo->id;
            $transaction->amount = $amount;
            $transaction->description = $request->description;
            $transaction->save();

            $obligation = Obligation::where('hash', $hash)->first();

            if (!$obligation) {
                $obligation = new Obligation;
                $obligation->from_id = $transactionTo->id;
                $obligation->to_id = $transactionFrom->id;
                $obligation->amount = $request->amount;
                $obligation->hash = $hash;
                $obligation->save();
            } else {
                if ($obligation->from_id == $transactionFrom->id) {
                    $obligation->amount -= $amount;
                } else {
                    $obligation->amount += $amount;
                }

                if ($obligation->amount < 0.0) {
                    $tmp = $obligation->from_id;
                    $obligation->from_id = $obligation->to_id;
                    $obligation->to_id = $tmp;
                    $obligation->amount *= -1.0;
                }

                $obligation->save();
            }
        });

        return redirect()->route('transactions.index')->with('success', 'Transaction created.');
    }
}
