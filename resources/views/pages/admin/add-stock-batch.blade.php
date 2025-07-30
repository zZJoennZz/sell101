<x-admin-layout>
    <x-slot:title>
        Add Stock Batch
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.stockbatches') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding:0;">
        <div class="row" style="margin-bottom:0;">
            <div class="col s12 m8 offset-m2" style="padding:0;">
                <div class="card" style="margin:0;">
                    <div class="card-content">
                        <span class="card-title" style="font-size:1.5rem;">Add Stock Batch</span>
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
                        <form method="POST" action="{{ route('admin.stockbatches.store') }}">
                            @csrf
                            <div class="row" style="margin-bottom:0;">
                                <div class="input-field col s12 m6">
                                    <select id="product_id" name="product_id" required>
                                        <option value="" disabled selected>Choose product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Product</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="product_variation_id" name="product_variation_id" required>
                                        <option value="" disabled selected>Choose variation</option>
                                        @foreach($variations as $variation)
                                            <option value="{{ $variation->id }}" data-product="{{ $variation->product_id }}">
                                                {{ $variation->product->name ?? '' }} - {{ $variation->name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Product Variation</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="batch_number" name="batch_number" type="text" value="{{ old('batch_number') }}" required>
                                    <label for="batch_number" @if(old('batch_number')) class="active" @endif>Batch Number</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="unit_price" name="unit_price" type="text" value="{{ old('unit_price') }}" required>
                                    <label for="unit_price" @if(old('unit_price')) class="active" @endif>Unit Price</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="has_expiry" name="has_expiry" required>
                                        <option value="1" {{ old('has_expiry') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('has_expiry') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                    <label>Has Expiry?</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="manufacture_date" name="manufacture_date" type="date" value="{{ old('manufacture_date') }}">
                                    <label for="manufacture_date" class="active">Manufacture Date</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="expiry_date" name="expiry_date" type="date" value="{{ old('expiry_date') }}">
                                    <label for="expiry_date" class="active">Expiry Date</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <label>Status</label>
                                </div>
                                <div class="col s12 right-align" style="margin-top:16px; margin-bottom:16px;">
                                    <button class="btn waves-effect waves-light" type="submit" style="width:100%;max-width:220px;">Add Batch
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

            // Filtering variations based on product
            const productSelect = document.getElementById('product_id');
            const variationSelect = document.getElementById('product_variation_id');
            const allOptions = Array.from(variationSelect.options);

            productSelect.addEventListener('change', function() {
                const productId = this.value;
                // Remove all except the first option
                variationSelect.innerHTML = '';
                const firstOption = document.createElement('option');
                firstOption.value = '';
                firstOption.disabled = true;
                firstOption.selected = true;
                firstOption.textContent = 'Choose variation';
                variationSelect.appendChild(firstOption);

                allOptions.forEach(function(opt) {
                    if (opt.value && opt.getAttribute('data-product') == productId) {
                        variationSelect.appendChild(opt.cloneNode(true));
                    }
                });
                M.FormSelect.init(variationSelect);
            });
        });
    </script>
</x-admin-layout>