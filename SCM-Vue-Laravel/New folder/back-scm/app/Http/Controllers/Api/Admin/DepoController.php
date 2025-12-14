<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depo;
use Illuminate\Http\Request;

class DepoController extends Controller
{
    /**
     * Display a listing of the resource (List).
     * GET /api/admin/depos
     */
    public function index()
    {
        // সমস্ত কলাম সিলেক্ট করে, নাম অনুযায়ী সাজানো
        return Depo::orderBy('name', 'asc')->get();
    }

    /**
     * Store a newly created resource in storage (Create).
     * POST /api/admin/depos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:depos,name',
            'location' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $depo = Depo::create($validated);

        return response()->json($depo, 201);
    }

    /**
     * Display the specified resource (Show/Fetch for Edit).
     * GET /api/admin/depos/{id}
     */
    public function show(string $id)
    {
        return Depo::findOrFail($id);
    }

    /**
     * Update the specified resource in storage (Update).
     * PATCH/PUT /api/admin/depos/{id}
     */
    public function update(Request $request, string $id)
    {
        $depo = Depo::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255', 
                // নিজের নাম ছাড়া অন্য কারো সাথে যেন না মেলে
                \Illuminate\Validation\Rule::unique('depos', 'name')->ignore($depo->id),
            ],
            'location' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $depo->update($validated);

        return response()->json($depo, 200);
    }

    /**
     * Remove the specified resource from storage (Delete).
     * DELETE /api/admin/depos/{id}
     */
    public function destroy(string $id)
    {
        $depo = Depo::findOrFail($id);
        $depo->delete();

        return response()->json(['message' => 'Depo deleted successfully'], 200);
    }
}