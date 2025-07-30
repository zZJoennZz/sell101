<x-admin-layout>
    <x-slot:title>
        List of Brands
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.productsdash') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col s12 m8">
                <form method="GET" action="{{ route('admin.brands') }}">
                    <div class="input-field" style="margin-bottom:0;">
                        <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Search brands by name, slug, or description">
                        <label for="search" @if(request('search')) class="active" @endif>Search</label>
                        <button type="submit" class="btn waves-effect waves-light teal" style="margin-top:8px;">
                            <i class="material-icons left">search</i> Search
                        </button>
                        <a href="{{ route('admin.brands') }}" class="btn-flat" style="margin-top:8px;">Reset</a>
                    </div>
                </form>
            </div>
            <div class="col s12 m4 right-align" style="margin-top:16px;">
                <!-- Adjust the route according to your actual add brand route -->
                <a href="{{ route('admin.addbrand') }}" class="btn waves-effect waves-light teal">
                    <i class="material-icons left">add</i>Add Brand
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
                <span class="card-title">Brands</span>
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
                            @forelse($brands as $brand)
                                <tr>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $brand->description }}</td>
                                    <td>
                                        <span class="new badge {{ $brand->status == 'active' ? 'green' : 'grey' }}" data-badge-caption="{{ ucfirst($brand->status) }}"></span>
                                    </td>
                                    <td>
                                        @if($brand->image)
                                            <img src="{{ asset('storage/' . $brand->image) }}" alt="Image" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">
                                        @else
                                            <span class="grey-text">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Adjust the route according to your actual edit brand route -->
                                        <a href="{{ route('admin.editbrand', $brand->id) }}" class="btn-small waves-effect waves-light teal"><i class="material-icons">edit</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="center-align grey-text">No brands found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="center" style="margin-top:20px;">
                    {{ $brands->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>