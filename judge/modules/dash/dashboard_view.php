<?php
include("../../includes/connection.php");

$display                  = array();
$data                     = array();
$photo                    = "";
$contestant_round_id      = mysqli_real_escape_string($db, trim($_POST['contestant_round_id']));

$round_no = "";

$sql_round = "SELECT * FROM active_round";
$result_round = $db->query($sql_round);
$numRows = $result_round->num_rows;
if ($numRows > 0) {
    $row = $result_round->fetch_assoc();

    $round_no = $row['round_no'];
}

$query = "
    SELECT ct.photo, tb.score, c.criteria_desc, ROUND(tb.score / 10 * c.percentage, 2) AS total_per_criteria,
     tb.tabulation_id, c.percentage, ct.contestant_name, c.criteria_definition
    FROM tbl_tabulations as tb 
    LEFT JOIN tbl_contestant_round as cr ON cr.contestant_round_id = tb.contestant_round_id
    LEFT JOIN tbl_contestant as ct ON ct.contestant_id = cr.contestant_id
    LEFT JOIN tbl_criteria as c ON c.criteria_id = tb.criteria_id
    WHERE tb.contestant_round_id = '$contestant_round_id'
    AND tb.user_id = '" . $_SESSION['judge']['user_id'] . "'
    AND cr.round_no = '$round_no'
    AND c.is_active = 1
    ORDER BY c.criteria_id ASC
";

$result = mysqli_query($db, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $temp_arr = array();

        $photo                           = $row['photo'];
        $temp_arr['score']               = $row['score'];
        $temp_arr['criteria_desc']       = $row['criteria_desc'];
        $temp_arr['criteria_definition'] = $row['criteria_definition'];
        $temp_arr['contestant_name']     = $row['contestant_name'];
        $temp_arr['percentage']          = $row['percentage'];
        $temp_arr['total_per_criteria']  = $row['total_per_criteria'];
        $temp_arr['tabulation_id']       = $row['tabulation_id'];


        $display[] = $temp_arr;
    }
}

foreach ($display as $key => $value) {
    $img = ''; // Initialize an empty string for the image
    if ($key == 0) { // Change '2' to the specific row number where you want the image
        $img = '<img src="../../admin/modules/contestants/uploads/'.$photo.'" alt="No Photo" width="100%">';
    }

    //Total Percent 
    $total_percent = "";
    if($value['total_per_criteria'] == ''){
        $total_percent = "";
    }else{
        $total_percent = $value['total_per_criteria'].'%';
    }

    //input Score
    $input_score = '<input type="number" value = "'.$value['score'].'" name="" class="add_score text-center" onblur="score_put(this, '.$value['tabulation_id'].')" style="width:200px;height:70px;" maxlength="5.0" step="0.01"
    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">';

    $contestant_name = "<h5 class='text-center fw-bold'>".$value['contestant_name']."</h5>";
    $criteria_definition = "<h6>".$value['criteria_definition']."</h6>";

    $data['data'][] = array($img.$contestant_name,$value['criteria_desc'].'('.$value['percentage'].'%)'.$criteria_definition, $input_score, $total_percent);
}


echo json_encode($data);
