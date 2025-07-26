<x-admin-layout>
    <x-slot:title>
        Products Dashboard
    </x-slot>
    <div class="container" style="padding-top: 20px;">
        <form method="GET" action="{{ route('admin.productsdash') }}">
            <div class="row" style="margin-bottom:0;">
                <div class="input-field col s12 m3">
                    <input type="date" name="date_from" value="{{ $dateFrom }}">
                    <label class="active">From</label>
                </div>
                <div class="input-field col s12 m3">
                    <input type="date" name="date_to" value="{{ $dateTo }}">
                    <label class="active">To</label>
                </div>
                <div class="input-field col s12 m3">
                    <select name="transaction_type">
                        <option value="" {{ $type == '' ? 'selected' : '' }}>All Types</option>
                        <option value="in" {{ $type == 'in' ? 'selected' : '' }}>Stock In</option>
                        <option value="out" {{ $type == 'out' ? 'selected' : '' }}>Stock Out</option>
                    </select>
                    <label>Transaction Type</label>
                </div>
                <div class="input-field col s12 m3">
                    <button type="submit" class="btn waves-effect waves-light teal" style="width:100%;margin-top:10px;">Filter</button>
                </div>
            </div>
        </form>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col s12">
                <div class="card-panel" style="padding: 20px 10px;">
                    <div class="row">
                        <div class="col s6 m4" style="font-size: 0.7em; color: gray; font-style: italic;">
                            MENU
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 0;">
                        <div class="col s6 m4 l2">
                            <a href="{{ route('admin.productcategories') }}" class="btn waves-effect waves-light teal" style="width:100%;">
                            <i class="material-icons left">category</i> Categories
                            </a>
                        </div>
                        <div class="col s6 m4 l2">
                            <a href="{{ route('admin.brands') }}" class="btn waves-effect waves-light teal" style="width:100%;">
                            <i class="material-icons left">branding_watermark</i> Brands
                            </a>
                        </div>
                        <div class="col s6 m4 l2">
                            <a href="{{ route('admin.products') }}" class="btn waves-effect waves-light teal" style="width:100%;">
                            <i class="material-icons left">local_pharmacy</i> Products
                            </a>
                        </div>
                        <div class="col s6 m4 l2">
                            <a href="{{ route('admin.stockbatches') }}" class="btn waves-effect waves-light teal" style="width:100%;">
                            <i class="material-icons left">layers</i>Batches
                            </a>
                        </div>
                        <div class="col s6 m4 l2">
                            <a href="{{ route('admin.stocktransactions') }}" class="btn waves-effect waves-light teal" style="width:100%;">
                            <i class="material-icons left">swap_horiz</i>Stocks
                            </a>
                        </div>
                        <div class="col s6 m4 l2">
                            <a href="{{ route('admin.stocktransactions') }}" class="btn waves-effect waves-light teal" style="width:100%;">
                            <i class="material-icons left">star_border</i>Reviews
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 l4">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">local_pharmacy</i>
                        <h5>{{ $productCount }}</h5>
                        <p>Products</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">layers</i>
                        <h5>{{ $batchCount }}</h5>
                        <p>Batches</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card small">
                    <div class="card-content center">
                        <i class="material-icons large teal-text">swap_horiz</i>
                        <h5>{{ $transactionCount }}</h5>
                        <p>Transactions</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Stock Transactions (Filtered)</span>
                <canvas id="transactionsChart" height="80"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Recent Products</span>
                        <ul class="collection">
                            @foreach($recentProducts as $product)
                                <li class="collection-item">
                                    <span class="title bold">{{ $product->name }}</span>
                                    <p>
                                        Category: {{ $product->product_category->name ?? '-' }}<br>
                                        Stock: {{ $product->stock }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Recent Transactions</span>
                        <ul class="collection">
                            @foreach($recentTransactions as $tx)
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
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('transactionsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $days->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toJson() !!},
                    datasets: [
                        {
                            label: 'Stock In',
                            data: {!! $inData->toJson() !!},
                            borderColor: 'rgba(0, 150, 136, 1)',
                            backgroundColor: 'rgba(0, 150, 136, 0.1)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Stock Out',
                            data: {!! $outData->toJson() !!},
                            borderColor: 'rgba(244,67,54,1)',
                            backgroundColor: 'rgba(244,67,54,0.1)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });
    </script>
</x-admin-layout>