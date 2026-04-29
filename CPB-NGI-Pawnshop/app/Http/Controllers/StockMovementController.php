<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Display a listing of stock movements
     */
    public function index()
    {
        $movements = StockMovement::with('product', 'user', 'supplier')
            ->latest()
            ->paginate(20);

        return view('stock-movements.index', compact('movements'));
    }

    /**
     * Store a new stock movement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:IN,OUT,ADJUSTMENT',
            'quantity' => 'required|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $validated['user_id'] = auth()->id();

        if ($validated['type'] === 'IN') {
            $product->addStock(
                $validated['quantity'],
                auth()->id(),
                $validated['supplier_id'] ?? null,
                $validated['notes'] ?? null
            );
        } elseif ($validated['type'] === 'OUT') {
            $product->removeStock(
                $validated['quantity'],
                auth()->id(),
                $validated['notes'] ?? null
            );
        } elseif ($validated['type'] === 'ADJUSTMENT') {
            $product->adjustStock(
                $validated['quantity'],
                auth()->id(),
                $validated['notes'] ?? null
            );
        }

        return redirect()->route('stock-movements.index')
            ->with('success', 'Stock movement recorded successfully!');
    }
}
