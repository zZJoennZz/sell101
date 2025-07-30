<x-admin-layout>
    <x-slot:title>
        Reports List
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>Inventory Reports</h5>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Stock Level Report</span>
                        <p>View current stock levels for all products</p>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('admin.stock-level') }}">View Report</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Low Stock Report</span>
                        <p>View products with low stock levels</p>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('admin.low-stock') }}">View Report</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Stock Movement Report</span>
                        <p>View stock movements over a specified period</p>
                    </div>
                    <div class="card-action">
                        <a href="{{  route('admin.stock-movement') }}">View Report</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <h5>Product Reports</h5>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Product Listing Report</span>
                        <p>View a list of all products</p>
                    </div>
                    <div class="card-action">
                        <a href="#">View Report</a>
                    </div>
                </div>
            </div>
            <!-- Add more product report cards here -->
        </div>
        <!-- Add more report categories here -->
    </div>
</x-admin-layout>