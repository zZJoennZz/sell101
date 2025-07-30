<x-admin-layout>
    <x-slot:title>
        List of Products
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.productsdash') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col s12 m8">
                <form method="GET" action="{{ route('admin.products') }}">
                    <div class="input-field" style="margin-bottom:0;">
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Search products by name, slug, or description">
                        <label for="search" @if(request('search')) class="active" @endif>Search</label>
                        <button type="submit" class="btn waves-effect waves-light teal" style="margin-top:8px;">
                            <i class="material-icons left">search</i> Search
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn-flat" style="margin-top:8px;">Reset</a>
                    </div>
                </form>
            </div>
            <div class="col s12 m4 right-align" style="margin-top:16px;">
                <a href="{{ route('admin.addproduct') }}" class="btn waves-effect waves-light teal">
                    <i class="material-icons left">add</i>Add Product
                </a>
            </div>
        </div>
        <div class="row">
            @if(session('success'))
                <div class="card-panel green lighten-4 green-text text-darken-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Products</span>
                <div class="responsive-table">
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->slug }}</td>
                                    <td>{{ $product->product_category->name ?? '-' }}</td>
                                    <td>{{ $product->brand->name ?? '-' }}</td>
                                    <td>
                                        <span class="new badge {{ $product->status == 'active' ? 'green' : 'grey' }}" data-badge-caption="{{ ucfirst($product->status) }}"></span>
                                    </td>
                                    <td>
                                        @if($product->images->count())
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="Image" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                                        @else
                                            <span class="grey-text">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.editproduct', $product->id) }}" class="btn-small waves-effect waves-light teal"><i class="material-icons">edit</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="center-align grey-text">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="center" style="margin-top:20px;">
                    {{ $products->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
