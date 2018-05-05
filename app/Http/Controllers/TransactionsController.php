<?php

namespace App\Http\Controllers;

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
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
