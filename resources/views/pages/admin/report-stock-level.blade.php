<x-admin-layout>
    <x-slot:title>
        Stock Level Report
    </x-slot>
    <div style="padding-left: 25px;">
        <a href="{{ route('admin.reports') }}" class="btn-small waves-effect waves-light"><i class="small material-icons left">arrow_back</i> Back</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>Inventory Reports - Stock Level Report</h5>
            </div>
        </div>
        <div class="row">
            <form id="report-filter-form">
                <div class="col s12 m12">
                    <label for="brand">Brand:</label>
                    <select id="brand" name="brand[]" multiple>
                        <option value="all">All</option>
                        @foreach ($allBrands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12">
                    <button class="btn waves-effect waves-light" type="submit">Generate Report</button>
                </div>
            </form>
        </div>
        <div class="row">
            <iframe id="report-iframe" frameborder="0" width="100%" height="500"></iframe>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Initialize Materialize CSS components
            var brandSelect = M.FormSelect.init($('select'));
            // M.Datepicker.init($('.datepicker'), {
            //     format: 'yyyy-mm-dd'
            // });

            // Toggle date fields based on report type
            // $('#report-type').change(function() {
            //     var reportType = $(this).val();
            //     if (reportType === 'as-of') {
            //         $('#as-of-container').show();
            //         $('#date-range-container').hide();
            //     } else {
            //         $('#as-of-container').hide();
            //         $('#date-range-container').show();
            //     }
            // });

            $('#brand').change(function() {
                if ($(this).val().includes('all')) {
                    $(this).val('all');
                    brandSelect[0].destroy();
                    brandSelect = M.FormSelect.init($(this));
                }
            });

            // Load report into iframe
            $('#report-filter-form').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $('#report-iframe').attr('src', '{{ route("admin.stock-level-preview") }}?' + formData);
            });
        });
    </script>
</x-admin-layout>