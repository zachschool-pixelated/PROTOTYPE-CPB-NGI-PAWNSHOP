<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display inventory overview with stock status
     */
    public function index()
    {
        $products = Product::with('category')->get();

        $inStockProducts = $products->filter(fn($p) => !$p->isLowStock() && !$p->isOutOfStock());
        $lowStockProducts = $products->filter(fn($p) => $p->isLowStock());
        $outOfStockProducts = $products->filter(fn($p) => $p->isOutOfStock());

        $inStock = $inStockProducts->count();
        $lowStock = $lowStockProducts->count();
        $outOfStock = $outOfStockProducts->count();

        return view('inventory.index', compact(
            'inStockProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'inStock',
            'lowStock',
            'outOfStock'
        ));
    }
}
