<?php

$criteria_id              = mysqli_real_escape_string($db, trim($_GET['criteria_id']));
$special_awards           = array();
$data                     = array();

$round_no = "";

$sql_round = "SELECT * FROM active_round";
$result_round = $db->query($sql_round);
$numRows = $result_round->num_rows;
if ($numRows > 0) {
    $row = $result_round->fetch_assoc();

    $round_no = $row['round_no'];
}

try {

    $query = "
  
    SET SESSION group_concat_max_len = 1000000;

    SELECT
        GROUP_CONCAT(DISTINCT
        CONCAT(
            'MAX(CASE WHEN user_id = ',
            user_id,
            ' THEN CONCAT(total_percentage, '' '', rank_per_judge) END) AS judge_',
            REPLACE(full_name, ' ', '_')
        )
        ) INTO @sql
    FROM
        (SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
         LEFT JOIN tbl_users as us ON us.user_id = tb.user_id) judges;
    
    SET @sql = CONCAT('
        WITH TotalPercentages AS (
            SELECT
                c.contestant_id,
                c.contestant_name,
                c.seq_no,
                tb.user_id AS user_id,
                us.username,
                SUM(ROUND(tb.score / 10 * crt.percentage, 2)) AS total_percentage,
                RANK() OVER (PARTITION BY tb.user_id ORDER BY total_percentage DESC) AS rank_per_judge
            FROM
                tbl_tabulations AS tb
                LEFT JOIN tbl_contestant_round AS cr ON cr.contestant_round_id = tb.contestant_round_id
                LEFT JOIN tbl_contestant AS c ON c.contestant_id = cr.contestant_id
                LEFT JOIN tbl_criteria AS crt ON crt.criteria_id = tb.criteria_id
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id
            WHERE
                tb.criteria_id = $criteria_id
            AND crt.round_no   = $round_no
            GROUP BY
                c.contestant_id,
                c.contestant_name,
                c.seq_no,
                tb.user_id
        )
        SELECT
            contestant_id,
            contestant_name,
            seq_no,
            ', @sql, ',
            ROUND(AVG(total_percentage),2) AS average_percentage,
            RANK() OVER (ORDER BY average_percentage DESC) AS overall_rank,
            ROUND(AVG(rank_per_judge),2) AS average_rank,
            RANK() OVER (ORDER BY AVG(rank_per_judge) ASC) AS average_final_rank
        FROM
            TotalPercentages
        GROUP BY
            contestant_id,
            contestant_name,
            seq_no
    ');
    
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    ";

    if ($db->multi_query($query)) {
        do {
            if ($result = mysqli_store_result($db)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $temp_arr = array();
              

                    $temp_arr['contestant_name']    = $row['contestant_name'];
                    $temp_arr['seq_no']             = $row['seq_no'];
                    $temp_arr['average_percentage'] = $row['average_percentage'];
                    $temp_arr['overall_rank']       = $row['overall_rank'];
                    $temp_arr['average_rank']       = $row['average_rank'];
                    $temp_arr['average_final_rank'] = $row['average_final_rank'];
                    // Loop through the dynamic per judge percentage
                    foreach ($row as $key => $value) {
                        if (strpos($key, 'judge_') !== false) {
                            $temp_arr[$key] = $value;
                        }
                    }

                    $special_awards[] = $temp_arr;
                }
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($db));
    } else {
        echo "<h3 class='text-center fw-bold'>No Tabulation Yet</h3>";
    }
} catch (mysqli_sql_exception $e) {
    // Handle the exception
    echo "<script>console.log(" . json_encode($e->getMessage()) . ");</script>";
    echo "<script>alert('The active round you set has no round in the criterias')</script>";
}
?>
