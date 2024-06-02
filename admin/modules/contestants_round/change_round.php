<?php
include("../../includes/connection.php");

$round_no_select =  mysqli_real_escape_string($db, $_POST['round_no_select']);

$sql = "SELECT DISTINCT round_no FROM tbl_contestant_round";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$html = '<option value="">&nbsp;</option>';
if($round_no_select != "") {
    $html = '';
    while($row = mysqli_fetch_array($result)) {
        $html .= "<option value='".$row['round_no']."'>".$row['round_no']."</option>";
    }
}

echo $html;



?>