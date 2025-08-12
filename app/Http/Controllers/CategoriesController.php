<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::where('user_id', Auth::id())->get();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Untuk web: return view('categories.create');
        // Untuk API: bisa dikosongkan atau return response kosong
        return response()->json(['message' => 'Show create form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);
        $validated['user_id'] = Auth::id();
        $category = Categories::create($validated);
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Categories::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Untuk web: return view('categories.edit', compact('category'));
        // Untuk API: bisa dikosongkan atau return response kosong
        return response()->json(['message' => 'Show edit form']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Categories::where('user_id', Auth::id())->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);
        $category->update($validated);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Categories::where('user_id', Auth::id())->findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}
