<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transactions::where('user_id', Auth::id())->get();
        return response()->json($transactions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Untuk web: return view('transactions.create');
        // Untuk API: bisa dikosongkan atau return response kosong
        return response()->json(['message' => 'Show create form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $validated['user_id'] = Auth::id();
        $transaction = Transactions::create($validated);
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transactions::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Untuk web: return view('transactions.edit', compact('transaction'));
        // Untuk API: bisa dikosongkan atau return response kosong
        return response()->json(['message' => 'Show edit form']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transactions::where('user_id', Auth::id())->findOrFail($id);
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $transaction->update($validated);
        return response()->json($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transactions::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted']);
    }
}
