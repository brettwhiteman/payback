<?php

namespace App\Http\Controllers;

use App\User;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;

        $transactions = Transaction::where('transactions.from_id', $userId)->orWhere('transactions.to_id', $userId)
            ->join('users AS from_user', 'from_user.id', '=', 'transactions.from_id')
            ->join('users AS to_user', 'to_user.id', '=', 'transactions.to_id')
            ->select('from_user.name AS from_name', 'to_user.name AS to_name', 'transactions.amount', 'transactions.description')
            ->orderBy('transactions.created_at', 'desc')
            ->paginate(20);

        return view('transactions.index')->with('transactions', $transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transactions.create')->with('friends', auth()->user()->friends);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:paid,received',
            'user' => 'required|exists:users,id',
            'amount' => 'required|numeric|max:1000000000',
            'description' => 'string|max:5000|nullable'
        ]);

        if ($request->type == 'paid') {
            $from = auth()->user();
            $to = User::findOrFail($request->user);
        } else {
            $from = User::findOrFail($request->user);
            $to = auth()->user();
        }

        $transaction = new Transaction;
        $transaction->from()->associate($from);
        $transaction->to()->associate($to);
        $transaction->amount = (double)$request->amount;
        $transaction->description = $request->description;
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transaction created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
