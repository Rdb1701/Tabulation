<?php date_default_timezone_set('Asia/Manila');

include("../../includes/connection.php");

$contestant      = mysqli_real_escape_string($db, trim($_POST['contestant']));
$sequence_no     = mysqli_real_escape_string($db, trim($_POST['sequence_no']));
$active          = mysqli_real_escape_string($db, trim($_POST['active']));

$data = array();
$res_success = 0;
$res_message = "";

$query = "
    INSERT INTO tbl_contestant(contestant_name,
    seq_no,
    is_active)VALUES(
    '$contestant',
    '$sequence_no',
    '$active'
    )
    ";

if (mysqli_query($db, $query)) {
    $res_success = 1;
} else {
    $res_message = "Query Failed";
}

$data['res_success'] = $res_success;
$data['res_message'] = $res_message;


echo json_encode($data);
