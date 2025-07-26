<x-admin-layout>
    <x-slot:title>
        Edit Product
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.products') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding:0;">
        <div class="row" style="margin-bottom:0;">
            <div class="col s12 m10 offset-m1" style="padding:0;">
                <div class="card" style="margin:0;">
                    <div class="card-content" style="padding-bottom:0;">
                        <span class="card-title" style="font-size:1.5rem;">Edit Product</span>
                        @if(session('success'))
                            <div class="card-panel green lighten-4 green-text text-darken-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="card-panel red lighten-4 red-text text-darken-4">
                                <ul style="margin:0;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.updateproduct', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row" style="margin-bottom:0;">
                                <div class="input-field col s12 m6">
                                    <input id="name" name="name" type="text" class="validate @error('name') invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                    <label for="name" class="active">Name</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="slug" name="slug" type="text" class="validate @error('slug') invalid @enderror" value="{{ old('slug', $product->slug) }}" required>
                                    <label for="slug" class="active">Slug</label>
                                </div>
                                <div class="input-field col s12">
                                    <textarea id="description" name="description" class="materialize-textarea @error('description') invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                    <label for="description" class="active">Description</label>
                                </div>
                                <div class="input-field col s12">
                                    <select id="status" name="status" required class="@error('status') invalid @enderror">
                                        <option value="" disabled>Choose status</option>
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="product_category_id" name="product_category_id" required class="@error('product_category_id') invalid @enderror">
                                        <option value="" disabled>Choose category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Category</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="brand_id" name="brand_id" class="@error('brand_id') invalid @enderror">
                                        <option value="" disabled>Choose brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Brand</label>
                                </div>
                                <div class="file-field input-field col s12">
                                    <div class="btn">
                                        <span>Images</span>
                                        <input type="file" name="images[]" multiple accept="image/*">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate @error('images.*') invalid @enderror" type="text" placeholder="Upload one or more images">
                                    </div>
                                    <div style="margin-top:8px;">
                                        @foreach($product->images as $img)
                                            <span class="product-image-thumb" style="display:inline-block;position:relative;margin-right:8px;">
                                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                                                <button type="button" class="btn-flat btn-small remove-image-btn" data-image-id="{{ $img->id }}" data-product-id="{{ $product->id }}" style="position:absolute;top:-10px;right:-10px;padding:0;min-width:24px;">
                                                    <i class="material-icons red-text" style="font-size:18px;">close</i>
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col s12">
                                    <h6>Attributes</h6>
                                    <div id="attributes-list">
                                        @php $attrs = old('attributes', $product->attributes->toArray()); @endphp
                                        @for($i = 0; $i < max(1, count($attrs)); $i++)
                                            <div class="row" style="margin-bottom:0;">
                                                <div class="input-field col s5">
                                                    <input type="text" name="attributes[{{$i}}][name]" value="{{ $attrs[$i]['name'] ?? '' }}" placeholder="Attribute Name">
                                                </div>
                                                <div class="input-field col s5">
                                                    <input type="text" name="attributes[{{$i}}][value]" value="{{ $attrs[$i]['value'] ?? '' }}" placeholder="Attribute Value">
                                                </div>
                                                <div class="col s2" style="margin-top:20px;">
                                                    <button type="button" class="btn-small red remove-attr-btn"><i class="material-icons">remove</i></button>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <button type="button" class="btn teal btn-small" id="add-attribute-btn"><i class="material-icons left">add</i>Add Attribute</button>
                                </div>
                                <div class="col s12" style="margin-top:24px;">
                                    <h6>Variations</h6>
                                    <div id="variations-list">
                                        @php $vars = old('variations', $product->variations->toArray()); @endphp
                                        @for($i = 0; $i < max(1, count($vars)); $i++)
                                            <div class="row" style="margin-bottom:0;">
                                                <div class="input-field col s3">
                                                    <input type="text" name="variations[{{$i}}][name]" value="{{ $vars[$i]['name'] ?? '' }}" placeholder="Variation Name">
                                                </div>
                                                <div class="input-field col s3">
                                                    <input type="text" name="variations[{{$i}}][sku]" value="{{ $vars[$i]['sku'] ?? '' }}" placeholder="SKU">
                                                </div>
                                                <div class="input-field col s3">
                                                    <input type="number" step="0.01" min="0" name="variations[{{$i}}][price]" value="{{ $vars[$i]['price'] ?? '' }}" placeholder="Price">
                                                </div>
                                                <div class="input-field col s2">
                                                    <select name="variations[{{$i}}][status]">
                                                        <option value="active" {{ ($vars[$i]['status'] ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                                        <option value="inactive" {{ ($vars[$i]['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                    <label>Status</label>
                                                </div>
                                                <div class="col s1" style="margin-top:20px;">
                                                    <button type="button" class="btn-small red remove-var-btn"><i class="material-icons">remove</i></button>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <button type="button" class="btn teal btn-small" id="add-variation-btn"><i class="material-icons left">add</i>Add Variation</button>
                                </div>
                                <div class="col s12 right-align" style="margin-top:24px; margin-bottom:16px;">
                                    <button class="btn waves-effect waves-light" type="submit" style="width:100%;max-width:220px;">Update Product
                                        <i class="material-icons right">save</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);

            // Attribute dynamic add/remove
            let attrIdx = {{ max(1, count(old('attributes', $product->attributes))) }};
            document.getElementById('add-attribute-btn').onclick = function() {
                let html = `<div class="row" style="margin-bottom:0;">
                    <div class="input-field col s5">
                        <input type="text" name="attributes[${attrIdx}][name]" placeholder="Attribute Name">
                    </div>
                    <div class="input-field col s5">
                        <input type="text" name="attributes[${attrIdx}][value]" placeholder="Attribute Value">
                    </div>
                    <div class="col s2" style="margin-top:20px;">
                        <button type="button" class="btn-small red remove-attr-btn"><i class="material-icons">remove</i></button>
                    </div>
                </div>`;
                document.getElementById('attributes-list').insertAdjacentHTML('beforeend', html);
                attrIdx++;
            };
            document.getElementById('attributes-list').addEventListener('click', function(e) {
                if (e.target.closest('.remove-attr-btn')) {
                    e.target.closest('.row').remove();
                }
            });

            // Variation dynamic add/remove
            let varIdx = {{ max(1, count(old('variations', $product->variations))) }};
            document.getElementById('add-variation-btn').onclick = function() {
                let html = `<div class="row" style="margin-bottom:0;">
                    <div class="input-field col s3">
                        <input type="text" name="variations[${varIdx}][name]" placeholder="Variation Name">
                    </div>
                    <div class="input-field col s3">
                        <input type="text" name="variations[${varIdx}][sku]" placeholder="SKU">
                    </div>
                    <div class="input-field col s3">
                        <input type="number" step="0.01" min="0" name="variations[${varIdx}][price]" placeholder="Price">
                    </div>
                    <div class="input-field col s2">
                        <select name="variations[${varIdx}][status]">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <label>Status</label>
                    </div>
                    <div class="col s1" style="margin-top:20px;">
                        <button type="button" class="btn-small red remove-var-btn"><i class="material-icons">remove</i></button>
                    </div>
                </div>`;
                document.getElementById('variations-list').insertAdjacentHTML('beforeend', html);
                varIdx++;
                M.FormSelect.init(document.querySelectorAll('select'));
            };
            document.getElementById('variations-list').addEventListener('click', function(e) {
                if (e.target.closest('.remove-var-btn')) {
                    e.target.closest('.row').remove();
                }
            });

            // Remove image via AJAX
            document.querySelectorAll('.remove-image-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!confirm('Remove this image?')) return;
                    var imageId = btn.getAttribute('data-image-id');
                    var productId = btn.getAttribute('data-product-id');
                    fetch("{{ url('admin/products') }}/" + productId + "/images/" + imageId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            btn.closest('.product-image-thumb').remove();
                        }
                    });
                });
            });
        });
    </script>
</x-admin-layout>
