<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function create()
    {
        return view('pages.admin.add-product-category');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:product_categories,name',
            'slug'        => 'required|string|max:255|unique:product_categories,slug|alpha_dash',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_categories', 'public');
        }

        ProductCategory::create([
            'name'        => $validated['name'],
            'slug'        => $validated['slug'],
            'description' => $validated['description'],
            'image'       => $imagePath,
            'status'      => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Product category added successfully!');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('pages.admin.edit-product-category', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:product_categories,name,' . $category->id,
            'slug'        => 'required|string|max:255|unique:product_categories,slug,' . $category->id . '|alpha_dash',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imagePath = $request->file('image')->store('product_categories', 'public');
            $category->image = $imagePath;
        }

        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->description = $validated['description'];
        $category->status = $validated['status'];
        $category->save();

        return redirect()->back()->with('success', 'Product category updated successfully!');
    }

    public function index(Request $request)
    {
        $query = ProductCategory::query();

        if ($search = $request->input('search')) {
            $search = trim($search); // trim whitespace
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.admin.view-product-categories', compact('categories', 'search'));
    }
}
