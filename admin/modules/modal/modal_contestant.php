<!-- //ADD CRITERIA -->
<div class="modal fade" id="list_add_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Add New Candidate</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_insert">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Contestant <span class="text-danger">*</span></label>
                        <input type="text" class="form-control validate" id="add_contestant">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Sequence No. <span class="text-danger">*</span></label>
                        <input type="number" id="add_no" class="form-control">
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
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Edit Candidate</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_update">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Contestant <span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control validate" id="edit_contestant_id">
                        <input type="text" class="form-control validate" id="edit_contestant">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Sequence No. <span class="text-danger">*</span></label>
                        <input type="number" id="edit_no" class="form-control">
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




<!------------------------------------- UPLOAD PHOTO-------------------------------------------------->
<div class="modal fade" id="upload_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLabel">Upload Photo</h5>
                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="upload_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="upload_id" id="upload_id">
                        <input type="file" name="file" id="file" accept="image/*" class="form-control"><br><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>

    </div>
</div>