<?php
include("../../includes/connection.php");
extract($_POST);

$data = array();
$res_success = 0;
$res_message = "";

$query = "
DELETE FROM tbl_contestant_round
WHERE contestant_round_id = '$contestant_round_id'
";

if ($db->query($query)) {

    $query_tabulation = "
    DELETE FROM tbl_tabulations
    WHERE contestant_round_id = '$contestant_round_id'
    ";

    if ($db->query($query_tabulation)) {
        $res_success = 1;
    }else {
        $res_message = "Failed Delete Tabulation";
    }

} else {
    $res_message = "Failed Delete Contestant Round";
}

$data['res_success']  = $res_success;
$data['res_message']  = $res_message;

echo json_encode($data);
