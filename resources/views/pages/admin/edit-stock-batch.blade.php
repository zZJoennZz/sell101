<x-admin-layout>
    <x-slot:title>
        View Stock Batch
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.stockbatches') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding:0;">
        <div class="row" style="margin-bottom:0;">
            <div class="col s12 m8 offset-m2" style="padding:0;">
                <div class="card" style="margin:0;">
                    <div class="card-content">
                        <span class="card-title" style="font-size:1.5rem;">View Stock Batch</span>
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
                        <div class="row" style="margin-bottom:0;">
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->productVariation->product->name ?? '-' }}" disabled>
                                <label class="active">Product</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->productVariation->name ?? '-' }}" disabled>
                                <label class="active">Product Variation</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <input type="text" value="{{ $batch->batch_number }}" disabled>
                                <label class="active">Batch Number</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->unit_price }}" disabled>
                                <label class="active">Unit Price</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->quantity }}" disabled>
                                <label class="active">Quantity</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->has_expiry ? 'Yes' : 'No' }}" disabled>
                                <label class="active">Has Expiry?</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->manufacture_date }}" disabled>
                                <label class="active">Manufacture Date</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ $batch->expiry_date }}" disabled>
                                <label class="active">Expiry Date</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <input type="text" value="{{ ucfirst($batch->status) }}" disabled>
                                <label class="active">Status</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
                                {{-- <div class="input-field col s12 m6">
                                    <input id="manufacture_date" name="manufacture_date" type="date" value="{{ old('manufacture_date', $batch->manufacture_date) }}">
                                    <label for="manufacture_date" class="active">Manufacture Date</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="expiry_date" name="expiry_date" type="date" value="{{ old('expiry_date', $batch->expiry_date) }}">
                                    <label for="expiry_date" class="active">Expiry Date</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="status" name="status" required>
                                        <option value="active" {{ old('status', $batch->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $batch->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                                <div class="col s12 right-align" style="margin-top:16px; margin-bottom:16px;">
                                    <button class="btn waves-effect waves-light" type="submit" style="width:100%;max-width:220px;">Update Batch
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

            // Filtering variations based on product
            const productSelect = document.getElementById('product_id');
            const variationSelect = document.getElementById('product_variation_id');
            const allOptions = Array.from(variationSelect.options);

            function filterVariations() {
                const productId = productSelect.value;
                variationSelect.innerHTML = '';
                const firstOption = document.createElement('option');
                firstOption.value = '';
                firstOption.disabled = true;
                firstOption.textContent = 'Choose variation';
                variationSelect.appendChild(firstOption);

                allOptions.forEach(function(opt) {
                    if (opt.value && opt.getAttribute('data-product') == productId) {
                        variationSelect.appendChild(opt.cloneNode(true));
                    }
                });
                M.FormSelect.init(variationSelect);
            }

            productSelect.addEventListener('change', filterVariations);

            // On page load, filter variations for the selected product
            filterVariations();
            // Set selected variation if editing
            @if(old('product_variation_id', $batch->product_variation_id))
                variationSelect.value = "{{ old('product_variation_id', $batch->product_variation_id) }}";
                M.FormSelect.init(variationSelect);
            @endif
        });
    </script>
</x-admin-layout> --}}
