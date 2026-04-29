<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Loan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = Payment::with('loan.customer')->latest()->paginate(15);
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create($loanId = null)
    {
        $loan = null;
        if ($loanId) {
            $loan = Loan::findOrFail($loanId);
        }
        $loans = Loan::where('status', 'active')->get();
        return view('payments.create', compact('loan', 'loans'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,check,card,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $loan = Loan::findOrFail($validated['loan_id']);

        if ($loan->status !== 'active') {
            return redirect()->back()->with('error', 'Payment can only be made for active loans!');
        }

        $validated['status'] = 'completed';
        $validated['paid_at'] = now();

        Payment::create($validated);

        return redirect()->route('loans.show', $loan)->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load('loan.customer');
        return view('payments.show', compact('payment'));
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $loan = $payment->loan;
        $payment->delete();
        return redirect()->route('loans.show', $loan)->with('success', 'Payment deleted successfully!');
    }
}
