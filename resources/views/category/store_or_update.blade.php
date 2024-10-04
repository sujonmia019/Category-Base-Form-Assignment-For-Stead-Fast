<div class="modal fade" id="store_or_update_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-1">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close p-1" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="store_or_update_form" method="POST">
                    @csrf
                    <input type="hidden" id="update_id" name="update_id">
                    <x-input labelName="Name" name="name" placeholder="Enter name"/>
                    <x-select labelName="Status" name="status" required="required">
                        @foreach (STATUS as $key=>$value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-select>
                </form>
                <div class="text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
                </div>
            </div>
        </div>
    </div>
</div>
