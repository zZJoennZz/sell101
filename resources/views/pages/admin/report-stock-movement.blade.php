<x-admin-layout>
    <x-slot:title>
        Stock Movement Report
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.reports') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>Inventory Reports - Stock Movement Report</h5>
            </div>
        </div>
        <div class="row">
            <form id="report-filter-form">
                <div class="col s12 m6">
                    <label for="brand">Brand:</label>
                    <select id="brand" name="brand[]" multiple>
                        <option value="all">All</option>
                        @foreach ($allBrands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m3">
                    <label for="date_from" class="active">From:</label>
                    <input type="date" id="date_from" name="date_from">
                </div>
                <div class="col s12 m3">
                    <label for="date_to" class="active">To:</label>
                    <input type="date" id="date_to" name="date_to">
                </div>
                <div class="col s12" style="margin-top: 16px;">
                    <button class="btn waves-effect waves-light" type="submit">Generate Report</button>
                </div>
            </form>
        </div>
        <div class="row">
            <iframe id="report-iframe" frameborder="0" width="100%" height="500"></iframe>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            var brandSelect = M.FormSelect.init($('select'));
            $('#brand').change(function() {
                if ($(this).val().includes('all')) {
                    $(this).val('all');
                    brandSelect[0].destroy();
                    brandSelect = M.FormSelect.init($(this));
                }
            });
            $('#report-filter-form').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $('#report-iframe').attr('src', '{{ route("admin.stock-movement-preview") }}?' + formData);
            });
        });
    </script>
</x-admin-layout>
