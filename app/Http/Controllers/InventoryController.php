<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreInventoryRequest;
use App\Models\Inventory; // <-- WAJIB TAMBAH INI
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View; // <-- Tambah ini untuk clean code (Return type)

class InventoryController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    public function store(StoreInventoryRequest $request): RedirectResponse
    {
        $this->inventoryService->store($request->validated());

        return back()->with('success', 'Barang berjaya direkodkan!');
    }

    public function index(): View // Tambah return type
    {
        // Pastikan hanya user yang dah login boleh tengok dashboard
        $items = $this->inventoryService->getUserInventories(Auth::id());
        
        return view('dashboard', compact('items'));
    }

    public function edit(Inventory $inventory): View // Tambah return type
    {
        // Pastikan user hanya boleh edit barang dia sendiri (Security)
        abort_if($inventory->user_id !== Auth::id(), 403);

        return view('edit', compact('inventory'));
    }

    public function update(StoreInventoryRequest $request, Inventory $inventory): RedirectResponse
    {
        // Pastikan user hanya boleh edit barang dia sendiri (Security)
        abort_if($inventory->user_id !== Auth::id(), 403);

        $this->inventoryService->update($inventory, $request->validated());

        return redirect()->route('dashboard')->with('success', 'Barang berjaya dikemaskini!');
    }
}