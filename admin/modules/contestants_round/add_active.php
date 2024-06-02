<?php date_default_timezone_set('Asia/Manila');

include("../../includes/connection.php");

$active_round      = mysqli_real_escape_string($db, trim($_POST['active_round']));


$data = array();
$res_success = 0;
$res_message = "";

//DELETING ACTIVE ROUND
$query = " DELETE FROM active_round";

if (mysqli_query($db, $query)) {

    //INSERTING ACTIVE ROUND
    $query_insert = "
    INSERT INTO active_round(round_no) VALUES('$active_round')";
    if (mysqli_query($db, $query_insert)) {
        $res_success = 1;
    } else {
        $res_message = "Query Insert Failed";
    }
} else {
    $res_message = "Query Delete Failed";
}

$data['res_success'] = $res_success;
$data['res_message'] = $res_message;


echo json_encode($data);
