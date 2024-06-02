<?php date_default_timezone_set('Asia/Manila');

include("../../includes/connection.php");

$contestant      = mysqli_real_escape_string($db, trim($_POST['contestant']));
$sequence_no     = mysqli_real_escape_string($db, trim($_POST['sequence_no']));
$active          = mysqli_real_escape_string($db, trim($_POST['active']));
$contestant_id   = mysqli_real_escape_string($db, trim($_POST['contestant_id']));

$data = array();
$res_success = 0;
$res_message = "";

$query = "
UPDATE tbl_contestant
SET
contestant_name     = '$contestant',
seq_no              = '$sequence_no',
is_active           = '$active'
WHERE contestant_id = '$contestant_id'
";

if (mysqli_query($db, $query)) {
    $res_success = 1;
} else {
    $res_message = "Query Failed";
}

$data['res_success'] = $res_success;
$data['res_message'] = $res_message;


echo json_encode($data);
