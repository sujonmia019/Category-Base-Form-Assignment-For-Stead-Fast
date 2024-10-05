@extends('layouts.app')
@section('title',$title)
@push('styles')
<style>
    .form-group {
        margin-bottom: 15px !important;
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4>{{ $form->title }}</h4>
                    <p style="font-size: 14px;" class="mb-0">{{ $form->description }}</p>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <form method="POST" id="form-submit" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="form_id" value="{{ $form->id }}">
                        <input type="hidden" name="category_id" value="{{ $form->category_id }}">

                        @foreach ($form->fields as $key=>$field)
                            <input type="hidden" name="field[{{ $field->id }}][field_id]" value="{{ $field->id }}">

                            <div class="form-group">
                                <label class="{{ $field->required == 1 ? 'required' : '' }}">{{ $field->label }}</label>
                                <input type="hidden" name="field[{{ $field->id }}][label]" value="{{ $field->label }}">
                                @if (in_array($field->type,['text','textarea','file','date','tel','email']))
                                    @if ($field->type == 'textarea')
                                        <input type="hidden" name="field[{{ $field->id }}][type]" value="{{ $field->type }}">

                                        <textarea name="field[{{ $field->id }}][value]" rows="3" class="form-control form-control-sm" @if($field->required == 1) required @endif @if($field->placeholder) placeholder="{{ $field->placeholder }}" @endif></textarea>
                                    @else
                                        <input type="hidden" name="field[{{ $field->id }}][type]" value="{{ $field->type }}">

                                        <input type="{{ $field->type }}" name="field[{{ $field->id }}][value]" class="form-control form-control-sm" @if($field->required == 1) required @endif @if($field->placeholder) placeholder="{{ $field->placeholder }}" @endif>
                                    @endif
                                @endif

                                @if (in_array($field->type,['select','radio','checkbox']))
                                    @if ($field->type == 'select')
                                        <input type="hidden" name="field[{{ $field->id }}][type]" value="{{ $field->type }}">

                                        <select name="field[{{ $field->id }}][value][]" class="form-control form-control-sm" @if($field->required == 1) required @endif @if($field->multiple == 1) multiple="multiple" @endif>
                                            <option value="">Select {{ $field->label }}</option>
                                            @foreach (explode(',',$field->options) as $key=>$value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="hidden" name="field[{{ $field->id }}][type]" value="{{ $field->type }}">

                                        @foreach (explode(',',$field->options) as $key=>$value)
                                            <div class="form-check">
                                                @if ($field->type == 'checkbox')
                                                <input class="form-check-input" name="field[{{ $field->id }}][value][]" type="{{ $field->type }}" value="{{ $value }}">
                                                @else
                                                <input class="form-check-input" name="field[{{ $field->id }}][value]" type="{{ $field->type }}" value="{{ $value }}">
                                                @endif

                                                <label class="form-check-label">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        @endforeach

                        <div class="text-right">
                            <button type="submit" class="btn btn-sm btn-primary rounded-0" id="save-btn"><span></span> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('submit','#form-submit',function(e){
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('user.form.submit') }}",
                data: new FormData(this),
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function(){
                    $('#form-submit #save-btn > span').addClass('spinner-border spinner-border-sm text-light');
                },
                complete: function(){
                    $('#form-submit #save-btn > span').removeClass('spinner-border spinner-border-sm text-light');
                },
                success: function (data) {
                    $('#form-submit').find('.is-invalid').removeClass('is-invalid');
                    $('#form-submit').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function (key, value) {
                            $('#form-submit #' + key).addClass('is-invalid');
                            $('#form-submit #' + key).parent().append('<span class="error d-block text-danger">' + value + '</span>');
                        });
                    } else {
                        notification(data.status, data.message);
                        if (data.status == 'success') {
                            $('#form-submit')[0].reset();
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
