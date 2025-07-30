<x-admin-layout>
    <x-slot:title>
        List of Product Categories
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.productsdash') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col s12 m8">
                <form method="GET" action="{{ route('admin.productcategories') }}">
                    <div class="input-field" style="margin-bottom:0;">
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Search categories by name, slug, or description">
                        <label for="search" @if(request('search')) class="active" @endif>Search</label>
                        <button type="submit" class="btn waves-effect waves-light teal" style="margin-top:8px;">
                            <i class="material-icons left">search</i> Search
                        </button>
                        <a href="{{ route('admin.productcategories') }}" class="btn-flat" style="margin-top:8px;">Reset</a>
                    </div>
                </form>
            </div>
            <div class="col s12 m4 right-align" style="margin-top:16px;">
                <a href="{{ route('admin.addproductcategory') }}" class="btn waves-effect waves-light teal">
                    <i class="material-icons left">add</i>Add Category
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <span class="card-title">Product Categories</span>
                <div class="responsive-table">
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $category->description }}</td>
                                    <td>
                                        <span class="new badge {{ $category->status == 'active' ? 'green' : 'grey' }}" data-badge-caption="{{ ucfirst($category->status) }}"></span>
                                    </td>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                                        @else
                                            <span class="grey-text">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.editproductcategory', $category->id) }}" class="btn-small waves-effect waves-light teal"><i class="material-icons">edit</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="center-align grey-text">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="center" style="margin-top:20px;">
                    {{ $categories->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
