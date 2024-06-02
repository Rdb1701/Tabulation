<?php
include("../../includes/connection.php");

$data = array();
$round_no = "";

$sql_round = "SELECT * FROM active_round";
$result_round = $db->query($sql_round);
$numRows = $result_round->num_rows;
if ($numRows > 0) {
    $row = $result_round->fetch_assoc();

    $round_no = $row['round_no'];
}

$data['round_no']            = $round_no;

echo json_encode($data);
