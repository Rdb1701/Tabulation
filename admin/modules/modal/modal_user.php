
<!--------------------------------------- ADD USER  MODAL ------------------------------------------->
<?php


$sql = "SELECT DISTINCT roles_desc, roles_id FROM tbl_users_role";
$result = mysqli_query($db, $sql) or die ("Bad SQL: $sql");

$opt1 = "<select class='form-control' name='type' id = 'add_roles' required>";
$opt1 .= "<option value='' selected hidden>Select Type</option>";
  while ($row = mysqli_fetch_assoc($result)) {
    $opt1 .= "<option value='".$row['roles_id']."'>".$row['roles_desc']."</option>";
  }

$opt1 .= "</select>";


$sql = "SELECT DISTINCT roles_desc, roles_id FROM tbl_users_role";
$result = mysqli_query($db, $sql) or die ("Bad SQL: $sql");

$opt2 = "<select class='form-control' name='type' id = 'edit_roles' required>";
$opt2 .= "<option value='' selected hidden>Select Type</option>";
  while ($row = mysqli_fetch_assoc($result)) {
    $opt2 .= "<option value='".$row['roles_id']."'>".$row['roles_desc']."</option>";
  }

$opt2 .= "</select>"

?>

<!-- //ADD USER -->
<div class="modal fade" id="list_add_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Add New User</h3>
        <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
      </div>
      <form id="form_insert">
        <div class="modal-body mx-4">
          <div class="md-form">
            <label data-error="wrong" data-success="right">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control validate" id="add_username">
          </div>
          <div class="md-form">
            <label data-error="wrong" data-success="right">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control validate" id="add_name">
          </div>
          <div class="md-form">
            <label data-error="wrong" data-success="right">Role</label>
           <?php echo $opt1; ?>
          </div>
          <div class="md-form">
            <label data-error="wrong" data-success="right">Active <span class="text-danger">*</span></label>
            <select class='form-control' id="add_active">
              <option value="" selected hidden>Select Active</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
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




<!-- EDIT USER -->
<div class="modal fade" id="list_edit_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Edit User</h3>
        <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
      </div>
      <form id="form_update">
        <div class="modal-body mx-4">
          <div class="md-form">
            <label data-error="wrong" data-success="right">Username <span class="text-danger">*</span></label>
            <input type="hidden" class="form-control validate" id="edit_user_id" >
            <input type="text" class="form-control validate" id="edit_username" disabled>
          </div>
          <div class="md-form">
            <label data-error="wrong" data-success="right">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control validate" id="edit_name">
          </div>
          <div class="md-form">
            <label data-error="wrong" data-success="right">Role</label>
           <?php echo $opt2; ?>
          </div>
          <div class="md-form">
            <label data-error="wrong" data-success="right">Active <span class="text-danger">*</span></label>
            <select class='form-control' id="edit_active">
              <option value="" selected hidden>Select Active</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
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