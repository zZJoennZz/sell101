<x-admin-layout>
    <x-slot:title>
        Stock Transactions
    </x-slot>
    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col s12 m12">
                <form method="GET" action="{{ route('admin.stocktransactions') }}">
                    <div class="row" style="margin-bottom:0;">
                        <div class="input-field col s12 m3">
                            <select name="type">
                                <option value="" {{ request('type') == '' ? 'selected' : '' }}>All Types</option>
                                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Stock In</option>
                                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Stock Out</option>
                            </select>
                            <label>Transaction Type</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select name="batch">
                                <option value="" {{ request('batch') == '' ? 'selected' : '' }}>All Batches</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id }}" {{ request('batch') == $batch->id ? 'selected' : '' }}>
                                        {{ $batch->productVariation->product->name ?? '' }} - {{ $batch->productVariation->name ?? '' }} | Batch: {{ $batch->batch_number }}
                                    </option>
                                @endforeach
                            </select>
                            <label>Batch</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input type="date" name="date_from" value="{{ request('date_from') }}">
                            <label class="active">From</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input type="date" name="date_to" value="{{ request('date_to') }}">
                            <label class="active">To</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <button type="submit" class="btn waves-effect waves-light teal" style="width:100%;">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col s12 right-align" style="margin-bottom:16px;">
                <a href="{{ route('admin.stocktransactions.create') }}" class="btn waves-effect waves-light teal">
                    <i class="material-icons left">add</i>Add Stock Transaction
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Stock Transactions</span>
                <div class="responsive-table">
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Product</th>
                                <th>Variation</th>
                                <th>Batch</th>
                                <th>Qty</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $tx)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $tx->transaction_type == 'in' ? 'green white-text' : 'red white-text' }}">
                                            {{ strtoupper($tx->transaction_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $tx->stockBatch->productVariation->product->name ?? '-' }}</td>
                                    <td>{{ $tx->stockBatch->productVariation->name ?? '-' }}</td>
                                    <td>{{ $tx->stockBatch->batch_number ?? '-' }}</td>
                                    <td>{{ $tx->quantity }}</td>
                                    <td>{{ $tx->remarks }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="center-align grey-text">No transactions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="center" style="margin-top:20px;">
                    {{ $transactions->appends(request()->query())->links() }}
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
