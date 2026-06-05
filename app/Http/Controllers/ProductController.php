<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sub_category' => 'nullable|string|max:20',
            'serial_no' => 'nullable|integer',
            'description' => 'nullable|string|max:255',
            'carat' => 'nullable|string|max:10',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
                       ->with('success', 'Product created successfully');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sub_category' => 'nullable|string|max:20',
            'serial_no' => 'nullable|integer',
            'description' => 'nullable|string|max:255',
            'carat' => 'nullable|string|max:10',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
                       ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                       ->with('success', 'Product deleted successfully');
    }
}
