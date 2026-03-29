<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Benarkan semua (Guest & Auth)
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'quantity'       => 'required|numeric|min:0',
            'unit'           => 'required|string',
            'sku'            => 'nullable|string',
            'expired_date'   => 'nullable|date',
            'purchased_date' => 'nullable|date',
            'type'           => 'required|string',
            'packaging_type' => 'required|string',
            'category'       => 'required|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email'          => Auth::check() ? 'nullable|email' : 'required|email',
        ];
    }
}
