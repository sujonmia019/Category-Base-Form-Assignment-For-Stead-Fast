<div class="modal fade" id="multi_store_or_update_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-1">
            <div class="modal-header py-1">
                <h5 class="modal-title text-capitalize" id="modal-title"></h5>
                <button type="button" class="close p-1" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="multi_store_or_update_form" class="form" method="POST">
                    @csrf
                    <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">
                    <input type="hidden" id="update_id" name="update_id">
                    <input type="hidden" id="type" name="type">
                    <input type="hidden" id="form_name" name="form_name" value="multi">
                    <x-input labelName="Title" required="required" name="label"/>

                    <x-select labelName="Is Multipe" name="multiple" required="required">
                        <option value="1">No</option>
                        <option value="2">yes</option>
                    </x-select>
                    <x-textarea name="options" required="required" labelName="Options" optional="Option Separated By Comma(,) without space"></x-textarea>
                    <div class="form-check">
                        <input type="checkbox" value="1" name="required" class="form-check-input" id="required">
                        <label class="form-check-label" for="required">Is Required?</label>
                    </div>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn" data-form="multi"><span></span> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
