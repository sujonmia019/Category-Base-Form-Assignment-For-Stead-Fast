@extends('layouts.app')
@section('title',$title)
@push('styles')
    <style>
        #form-datatable_wrapper .dt-length{
            display: flex;
            align-items: center;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title mb-0">{{ $title }}</h5>
                </div>
                <div class="card-body">
                    <table class="table w-100 table-sm table-bordered table-hover table-striped" id="form-datatable">
                        <thead>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th class="text-right">Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        table = $('#form-datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            order: [], //Initial no order
            bInfo: true, //TO show the total number of data
            bFilter: false, //For datatable default search box show/hide
            ordering: false,
            lengthMenu: [
                [5, 10, 15, 25, 50, 100, -1],
                [5, 10, 15, 25, 50, 100, "All"]
            ],
            pageLength: "{{ TABLE_PAGE_LENGTH }}", //number of data show per page
            ajax: {
                url: "{{ route('user.dashboard') }}",
                type: "GET",
                dataType: "JSON",
                data: function(d) {
                    d._token = _token;
                    d.category = $('#category').val();
                },
            },
            columns: [
                {data: 'DT_RowIndex'},
                {data: 'category'},
                {data: 'title'},
                {data: 'description'},
                {data: 'created_by'},
                {data: 'created_at'},
                {data: 'action'}
            ],
            language: {
                emptyTable: '<strong class="text-danger">No Data Found</strong>',
                infoEmpty: '',
                zeroRecords: '<strong class="text-danger">No Data Found</strong>',
                oPaginate: {
                    sPrevious: "Previous", // This is the link to the previous page
                    sNext: "Next", // This is the link to the next page
                },
                lengthMenu: `_MENU_`,
            }
        });

        $('#form-datatable_wrapper .dt-length').append(`
            <select id="category" class="form-control form-control-sm rounded-0 ml-1" style="width: 220px;">
                <option value="">Select Category</option>
                @foreach ($categories as $key=>$value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        `);

        $(document).on('change','#category',function(){
            table.ajax.reload();
        });
    </script>
@endpush
