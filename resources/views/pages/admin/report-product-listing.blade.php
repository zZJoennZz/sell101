<x-admin-layout>
    <x-slot:title>
        Product Listing Report
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.reports') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>Low Stock Report</h5>
                <a href="{{ route('admin.low-stock-print') }}" target="_blank" class="btn right">Print Preview</a>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                @if(empty($lowStockData))
                    <p>No products with low stock.</p>
                @else
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Variation</th>
                                <th>SKU</th>
                                <th>Unit</th>
                                <th>Current Stock</th>
                                <th>Max IN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockData as $row)
                                @foreach($row['variations'] as $variation)
                                    <tr>
                                        <td>{{ $row['product']->name }}</td>
                                        <td>{{ $variation['name'] }}</td>
                                        <td>{{ $variation['sku'] }}</td>
                                        <td>{{ $variation['unit'] }}</td>
                                        <td>{{ $variation['stock'] }}</td>
                                        <td>{{ $variation['max_in'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
