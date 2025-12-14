<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier; // ✅ মডেল use করা হয়েছে
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource (List).
     * GET /api/admin/suppliers
     */
    public function index()
    {
        // সাপ্লায়ারদের তালিকা নাম অনুযায়ী সাজিয়ে রিটার্ন করা হচ্ছে
        return Supplier::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage (Create).
     * POST /api/admin/suppliers
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json($supplier, 201);
    }

    /**
     * Display the specified resource (Show/Fetch for Edit).
     * GET /api/admin/suppliers/{id}
     */
    public function show(string $id)
    {
        return Supplier::findOrFail($id);
    }

    /**
     * Update the specified resource in storage (Update).
     * PATCH/PUT /api/admin/suppliers/{id}
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                \Illuminate\Validation\Rule::unique('suppliers', 'name')->ignore($supplier->id),
            ],
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $supplier->update($validated);

        return response()->json($supplier, 200);
    }

    /**
     * Remove the specified resource from storage (Delete).
     * DELETE /api/admin/suppliers/{id}
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully'], 200);
    }
}