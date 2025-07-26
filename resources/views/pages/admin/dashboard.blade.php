<x-admin-layout>
    <x-slot:title>
        Admin Dashboard
    </x-slot>
    <div class="container" style="padding-top: 20px;">
        <form method="GET" action="{{ route('admin.dashboard') }}">
            <div class="row" style="margin-bottom:0;">
                <div class="input-field col s12 m4">
                    <input type="date" name="date_from" value="{{ $dateFrom }}">
                    <label class="active">From</label>
                </div>
                <div class="input-field col s12 m4">
                    <input type="date" name="date_to" value="{{ $dateTo }}">
                    <label class="active">To</label>
                </div>
                <div class="input-field col s12 m4">
                    <button type="submit" class="btn waves-effect waves-light teal" style="width:100%;margin-top:10px;">Filter</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col s12 m4">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">local_pharmacy</i>
                        <h5>{{ $productCount }}</h5>
                        <p>Total Products</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">shopping_cart</i>
                        <h5>{{ $orderCount }}</h5>
                        <p>Total Orders <span class="grey-text">(placeholder)</span></p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">hourglass_empty</i>
                        <h5>{{ $pendingOrders }}</h5>
                        <p>Pending Orders <span class="grey-text">(placeholder)</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">check_circle</i>
                        <h5>{{ $completedOrders }}</h5>
                        <p>Completed Orders <span class="grey-text">(placeholder)</span></p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Last 5 Stock Transactions</span>
                        <ul class="collection">
                            @forelse($recentTransactions as $tx)
                                <li class="collection-item">
                                    <span class="badge {{ $tx->transaction_type == 'in' ? 'green white-text' : 'red white-text' }}">{{ strtoupper($tx->transaction_type) }}</span>
                                    <span class="title">{{ $tx->stockBatch->productVariation->product->name ?? '-' }}</span>
                                    <p>
                                        Variation: {{ $tx->stockBatch->productVariation->name ?? '-' }}<br>
                                        Batch: {{ $tx->stockBatch->batch_number ?? '-' }}<br>
                                        Qty: {{ $tx->quantity }}<br>
                                        Date: {{ \Carbon\Carbon::parse($tx->transaction_date)->format('Y-m-d H:i') }}
                                    </p>
                                </li>
                            @empty
                                <li class="collection-item grey-text">No transactions found.</li>
                            @endforelse
                        </ul>
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