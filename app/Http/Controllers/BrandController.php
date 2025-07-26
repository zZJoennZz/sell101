<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    //

    public function create()
    {
        return view('pages.admin.add-brand');
    }

    public function index(Request $request)
    {
        $query = Brand::query();

        if ($search = $request->input('search')) {
            $search = trim($search); // trim whitespace
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $brands = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.admin.view-brands', compact('brands', 'search'));
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('pages.admin.edit-brand', compact('brand'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:brands,name',
            'slug'        => 'required|string|max:255|unique:brands,slug|alpha_dash',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands', 'public');
        }

        Brand::create([
            'name'        => $validated['name'],
            'slug'        => $validated['slug'],
            'description' => $validated['description'],
            'logo'        => $imagePath,
            'status'      => $validated['status'],
        ]);

        return redirect()->route('admin.brands')->with('success', 'Brand added successfully!');
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'slug'        => 'required|string|max:255|unique:brands,slug,' . $brand->id . '|alpha_dash',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $imagePath = $request->file('image')->store('brands', 'public');
            $brand->logo = $imagePath;
        }

        $brand->name = $validated['name'];
        $brand->slug = $validated['slug'];
        $brand->description = $validated['description'];
        $brand->status = $validated['status'];
        $brand->save();

        return redirect()->back()->with('success', 'Brand updated successfully!');
    }
}
