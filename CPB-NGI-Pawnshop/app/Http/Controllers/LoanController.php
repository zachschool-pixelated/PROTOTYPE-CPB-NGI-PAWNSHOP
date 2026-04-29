<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index()
    {
        $loans = Loan::with('customer', 'items')->latest()->paginate(15);
        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $items = Item::where('is_available', true)->get();
        return view('loans.create', compact('customers', 'items'));
    }

    /**
     * Store a newly created loan in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'loan_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'loan_duration_days' => 'required|integer|min:1',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Create the loan
        $loan = Loan::create([
            'customer_id' => $validated['customer_id'],
            'user_id' => $user->id,
            'loan_amount' => $validated['loan_amount'],
            'interest_rate' => $validated['interest_rate'],
            'loan_duration_days' => $validated['loan_duration_days'],
            'loan_date' => now(),
            'due_date' => now()->addDays($validated['loan_duration_days']),
            'status' => 'active',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Add items to the loan
        foreach ($validated['items'] as $itemData) {
            $item = Item::find($itemData['item_id']);
            $loan->items()->create([
                'item_id' => $itemData['item_id'],
                'appraised_value' => $item->appraised_value,
                'quantity' => $itemData['quantity'],
            ]);
            // Mark item as unavailable
            $item->update(['is_available' => false]);
        }

        return redirect()->route('loans.show', $loan)->with('success', 'Loan created successfully!');
    }

    /**
     * Display the specified loan.
     */
    public function show(Loan $loan)
    {
        $loan->load('customer', 'items.item', 'payments', 'user');
        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified loan.
     */
    public function edit(Loan $loan)
    {
        if ($loan->status !== 'active') {
            return redirect()->route('loans.show', $loan)->with('error', 'Only active loans can be edited!');
        }
        $customers = Customer::where('is_active', true)->get();
        $items = Item::where('is_available', true)->orWhereHas('loans', function($q) use ($loan) {
            $q->where('loans.id', $loan->id);
        })->get();
        return view('loans.edit', compact('loan', 'customers', 'items'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        if ($loan->status !== 'active') {
            return redirect()->route('loans.show', $loan)->with('error', 'Only active loans can be updated!');
        }

        $validated = $request->validate([
            'loan_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'loan_duration_days' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $loan->update($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Loan updated successfully!');
    }

    /**
     * Mark loan as paid.
     */
    public function markAsPaid(Loan $loan)
    {
        if ($loan->status !== 'active') {
            return redirect()->route('loans.show', $loan)->with('error', 'Only active loans can be marked as paid!');
        }

        $loan->update(['status' => 'paid', 'redemption_date' => now()]);

        // Mark items as available again
        foreach ($loan->items as $loanItem) {
            $loanItem->item->update(['is_available' => true]);
        }

        return redirect()->route('loans.show', $loan)->with('success', 'Loan marked as paid!');
    }

    /**
     * Mark loan as forfeited.
     */
    public function markAsForfeited(Loan $loan)
    {
        if ($loan->status !== 'active') {
            return redirect()->route('loans.show', $loan)->with('error', 'Only active loans can be forfeited!');
        }

        $loan->update(['status' => 'forfeited']);

        return redirect()->route('loans.show', $loan)->with('success', 'Loan marked as forfeited!');
    }

    /**
     * Remove the specified loan from storage.
     */
    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            return redirect()->route('loans.show', $loan)->with('error', 'Cannot delete active loans!');
        }

        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully!');
    }
}
