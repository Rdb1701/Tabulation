<?php
include("../../includes/connection.php");
extract($_POST);

$data = array();
$res_success = 0;
$res_message = "";

$query = "
DELETE FROM tbl_criteria
WHERE criteria_id = '$criteria_id'
";

if ($db->query($query)) {

    $res_success = 1;

    $query_tabulation = "
    DELETE FROM tbl_tabulations
    WHERE criteria_id = '$criteria_id'
    ";
    $db->query($query_tabulation);

} else {
    $res_message = "Failed";
}

$data['res_success']  = $res_success;
$data['res_message']  = $res_message;

echo json_encode($data);
