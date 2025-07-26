<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['product_category', 'brand', 'images', 'variations']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.admin.view-products', compact('products', 'search'));
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 'active')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('pages.admin.add-product', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'slug'        => 'required|string|max:255|unique:products,slug|alpha_dash',
            'description' => 'nullable|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'brand_id'    => 'nullable|exists:brands,id',
            'status'      => 'required|in:active,inactive',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attributes.*.name'  => 'nullable|string|max:255',
            'attributes.*.value' => 'nullable|string|max:255',
            'variations.*.name'  => 'nullable|string|max:255',
            'variations.*.sku'   => 'nullable|string|max:255',
            'variations.*.price' => 'nullable|numeric|min:0',
            'variations.*.status' => 'nullable|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create([
                'name'        => $validated['name'],
                'slug'        => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'stock'       => 0,
                'product_category_id' => $validated['product_category_id'],
                'brand_id'    => $validated['brand_id'] ?? null,
                'status'      => $validated['status'],
            ]);

            // Attributes
            if ($request->has('attributes')) {
                foreach ($request->input('attributes') as $attr) {
                    if (!empty($attr['name']) && !empty($attr['value'])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'name'       => $attr['name'],
                            'value'      => $attr['value'],
                            'status'     => 'active',
                        ]);
                    }
                }
            }

            // Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $idx => $img) {
                    $path = $img->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $idx == 0 ? 1 : 0,
                        'alt_text'   => $product->name,
                    ]);
                }
            }

            // Variations
            if ($request->has('variations')) {
                foreach ($request->input('variations') as $var) {
                    if (!empty($var['name']) && !empty($var['sku'])) {
                        ProductVariation::create([
                            'product_id' => $product->id,
                            'name'       => $var['name'],
                            'sku'        => $var['sku'],
                            'price'      => $var['price'] ?? $product->price,
                            'status'     => $var['status'] ?? 'active',
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add product: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $product = Product::with(['attributes', 'images', 'variations'])->findOrFail($id);
        $categories = ProductCategory::where('status', 'active')->get();
        $brands = Brand::where('status', 'active')->get();
        return view('pages.admin.edit-product', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::with(['attributes', 'images', 'variations'])->findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
            'slug'        => 'required|string|max:255|unique:products,slug,' . $product->id . '|alpha_dash',
            'description' => 'nullable|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'brand_id'    => 'nullable|exists:brands,id',
            'status'      => 'required|in:active,inactive',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attributes.*.name'  => 'nullable|string|max:255',
            'attributes.*.value' => 'nullable|string|max:255',
            'variations.*.name'  => 'nullable|string|max:255',
            'variations.*.sku'   => 'nullable|string|max:255',
            'variations.*.price' => 'nullable|numeric|min:0',
            'variations.*.status' => 'nullable|in:active,inactive',
        ]);

        DB::beginTransaction();
        try {
            $product->update([
                'name'        => $validated['name'],
                'slug'        => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'product_category_id' => $validated['product_category_id'],
                'brand_id'    => $validated['brand_id'] ?? null,
                'status'      => $validated['status'],
            ]);

            // Attributes (delete all and re-add for simplicity)
            $product->attributes()->delete();
            if ($request->has('attributes')) {
                foreach ($request->input('attributes') as $attr) {
                    if (!empty($attr['name']) && !empty($attr['value'])) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'name'       => $attr['name'],
                            'value'      => $attr['value'],
                            'status'     => 'active',
                        ]);
                    }
                }
            }

            // Images (add new ones, keep old unless deleted via UI)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $path = $img->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => 0,
                        'alt_text'   => $product->name,
                    ]);
                }
            }

            // Variations (delete all and re-add for simplicity)
            $product->variations()->delete();
            if ($request->has('variations')) {
                foreach ($request->input('variations') as $var) {
                    if (!empty($var['name']) && !empty($var['sku'])) {
                        ProductVariation::create([
                            'product_id' => $product->id,
                            'name'       => $var['name'],
                            'sku'        => $var['sku'],
                            'price'      => $var['price'] ?? $product->price,
                            'status'     => $var['status'] ?? 'active',
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }

    public function removeImage(Request $request, $productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = ProductImage::where('product_id', $product->id)->where('id', $imageId)->firstOrFail();

        // Delete file from storage
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }
}
