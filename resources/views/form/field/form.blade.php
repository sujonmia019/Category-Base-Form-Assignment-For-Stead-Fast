@extends('layouts.app')
@section('title',$title)
@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
<style>
    .field-list{
        list-style: none;
    }
    .field-list li {
        padding: 5px 10px;
        border: 1px solid #ccc;
        margin-bottom: 5px;
        border-radius: 3px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .field-list li button {
        border: 0;
        display: inline-block;
        font-weight: 400;
        background: rgb(4, 163, 255);
        color: #ffffff;
        padding: 2px 10px;
        font-size: 12px;
        border-radius: 3px;
    }
    .alert-info{
        color: #0c5460 !important;
        background-color: #d1ecf1 !important;
        border-color: #bee5eb !important;
    }
    .shadow-none:focus {
        box-shadow: none;
        outline: none;
    }
    p.optional-text {
        font-size: 12px;
        color: #787878;
    }
    .sortable-item .card:hover{
        cursor: move;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header border-bottom-0 py-2">
                    <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">{{ $title }}
                        <a href="{{ route('app.forms.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-caret-left fa-sm"></i> Form List</a>
                    </h5>
                </div>
            </div>
    
            <div class="alert alert-info"><strong>Noted:</strong> In order to create a form, you need to click on any on the question type in the presentation section (right sidebar) below. Please ensure that you fill in the appropriate field before submitting.</div>

            @if ($form->fields->isNotEmpty())
            <div class="sortable-item">
                @foreach ($form->fields as $field)
                    <div class="card mb-3" data-id="{{ $field->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="d-flex align-items-center justify-content-between"><span>{{ $field->label }} @if($field->required == 1)<small class="text-danger">(required)</small></span>@endif

                                    <button type="button" data-id="{{ $field->id }}" class="border-0 bg-transparent shadow-none text-danger px-1 delete_field">Delete</button>
                                </label>

                                @if (in_array($field->type,['text','textarea','file','date','tel','email']))
                                    @if ($field->type == 'textarea')
                                        <textarea name="" id="" rows="3" class="form-control form-control-sm" @if($field->placeholder) placeholder="{{ $field->placeholder }}" @endif></textarea>
                                    @else
                                        <input type="{{ $field->type }}" class="form-control form-control-sm" @if($field->placeholder) placeholder="{{ $field->placeholder }}" @endif>
                                    @endif
                                @endif

                                @if (in_array($field->type,['select','radio','checkbox']))
                                    @if ($field->type == 'select')
                                        <select name="" class="form-control form-control-sm" @if($field->multiple == 1) multiple="multiple" @endif>
                                            <option value="">Select {{ $field->label }}</option>
                                            @foreach (explode(',',$field->options) as $key=>$value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        @foreach (explode(',',$field->options) as $key=>$value)
                                            <div class="form-check">
                                                <input class="form-check-input" name="{{ $field->label }}" type="{{ $field->type }}" id="{{ $field->type.$key.str()->slug($field->label) }}" value="{{ $value }}">
                                                <label class="form-check-label" for="{{ $field->type.$key.str()->slug($field->label) }}">{{ $value }}</label>
                                          </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else

            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title mb-0">Choose Field</h5>
                </div>
                <div class="card-body">
                    <ul class="m-0 p-0 field-list">
                        <li><span><i class="fa fa-sm fa-minus mr-1"></i>Text:</span> <button class="field-add-btn shadow-none" type="button" data-form="text" data-type="text" data-name="single">Add</button></li>
                        <li><span><i class="fa fa-sm fa-bars mr-1"></i>Textarea:</span> <button class="field-add-btn shadow-none" type="button" data-form="field" data-type="textarea" data-name="single">Add</button></li>
                        <li><span><i class="fa fa-sm fa-caret-square-o-down mr-1"></i>Dropdown:</span> <button class="field-add-btn shadow-none" type="button" data-form="multi" data-type="select" data-name="multi">Add</button></li>
                        <li><span><i class="fa fa-sm fa-dot-circle-o mr-1"></i>Radio:</span> <button class="field-add-btn shadow-none" type="button" data-form="multi" data-type="radio" data-name="multi">Add</button></li>
                        <li><span><i class="fa fa-sm fa-check-square mr-1"></i>Checkbox:</span> <button class="field-add-btn shadow-none" type="button" data-form="multi" data-type="checkbox" data-name="multi">Add</button></li>
                        <li><span><i class="fa fa-sm fa-file mr-1"></i>File:</span> <button class="field-add-btn shadow-none" type="button" data-form="field" data-type="file" data-name="single">Add</button></li>
                        <li><span><i class="fa fa-sm fa-calendar mr-1"></i>Date:</span> <button class="field-add-btn shadow-none" type="button" data-form="field" data-type="date" data-name="single">Add</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('form.field.field_modal')
    @include('form.field.text_field_modal')
    @include('form.field.multi_field_modal')
@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script>
        // form field modal
        $(document).on('click','.field-add-btn',function(){
            var field_type   = $(this).data('type');
            var field_select = $(this).data('name');
            var form_id      = $(this).data('form');

            $('#'+form_id+'_store_or_update_form').find('.is-invalid').removeClass('is-invalid');
            $('#'+form_id+'_store_or_update_form').find('.error').remove();
            $('#'+form_id+'_store_or_update_form')[0].reset();

            $('#'+form_id+'_store_or_update_modal .modal-title').text(field_type + ' Field');
            if (form_id != 'text') {
                $('#'+form_id+'_store_or_update_form #type').val(field_type);
            }

            if (field_type != 'select') {
                $('#'+form_id+'_store_or_update_form #multiple').hide();
                $('#'+form_id+'_store_or_update_form label[for="multiple"]').hide();
            }else{
                $('#'+form_id+'_store_or_update_form #multiple').show();
                $('#'+form_id+'_store_or_update_form label[for="multiple"]').show();
            }

            $('#'+form_id+'_store_or_update_modal').modal({
                keyboard: false,
                backdrop: 'static'
            });
        });

        $(document).on('click','#save-btn',function(){
            var form_id   = $(this).data('form');
            var form      = document.getElementById(form_id+'_store_or_update_form');
            var form_data = new FormData(form);
            var id        = $('#update_id').val();
            var url       = "{{ route('app.forms.fields.store') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function(){
                    $('#'+form_id+'_store_or_update_modal #save-btn span').addClass('spinner-border spinner-border-sm text-light');
                },
                complete: function(){
                    $('#'+form_id+'_store_or_update_modal #save-btn span').removeClass('spinner-border spinner-border-sm text-light');
                },
                success: function (data) {
                    $('#'+form_id+'_store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                    $('#'+form_id+'_store_or_update_form').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function (key, value) {
                            $('#'+form_id+'_store_or_update_form #' + key).addClass('is-invalid');
                            $('#'+form_id+'_store_or_update_form #' + key).parent().append('<span class="error d-block text-danger">' + value + '</span>');
                        });
                    } else {
                        notification(data.status, data.message);
                        if (data.status == 'success') {
                            setInterval(() => {
                                window.location.reload();
                            }, 500);
                        }
                    }
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        });

        $(".sortable-item").sortable({
            update: function(event, ui) {
                var order = [];
                $('.sortable-item > .card').each(function(index, element) {
                    order.push($(element).data('id'));
                });

                $.ajax({
                    url: '{{ route("app.forms.fields.ordering") }}',
                    method: 'POST',
                    data: {
                        order: order,
                        _token: _token
                    },
                    success: function(response) {
                        notification(response.status,response.message);
                        if(response.status == 'success') {
                            setInterval(() => {
                                window.location.reload();
                            }, 500);
                        }
                    }
                });
            }
        });

        $(".sortable-item").disableSelection();

        // Delete field
        $(document).on('click','.delete_field',function(){
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to delete field?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Confirm',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('app.forms.fields.delete') }}",
                        type: "POST",
                        data: {id:id,_token:_token},
                        dataType: "JSON",
                    }).done(function (response) {
                        if (response.status == "success") {
                            Swal.fire("Deleted", response.message, "success").then(function () {
                                window.location.reload();
                            });
                        }

                        if (response.status == "error") {
                            Swal.fire('Oops...', response.message, "error");
                        }
                    }).fail(function () {
                        Swal.fire('Oops...', "Somthing went wrong with ajax!", "error");
                    });
                }
            });
        });
    </script>
@endpush
