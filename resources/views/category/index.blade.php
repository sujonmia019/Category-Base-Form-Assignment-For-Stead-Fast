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
                        <button type="button" onclick="showFormModal('New Category','Save')" class="btn btn-sm btn-primary"><i class="fa fa-plus fa-sm"></i> Add Category</button>
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table w-100 table-sm table-bordered table-hover table-striped" id="category-datatable">
                        <thead>
                            <th>
                                <div class="form-checkbox">
                                    <input type="checkbox" class="form-check-input" id="select_all" onclick="select_all()">
                                    <label class="form-check-label" for="select_all"></label>
                                </div>
                            </th>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th class="text-right">Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('category.store_or_update')
@endsection

@push('scripts')
<script>
    table = $('#category-datatable').DataTable({
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
            url: "{{ route('app.categories.index') }}",
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
            {data: 'name'},
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

    $(document).on('click', '#save-btn', function(){
        var id = $('input#update_id').val();
        var form = document.getElementById('store_or_update_form');
        var formData = new FormData(form);
        var url = "{{ route('app.categories.store-or-update') }}";
        var method;
        if (id) {
            method = 'update';
        }else{
            method = 'add';
        }
        store_or_update_data(method,url,formData);
    });

    $(document).on('click','.edit_data',function(){
        let id = $(this).data('id');
        $('#store_or_update_form')[0].reset();
        $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
        $('#store_or_update_form').find('.error').remove();
        if (id) {
            $.ajax({
                url: "{{ route('app.categories.edit') }}",
                type: "POST",
                data: {id: id,_token:_token},
                dataType: "JSON",
                success: function (data) {
                    $('#store_or_update_form #update_id').val(data.data.id);
                    $('#store_or_update_form #name').val(data.data.name);
                    $('#store_or_update_form #status').val(data.data.status);
                    $('#store_or_update_modal').modal({
                        keyboard: false,
                        backdrop: 'static'
                    });
                    $('#store_or_update_modal .modal-title').html(
                        '<span>Edit - ' + data.data.name + '</span>');
                    $('#store_or_update_modal #save-btn').html('<span></span> Update');

                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }
    });

    // single delete
    $(document).on('click', '.delete_data', function () {
        let id   = $(this).data('id');
        let name = $(this).data('name');
        let row  = table.row($(this).parent('tr'));
        let url  = "{{ route('app.categories.delete') }}";
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
            let url = "{{ route('app.categories.bulk-delete') }}";
            bulk_delete(ids,url,rows);
        }
    }

    // status changes
    $(document).on('click','.change_status', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var status = $(this).data('status');
        var url = "{{ route('app.categories.status-change') }}"
        change_status(id,status,name,url);
    });
</script>
@endpush

