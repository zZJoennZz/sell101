<x-admin-layout>
    <x-slot:title>
        Stock Batches
    </x-slot>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col s12 m12">
                <form method="GET" action="{{ route('admin.stockbatches') }}">
                    <div class="row" style="margin-bottom:0;">
                        <div class="input-field col s12 m4">
                            <select name="product_variation_id">
                                <option value="" {{ request('product_variation_id') == '' ? 'selected' : '' }}>All Variations</option>
                                @foreach($variations as $variation)
                                    <option value="{{ $variation->id }}" {{ request('product_variation_id') == $variation->id ? 'selected' : '' }}>
                                        {{ $variation->product->name ?? '' }} - {{ $variation->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Product Variation</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <select name="status">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <label>Status</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <button type="submit" class="btn waves-effect waves-light teal" style="width:100%;">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s12 right-align" style="margin-bottom:16px;">
                <a href="{{ route('admin.stockbatches.create') }}" class="btn waves-effect waves-light teal">
                    <i class="material-icons left">add</i>Add Stock Batch
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Stock Batches</span>
                <div class="responsive-table">
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variation</th>
                                <th>Batch #</th>
                                <th>Qty</th>
                                <th>Has Expiry</th>
                                <th>Mfg Date</th>
                                <th>Exp Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($batches as $batch)
                                <tr>
                                    <td>{{ $batch->productVariation->product->name ?? '-' }}</td>
                                    <td>{{ $batch->productVariation->name ?? '-' }}</td>
                                    <td>{{ $batch->batch_number }}</td>
                                    <td>{{ $batch->quantity }}</td>
                                    <td>{{ $batch->has_expiry ? 'Yes' : 'No' }}</td>
                                    <td>{{ $batch->manufacture_date }}</td>
                                    <td>{{ $batch->expiry_date }}</td>
                                    <td>
                                        <span class="new badge {{ $batch->status == 'active' ? 'green' : 'grey' }}" data-badge-caption="{{ ucfirst($batch->status) }}"></span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.stockbatches.edit', $batch->id) }}" class="btn-small waves-effect waves-light teal"><i class="material-icons">remove_red_eye</i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="center-align grey-text">No batches found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="center" style="margin-top:20px;">
                    {{ $batches->appends(request()->query())->links() }}
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
