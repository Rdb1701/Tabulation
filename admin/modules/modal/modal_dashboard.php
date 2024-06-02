
<?php
//SELECT CURUENT CRITERIAS
$sql_criteria = "SELECT DISTINCT criteria_id, criteria_desc FROM tbl_criteria WHERE round_no = '$round_no'";
$result_criteria = mysqli_query($db, $sql_criteria) or die("Bad SQL: $sql_criteria");

$opt2 = "<select class='form-control' name='type' id = 'curr_criteria' required>";
$opt2 .= "<option value='' selected hidden>Select Criteria</option>";
while ($row = mysqli_fetch_assoc($result_criteria)) {
    $opt2 .= "<option value='" . $row['criteria_id'] . "'>" . $row['criteria_desc'] . "</option>";
}
$opt2 .= "</select>";

//SELECT ROUND
$sql_previous = "SELECT DISTINCT round_no FROM tbl_criteria WHERE round_no < '$round_no'";
$result_previous = mysqli_query($db, $sql_previous) or die("Bad SQL: $sql_previous");

$opt3 = "<select class='form-control' name='type' id = 'prev_round' required>";
$opt3 .= "<option value='' selected hidden>Select Previous Round</option>";
while ($row = mysqli_fetch_assoc($result_previous)) {
    $opt3 .= "<option value='" . $row['round_no'] . "'>Round " . $row['round_no'] . "</option>";
}
$opt3 .= "</select>";

//SELECT CONTESTANTS
$sql_contestant = "SELECT DISTINCT tb.contestant_round_id, c.contestant_name FROM tbl_tabulations as tb 
INNER JOIN tbl_contestant_round as cr ON cr.contestant_round_id = tb.contestant_round_id
INNER JOIN tbl_contestant as c ON c.contestant_id = cr.contestant_id
WHERE cr.round_no = '$round_no'";

$result_contestant = mysqli_query($db, $sql_contestant) or die("Bad SQL: $sql_contestant");

$opt_candidate = "<select class='form-control' name='type' id = 'contestant_curr' required>";
$opt_candidate .= "<option value='' selected hidden>Select Constestant</option>";
while ($row = mysqli_fetch_assoc($result_contestant)) {
    $opt_candidate .= "<option value='" . $row['contestant_round_id'] . "'>" . $row['contestant_name'] . "</option>";
}
$opt_candidate .= "</select>";

?>


<!-- //Add score from previous Round -->
<div class="modal fade" id="list_add_previous_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold">Scores from Previous Round</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-lable="close">&times;</button>
            </div>
            <form id="form_prev_round">
                <div class="modal-body mx-4">
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Previous Round<span class="text-danger">*</span></label>
                        <?php echo $opt3; ?>
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Current Criteria<span class="text-danger">*</span></label>
                        <?php echo $opt2; ?>
                    </div>
                    <div class="md-form">
                        <label data-error="wrong" data-success="right">Contestant<span class="text-danger">*</span></label>
                        <?php echo $opt_candidate; ?>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-block z-depth-1a">Import Total Score</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>