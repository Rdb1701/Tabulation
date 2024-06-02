<?php
include("../../includes/connection.php");
extract($_POST);

$data = array();
$res_success         = 0;
$res_message         = "";
$contestant_round_id = "";

$path = "uploads/$photo";

//GET CONTESTANT_ROUND ID
$query_round = "
SELECT contestant_round_id
FROM tbl_contestant_round
WHERE contestant_id = '$contestant_id'
";

$result = $db->query($query_round);
$numRows = $result->num_rows;
if($numRows > 0){
    $row = $result->fetch_assoc();

    $contestant_round_id = $row['contestant_round_id'];
}


//DELETE TABULATIONS
$query_delete = "
DELETE FROM tbl_tabulations
WHERE contestant_round_id = '$contestant_round_id'
";

if ($db->query($query_delete)) {

//DELETE Contestant_per_round
$query_contesant_round = "
DELETE FROM tbl_contestant_round
WHERE contestant_id = '$contestant_id'
";

if ($db->query($query_contesant_round)) {

} else {
    $res_message = "Failed Delete contestant Round";
}

}else{
    $res_message = "Failed tabulations Delete";
}



//DELETE CONTESTANTS
$query = "
DELETE FROM tbl_contestant
WHERE contestant_id = '$contestant_id'
";

if ($db->query($query)) {
    unlink($path);

    $res_success = 1;
} else {
    $res_message = "Failed Delete COntestant";
}

$data['res_success']  = $res_success;
$data['res_message']  = $res_message;

echo json_encode($data);
