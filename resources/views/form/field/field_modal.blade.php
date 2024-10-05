<div class="modal fade" id="field_store_or_update_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-1">
            <div class="modal-header py-1">
                <h5 class="modal-title text-capitalize" id="modal-title"></h5>
                <button type="button" class="close p-1" data-dismiss="modal">&times;</button>
            </div>   
            <div class="modal-body">
                <form id="field_store_or_update_form" class="form" method="POST">
                    @csrf
                    <input type="hidden" id="form_id" name="form_id" value="{{ $form->id }}">
                    <input type="hidden" id="update_id" name="update_id">
                    <input type="hidden" id="form_name" name="form_name" value="field">
                    <input type="hidden" name="type" id="type">
                    <x-input labelName="Title" required="required" name="label"/>
                    <x-input labelName="Placeholder" name="placeholder"/>
                    <div class="form-check">
                        <input type="checkbox" value="1" name="required" class="form-check-input" id="required">
                        <label class="form-check-label" for="required">Is Required?</label>
                    </div>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn" data-form="field"><span></span> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
