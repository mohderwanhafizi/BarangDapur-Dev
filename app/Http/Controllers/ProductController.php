<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function storeGuest(Request $request, ProductService $productService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:100',
            'quantity' => 'integer|min:1',
            'email' => 'required|email|max:255'
        ]);

        $product = $productService->saveGuestProduct($validated, $validated['email']);
        Auth::loginUsingId($product->user_id);

        return redirect()->route('products.success');
    }

    public function dashboard()
    {
        $products = Auth::user()->products()->latest()->get();
        return view('dashboard', compact('products'));
    }
}