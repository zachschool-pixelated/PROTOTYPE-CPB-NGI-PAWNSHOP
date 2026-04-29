<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = Transaction::with('user', 'items')->latest()->paginate(15);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:SALE,DISTRIBUTION,RETURN',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::create([
            'type' => $validated['type'],
            'user_id' => auth()->id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $transaction->addItem(
                $item['product_id'],
                $item['quantity'],
                $item['unit_price']
            );
        }

        return redirect()->route('transactions.show', $transaction)->with('success', 'Transaction created successfully!');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('user', 'items.product');
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        if ($transaction->created_at->diffInHours(now()) > 24) {
            return redirect()->route('transactions.index')->with('error', 'Cannot edit transactions older than 24 hours');
        }
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->created_at->diffInHours(now()) > 24) {
            return redirect()->route('transactions.index')->with('error', 'Cannot edit transactions older than 24 hours');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.show', $transaction)->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->created_at->diffInHours(now()) > 24) {
            return redirect()->route('transactions.index')->with('error', 'Cannot delete transactions older than 24 hours');
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully!');
    }
}
