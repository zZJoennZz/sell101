<x-admin-layout>
    <x-slot:title>
        Add Stock Transaction
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ url()->previous() }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container" style="padding:0;">
        <div class="row" style="margin-bottom:0;">
            <div class="col s12 m8 offset-m2" style="padding:0;">
                <div class="card" style="margin:0;">
                    <div class="card-content">
                        <span class="card-title" style="font-size:1.5rem;">Add Stock Transaction</span>
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
                        <form method="POST" action="{{ route('admin.stocktransactions.store') }}">
                            @csrf
                            <div class="row" style="margin-bottom:0;">
                                <div class="input-field col s12">
                                    <select id="stock_batch_id" name="stock_batch_id" required>
                                        <option value="" disabled selected>Choose batch</option>
                                        @foreach($batches as $batch)
                                            <option value="{{ $batch->id }}">
                                                {{ $batch->productVariation->product->name ?? '' }} - {{ $batch->productVariation->name ?? '' }} | Batch: {{ $batch->batch_number }} | Qty: {{ $batch->quantity }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label>Stock Batch</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select id="transaction_type" name="transaction_type" required>
                                        <option value="" disabled selected>Choose type</option>
                                        <option value="in">Stock In</option>
                                        <option value="out">Stock Out</option>
                                    </select>
                                    <label>Transaction Type</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="quantity" name="quantity" type="number" min="1" required value="{{ old('quantity') }}">
                                    <label for="quantity" @if(old('quantity')) class="active" @endif>Quantity</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="transaction_date" name="transaction_date" type="datetime-local" required value="{{ old('transaction_date') }}">
                                    <label for="transaction_date" class="active">Transaction Date</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="remarks" name="remarks" type="text" value="{{ old('remarks') }}">
                                    <label for="remarks" @if(old('remarks')) class="active" @endif>Remarks</label>
                                </div>
                                <div class="col s12 right-align" style="margin-top:16px; margin-bottom:16px;">
                                    <button class="btn waves-effect waves-light" type="submit" style="width:100%;max-width:220px;">Save Transaction
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
