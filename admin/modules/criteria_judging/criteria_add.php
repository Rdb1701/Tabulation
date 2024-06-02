<?php date_default_timezone_set('Asia/Manila');

include("../../includes/connection.php");

$criteria      = mysqli_real_escape_string($db, trim($_POST['criteria']));
$criteria_desc = mysqli_real_escape_string($db, trim($_POST['criteria_desc']));
$percentage    = mysqli_real_escape_string($db, trim($_POST['percentage']));
$round         = mysqli_real_escape_string($db, trim($_POST['round']));
$active        = mysqli_real_escape_string($db, trim($_POST['active']));

$data = array();
$res_success = 0;
$res_message = "";

$query = "
    INSERT INTO tbl_criteria(criteria_desc,
    criteria_definition,
        percentage,
        max_percentage,
        round_no,
        is_active) VALUES('$criteria',
        '$criteria_desc',
        '$percentage',
        '10',
        '$round',
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
