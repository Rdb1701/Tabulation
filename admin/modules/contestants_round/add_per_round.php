<?php date_default_timezone_set('Asia/Manila');

include("../../includes/connection.php");

$contestant      = mysqli_real_escape_string($db, trim($_POST['contestant']));
$round_no        = mysqli_real_escape_string($db, trim($_POST['round_no']));


$data = array();
$res_success = 0;
$res_message = "";

$query = "
    INSERT INTO tbl_contestant_round(
    contestant_id,
    round_no)VALUES(
    '$contestant',
    '$round_no'
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
