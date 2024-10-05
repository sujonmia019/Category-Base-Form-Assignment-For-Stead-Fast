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
    .disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="card-title mb-0 d-flex align-items-center justify-content-between">{{ $title }}
                        <a href="{{ route('app.forms.index') }}" class="btn btn-sm btn-danger"><i class="fa fa-caret-left fa-sm"></i> Form List</a>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" id="store_or_update_form">
                        @csrf
                        <input type="hidden" id="update_id" name="update_id" value="{{ $form->id ?? '' }}">
                        <x-select required="required" name="category_id" labelName="Category">
                            <option value="">Select Category</option>
                            @foreach ($categories as $key=>$value)
                            <option value="{{ $key }}" @isset($form) {{ $form->category_id == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
                            @endforeach
                        </x-select>
                        <x-input required="required" name="title" labelName="Title" placeholder="Enter Title" value="{{ $form->title }}"/>
                        <x-textarea required="required" name="description" rows="4" labelName="Description" placeholder="Enter Description" value="{{ $form->description }}"></x-textarea>
                        <x-select required="required" name="status" labelName="Status">
                            @foreach (STATUS as $key=>$value)
                            <option value="{{ $key }}" @isset($form) {{ $form->status == $key ? 'selected' : '' }} @endisset>{{ $value }}</option>
                            @endforeach
                        </x-select>
                    </form>

                    <div class="text-right mt-2">
                        <button type="button" class="btn btn-sm rounded-0 btn-success shadow-none" id="save-btn"><span></span>
                            @isset($form)
                                Update
                            @else
                                Save
                            @endisset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header py-1">
                    <h5 class="card-title mb-0">Choose Field</h5>
                </div>
                <div class="card-body">
                    <ul class="m-0 p-0 field-list disabled">
                        <li><span><i class="fa fa-sm fa-minus mr-1"></i>Text:</span></li>
                        <li><span><i class="fa fa-sm fa-bars mr-1"></i>Textarea:</span></li>
                        <li><span><i class="fa fa-sm fa-caret-square-o-down mr-1"></i>Dropdown:</span></li>
                        <li><span><i class="fa fa-sm fa-dot-circle-o mr-1"></i>Multiple Choice:</span></li>
                        <li><span><i class="fa fa-sm fa-check-square mr-1"></i>Checkbox:</span></li>
                        <li><span><i class="fa fa-sm fa-file mr-1"></i>File:</span></li>
                        <li><span><i class="fa fa-sm fa-calendar mr-1"></i>Date:</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Form Create
        $(document).on('click','#save-btn',function(){
            var form = document.getElementById('store_or_update_form');
            var form_data = new FormData(form);
            var id = $('#update_id').val();
            var url = "{{ route('app.forms.store-or-update') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function(){
                    $('#save-btn span').addClass('spinner-border spinner-border-sm text-light');
                },
                complete: function(){
                    $('#save-btn span').removeClass('spinner-border spinner-border-sm text-light');
                },
                success: function (data) {
                    $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                    $('#store_or_update_form').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function (key, value) {
                            $('#store_or_update_form #' + key).addClass('is-invalid');
                            $('#store_or_update_form #' + key).parent().append('<span class="error d-block text-danger">' + value + '</span>');
                        });
                    } else {
                        notification(data.status, data.message);
                        if (data.status == 'success') {
                            setInterval(() => {
                                window.location.href = data.redirect;
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
