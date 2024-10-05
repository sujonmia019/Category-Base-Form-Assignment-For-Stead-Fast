@extends('layouts.app')
@section('title',$title)
@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">{{ $title }}
                        <a href="{{ route('app.forms.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus fa-sm"></i> Add Form</a>
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table w-100 table-sm table-bordered table-hover table-striped" id="form-datatable">
                        <thead>
                            <th>
                                <div class="form-checkbox">
                                    <input type="checkbox" class="form-check-input" id="select_all" onclick="select_all()">
                                    <label class="form-check-label" for="select_all"></label>
                                </div>
                            </th>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Status</th>
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
                url: "{{ route('app.forms.index') }}",
                type: "GET",
                dataType: "JSON",
                data: function(d) {
                    d._token = _token;
                    d.search = $('input[name="search_here"]').val();
                },
            },
            columns: [
                {data: 'bulk_check'},
                {data: 'DT_RowIndex'},
                {data: 'category'},
                {data: 'title'},
                {data: 'status'},
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
                lengthMenu: `<div class='d-flex align-items-center w-100 justify-content-between'>_MENU_
                        <button type='button' style='min-width: 110px;' class='btn btn-sm btn-danger d-none rounded-0 delete_btn ml-2 px-3' onclick='multi_delete()'>Bulk Delete</button>

                        <input name='search_here' class='form-control-sm form-control ml-2' placeholder="Search here..." autocomplete="off"/>
                    </div>`,
            }
        });

        // single delete
        $(document).on('click', '.delete_data', function () {
            let id   = $(this).data('id');
            let name = $(this).data('name');
            let row  = table.row($(this).parent('tr'));
            let url  = "{{ route('app.forms.delete') }}";
            delete_data(id,url,row,name);
        });

        // multi delete
        function multi_delete(){
            let ids = [];
            let rows;
            $('.select_data:checked').each(function(){
                ids.push($(this).val());
                rows = table.rows($('.select_data:checked').parents('tr'));
            });

            if(ids.length == 0){
                Swal.fire({
                    type:'error',
                    title:'Error',
                    text:'Please checked at least one row of table!',
                    icon: 'warning',
                });
            }else{
                let url = "{{ route('app.forms.bulk-delete') }}";
                bulk_delete(ids,url,rows);
            }
        }

        // status changes
        $(document).on('click','.change_status', function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var status = $(this).data('status');
            var url = "{{ route('app.forms.status-change') }}"
            change_status(id,status,name,url);
        });
    </script>
@endpush
