@extends('layouts.app')
@section('title',$title)
@push('styles')
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
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header border-bottom-0 py-1">
                    <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">{{ $title }}
                        <a href="{{ route('app.forms.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-caret-left fa-sm"></i> Form List</a>
                    </h5>
                </div>
            </div>

            @if ($form->fields->isNotEmpty())
                @foreach ($form->fields as $field)
                    <div class="card mb-3 sortable-item" data-id="{{ $field->id }}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">{{ $field->label }} @if($field->required == 1)<small class="text-danger">(required)</small>@endif</label>
                                @if (in_array($field->type,['text','textarea','file','date']))
                                    @if ($field->type == 'textarea')
                                        <textarea name="" id="" rows="3" class="form-control form-control-sm" @if($field->placeholder) placeholder="{{ $field->placeholder }}" @endif></textarea>
                                    @else
                                        <input type="{{ $field->type }}" class="form-control form-control-sm" @if($field->placeholder) placeholder="{{ $field->placeholder }}" @endif>
                                    @endif
                                @endif
                                <div class="text-right mt-2">
                                    <button type="button" class="btn btn-sm btn-info">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else

            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header py-1">
                    <h5 class="card-title mb-0">Choose Field</h5>
                </div>
                <div class="card-body">
                    <ul class="m-0 p-0 field-list">
                        <li><span><i class="fa fa-sm fa-minus mr-1"></i>Text:</span> <button class="field-add-btn" type="button" data-type="text" data-name="single">Add</button></li>
                        <li><span><i class="fa fa-sm fa-bars mr-1"></i>Textarea:</span> <button class="field-add-btn" type="button" data-type="textarea" data-name="single">Add</button></li>
                        <li><span><i class="fa fa-sm fa-caret-square-o-down mr-1"></i>Dropdown:</span> <button class="field-add-btn" type="button" data-type="selectbox" data-name="multi">Add</button></li>
                        <li><span><i class="fa fa-sm fa-dot-circle-o mr-1"></i>Multiple Choice:</span> <button class="field-add-btn" type="button" data-type="radio" data-name="multi">Add</button></li>
                        <li><span><i class="fa fa-sm fa-check-square mr-1"></i>Checkbox:</span> <button class="field-add-btn" type="button" data-type="checkbox" data-name="multi">Add</button></li>
                        <li><span><i class="fa fa-sm fa-file mr-1"></i>File:</span> <button class="field-add-btn" type="button" data-type="file" data-name="single">Add</button></li>
                        <li><span><i class="fa fa-sm fa-calendar mr-1"></i>Date:</span> <button class="field-add-btn" type="button" data-type="date" data-name="single">Add</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('form.single_modal')
@endsection

@push('scripts')
    <script>
        $(document).on('click','.field-add-btn',function(){
            var field_type = $(this).data('type');
            var field_select = $(this).data('name');
            $('.form').find('.is-invalid').removeClass('is-invalid');
            $('.form').find('.error').remove();
            $('.form')[0].reset();
            if (field_select == 'single') {
                $('#field_store_or_update_modal .modal-title').text(field_type + ' Field');
                $('#field_store_or_update_form #type').val(field_type);
                $('#field_store_or_update_modal').modal({
                    keyboard: false,
                    backdrop: 'static'
                });
            }else if(field_select == 'multi'){

            }else{

            }
        });

        $(document).on('click','#field-save-btn',function(){
            var form = document.getElementById('field_store_or_update_form');
            var form_data = new FormData(form);
            var id = $('#update_id').val();
            var url = "{{ route('app.forms.fields.store') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function(){
                    $('#field-save-btn span').addClass('spinner-border spinner-border-sm text-light');
                },
                complete: function(){
                    $('#field-save-btn span').removeClass('spinner-border spinner-border-sm text-light');
                },
                success: function (data) {
                    $('#field_store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                    $('#field_store_or_update_form').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function (key, value) {
                            $('#field_store_or_update_form #' + key).addClass('is-invalid');
                            $('#field_store_or_update_form #' + key).parent().append('<span class="error d-block text-danger">' + value + '</span>');
                        });
                    } else {
                        notification(data.status, data.message);
                        if (data.status == 'success') {
                            setInterval(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    }
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        });
    </script>
@endpush
