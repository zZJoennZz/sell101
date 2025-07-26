<x-admin-layout>
    <x-slot:title>
        Add Product Category
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.productcategories') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding:0;">
        <div class="row" style="margin-bottom:0;">
            <div class="col s12 m8 offset-m2" style="padding:0;">
                <div class="card" style="margin:0;">
                    <div class="card-content" style="padding-bottom:0;">
                        <div class="row valign-wrapper" style="margin-bottom: 24px;">
                            <div class="col s3 m2 center-align" style="padding:0;">
                                <i class="material-icons large teal-text" style="font-size:2.5rem;">category</i>
                            </div>
                            <div class="col s9 m10" style="padding-left:0;">
                                <span class="card-title" style="margin-bottom:0; font-size:1.5rem;">Add Product Category</span>
                                <p class="grey-text" style="font-size:1rem;">Create a new category for your products.</p>
                            </div>
                        </div>
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
                        <form id="add-category-form" method="POST" action="{{ route('admin.storeproductcategory') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row" style="margin-bottom:0;">
                                <div class="input-field col s12" style="margin-bottom:8px;">
                                    <input id="name" name="name" type="text" class="validate @error('name') invalid @enderror" value="{{ old('name') }}" required>
                                    <label for="name" @if(old('name')) class="active" @endif>Name</label>
                                    <span class="helper-text" data-error="Required" data-success="">Category name (e.g. Pain Relief)</span>
                                </div>
                                <div class="input-field col s12" style="margin-bottom:8px;">
                                    <input id="slug" name="slug" type="text" class="validate @error('slug') invalid @enderror" value="{{ old('slug') }}" required>
                                    <label for="slug" @if(old('slug')) class="active" @endif>Slug</label>
                                    <span class="helper-text" data-error="Required" data-success="">URL-friendly identifier (e.g. pain-relief)</span>
                                </div>
                                <div class="input-field col s12" style="margin-bottom:8px;">
                                    <textarea id="description" name="description" class="materialize-textarea @error('description') invalid @enderror">{{ old('description') }}</textarea>
                                    <label for="description" @if(old('description')) class="active" @endif>Description</label>
                                    <span class="helper-text" data-error="Required" data-success="">Short description of the category.</span>
                                </div>
                                <div class="file-field input-field col s12" style="margin-bottom:8px;">
                                    <div class="btn">
                                        <span>Image</span>
                                        <input type="file" id="image" name="image" accept="image/*">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate @error('image') invalid @enderror" type="text" placeholder="Upload image">
                                    </div>
                                    <span class="helper-text">Category image (optional, jpg/png)</span>
                                </div>
                                <div class="input-field col s12" style="margin-bottom:8px;">
                                    <select id="status" name="status" required class="@error('status') invalid @enderror">
                                        <option value="" disabled {{ old('status') ? '' : 'selected' }}>Choose status</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                                <div class="col s12 right-align" style="margin-top:16px; margin-bottom:16px;">
                                    <button class="btn waves-effect waves-light" type="submit" style="width:100%;max-width:220px;">Add Category
                                        <i class="material-icons right">send</i>
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
        });
    </script>
</x-admin-layout>