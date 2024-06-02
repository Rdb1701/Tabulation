<!-- //ADD CRITERIA -->
<div class="modal fade" id="list_active_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Set Active Round</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_active">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Active Round <span class="text-danger">*</span></label>
                        <input type="number" class="form-control validate" id="add_active_round">
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-block z-depth-1a" >SUBMIT</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>


<?php

$sql = "SELECT DISTINCT contestant_id, contestant_name FROM tbl_contestant WHERE is_active = 1";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$opt1 = "<select class='form-control' name='type' id = 'add_contestant' required>";
$opt1 .= "<option value='' selected hidden>Select Contestant</option>";
while ($row = mysqli_fetch_assoc($result)) {
    $opt1 .= "<option value='" . $row['contestant_id'] . "'>" . $row['contestant_name'] . "</option>";
}
$opt1 .= "</select>";

?>


<!-- //Add Costestant per ROund -->
<div class="modal fade" id="list_contestant_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Contestant Per Round</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_per_round">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Round No. <span class="text-danger">*</span></label>
                        <input type="number" class="form-control validate" id="per_active_round">
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Contestants<span class="text-danger">*</span></label>
                        <?php echo $opt1; ?>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-block z-depth-1a">Add Contestant to this Round</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>


<!-- //POPULATE-->
<div class="modal fade" id="list_populate_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Populate Criteria Per Judge</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_populate">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Round No.<span class="text-danger">*</span></label>
                        <input type="number" class="form-control validate" id="populate_c">
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-block z-depth-1a" >Populate Criteria Per Judge</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>
