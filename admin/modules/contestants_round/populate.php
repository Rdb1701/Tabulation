<?php
include("../../includes/connection.php");
extract($_POST);

$data = array();
$res_success = 0;
$res_message = "";

$contestant_round_id = array();
$users               = array();
$criteria_id         = array();

//GET CONTESTNAT ROUND ID PER ROUND
$query_contestant_round = "SELECT contestant_round_id FROM tbl_contestant_round WHERE round_no = '$round_no'";

$result_contestant = mysqli_query($db, $query_contestant_round);
if (mysqli_num_rows($result_contestant) > 0) {
    while ($row = mysqli_fetch_assoc($result_contestant)) {
        $temp_arr = array();
        $temp_arr['contestant_round_id'] = $row['contestant_round_id'];


        $contestant_round_id[] = $temp_arr;
    }
}else{
    $res_message = "Cannot Populate, No Registered Constestant in that Round.";
}

//GET USERS

$query_users = "SELECT user_id FROM tbl_users WHERE active = 1 AND roles_id = 3";

$result_users = mysqli_query($db, $query_users);
if (mysqli_num_rows($result_users) > 0) {

    while ($row = mysqli_fetch_assoc($result_users)) {
        $temp_arr = array();
        $temp_arr['user_id'] = $row['user_id'];



        $users[] = $temp_arr;
    }
}


//GET Criteria
$query_criteria = "SELECT criteria_id FROM tbl_criteria WHERE round_no = '$round_no'";
$result_criteria = mysqli_query($db, $query_criteria);
if (mysqli_num_rows($result_criteria) > 0) {

    while ($row = mysqli_fetch_assoc($result_criteria)) {
        $temp_arr = array();
        $temp_arr['criteria_id'] = $row['criteria_id'];

        $criteria_id[] = $temp_arr;
    }
}


// Insert into tabulations for each combination of contestant_round_id, user_id, and criteria_id
foreach ($contestant_round_id as $key => $value) {
    foreach ($users as $keys => $values) {
        foreach ($criteria_id as $keyss => $valuess) {
            //CHECK IF ALREADY POPULATED
            $query_if_exists = "
            SELECT * FROM tbl_tabulations
            WHERE contestant_round_id = '" . $value['contestant_round_id'] . "'
            AND user_id = '" . $values['user_id'] . "'
            AND criteria_id = '" . $valuess['criteria_id'] . "'
            ";

            $result_exists = mysqli_query($db, $query_if_exists);
            // IF NOT POPULATE DATA
            if (!mysqli_num_rows($result_exists)) {

                $query_insert = "INSERT INTO tbl_tabulations (contestant_round_id, user_id, criteria_id) 
                VALUES ('" . $value['contestant_round_id'] . "', '" . $values['user_id'] . "', '" . $valuess['criteria_id'] . "')";

                if (mysqli_query($db, $query_insert)) {
                    $res_success = 1;
                } else {
                    $res_message = "Cannot Insert Data";
                }
            } else {
                $res_message = "Already Populated";
            }
        }
    }
}


$data['res_success'] = $res_success;
$data['res_message'] = $res_message;


echo json_encode($data);
?>