<?php
include("../../includes/connection.php");


$criteria      = mysqli_real_escape_string($db, trim($_POST['criteria']));
$criteria_desc = mysqli_real_escape_string($db, trim($_POST['criteria_desc']));
$percentage    = mysqli_real_escape_string($db, trim($_POST['percentage']));
$round         = mysqli_real_escape_string($db, trim($_POST['round']));
$active        = mysqli_real_escape_string($db, trim($_POST['active']));
$criteria_id   = mysqli_real_escape_string($db, trim($_POST['criteria_id']));

$data = array();
$res_success = 0;
$res_message = "";

$query = "
UPDATE tbl_criteria
SET
criteria_desc       = '$criteria',
criteria_definition = '$criteria_desc',
percentage          = '$percentage',
round_no            = '$round',
is_active           = '$active'
WHERE criteria_id   = '$criteria_id'
";

if ($db->query($query)) {

    $res_success = 1;
} else {
    $res_message = "Failed";
}

$data['res_success']  = $res_success;
$data['res_message']  = $res_message;

echo json_encode($data);
