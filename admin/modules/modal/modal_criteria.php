<!-- //ADD CRITERIA -->
<div class="modal fade" id="list_add_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Add New Criteria</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_insert">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Citeria <span class="text-danger">*</span></label>
                        <input type="text" class="form-control validate" id="add_criteria">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Description <span class="text-danger">*</span></label>
                        <textarea name="" id="add_desc" cols="4" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Percentage Criteria</label>
                        <input type="number" class="form-control validate" id="add_percentage">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Valid Round</label>
                        <input type="number" class="form-control validate" id="add_round">
                    </div>

                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Active</label>
                        <select class="form-control" name="" id="add_active">
                            <option value="" selected hidden>Select Active</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-block z-depth-1a" id="btn_add">SUBMIT</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>




<!-- //EDIT CRITERIA -->
<div class="modal fade" id="list_edit_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Edit Criteria</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_update">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Citeria <span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control validate" id="criteria_id">
                        <input type="text" class="form-control validate" id="edit_criteria">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Description <span class="text-danger">*</span></label>
                        <textarea name="" id="edit_desc" cols="4" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Percentage Criteria</label>
                        <input type="number" class="form-control validate" id="edit_percentage">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Valid Round</label>
                        <input type="number" class="form-control validate" id="edit_round">
                    </div>

                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Active</label>
                        <select class="form-control" name="" id="edit_active">
                            <option value="" selected hidden>Select Active</option>
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-block z-depth-1a" id="btn_add">SUBMIT</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>