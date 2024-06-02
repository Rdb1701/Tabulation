<?php
$contestant = array();
$round_no = "";

$sql_round = "SELECT * FROM active_round";
$result_round = $db->query($sql_round);
$numRows = $result_round->num_rows;
if ($numRows > 0) {
    $row = $result_round->fetch_assoc();

    $round_no = $row['round_no'];
}

$query_sidebar = "
  SELECT DISTINCT c.contestant_name, c.photo, cr.contestant_round_id
  FROM tbl_tabulations as tb
  LEFT JOIN tbl_contestant_round as cr ON cr.contestant_round_id = tb.contestant_round_id
  LEFT JOIN tbl_contestant as c ON c.contestant_id = cr.contestant_id
  WHERE cr.round_no = '$round_no'
  AND tb.user_id = '".$_SESSION['judge']['user_id']."'
";

$result_sidebar = mysqli_query($db, $query_sidebar);
if (mysqli_num_rows($result_sidebar) > 0) {
    while ($row = mysqli_fetch_assoc($result_sidebar)) {
        $temp_arr = array();

        $temp_arr['contestant_name']     = $row['contestant_name'];
        $temp_arr['photo']               = $row['photo'];
        $temp_arr['contestant_round_id'] = $row['contestant_round_id'];


        $contestant[] = $temp_arr;
    }
}

?>