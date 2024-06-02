<?php include "../header.php";
$criteria_desc              = mysqli_real_escape_string($db, trim($_GET['criteria_desc']));
$c_percentage               = mysqli_real_escape_string($db, trim($_GET['c_percentage']));
include "dash/special_award.php";
?>
<style>
    table {
        table-layout: auto;
        width: 100%;

    }

    td,
    th {
        text-wrap: wrap;
    }
</style>

<h5><i class="fa fa-trophy"></i> Special Awards</h5>
<hr>
<div class="card radius-10">
    <div class="card-body">
        <h6>Best in <?php echo $criteria_desc; ?> (<?php echo $c_percentage; ?>%) Based on Percentage Per Judge</h6>
        <hr>
        <div class="table-responsive">
            <table id="my_table" class="table display table-bordered bg-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" colspan="2"></th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th colspan = '2' class = 'text-center'>" . $row['full_name'] . "</th>";
                        }
                        ?>
                        <th class="text-center" colspan="2"></th>
                    </tr>

                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Contestant Name</th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th>% Score</th>";
                            echo "<th>Rank</th>";
                        }
                        ?>
                        <th class="text-center">Avg Percentage</th>
                        <th class="text-center">Final Rank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($special_awards as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['seq_no'] . "</td>";
                        echo "<td>" . $row['contestant_name'] . "</td>";
                        // Display dynamic judge percentages
                        // Display dynamic criteria scores
                        foreach ($row as $key => $value) {
                            if (strpos($key, 'judge_') !== false) {
                                if ($value !== null) {
                                    // Split the concatenated value into total percentage and rank per judge
                                    list($percentage, $rank) = explode(' ', $value);
                                    echo '<td class="text-center bg-light">' . $percentage . '</td>';
                                    echo '<td class="text-center bg-light">' . $rank . '</td>';
                                    $hasData = true; // Data exists, set flag to true
                                } else {
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center"></td>';
                                }
                            }
                        }
                        echo "<td class='text-center'>" . $row['average_percentage'] . "</td>";
                        // Apply background color based on rank
                        $rank = (int)$row['overall_rank'];
                        $bg_color = '';
                        switch ($rank) {
                            case 1:
                                $bg_color = 'bg-danger';
                                break;
                            default:
                                $bg_color = '';
                        }
                        echo "<td class='text-center overall-rank $bg_color'>" . $row['overall_rank'] . "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="card radius-10">
    <div class="card-body">
        <h6>Best in <?php echo $criteria_desc; ?> (<?php echo $c_percentage; ?>%) Based on Rank Per Judge</h6>
        <hr>
        <div class="table-responsive">
            <table id="my_table_2" class="table display table-bordered bg-light" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" colspan="2"></th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th colspan = '2' class = 'text-center'>" . $row['full_name'] . "</th>";
                        }
                        ?>
                        <th class="text-center" colspan="2"></th>
                    </tr>

                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Contestant Name</th>
                        <!-- Dynamic columns for judge percentages -->
                        <?php
                        $query = "SELECT DISTINCT tb.user_id, us.full_name FROM tbl_tabulations as tb 
                LEFT JOIN tbl_users as us ON us.user_id = tb.user_id";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<th>% Score</th>";
                            echo "<th>Rank</th>";
                        }
                        ?>
                        <th class="text-center">Avg Rank</th>
                        <th class="text-center">Final Rank</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($special_awards as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['seq_no'] . "</td>";
                        echo "<td>" . $row['contestant_name'] . "</td>";
                        // Display dynamic judge percentages
                        // Display dynamic criteria scores
                        foreach ($row as $key => $value) {
                            if (strpos($key, 'judge_') !== false) {
                                if ($value !== null) {
                                    // Split the concatenated value into total percentage and rank per judge
                                    list($percentage, $rank) = explode(' ', $value);
                                    echo '<td class="text-center bg-light">' . $percentage . '</td>';
                                    echo '<td class="text-center bg-light">' . $rank . '</td>';
                                    $hasData = true; // Data exists, set flag to true
                                } else {
                                    echo '<td class="text-center"></td>';
                                    echo '<td class="text-center"></td>';
                                }
                            }
                        }
                        echo "<td class='text-center'>" . $row['average_rank'] . "</td>";
                        // Apply background color based on rank
                        $rank = (int)$row['average_final_rank'];
                        $bg_color = '';
                        switch ($rank) {
                            case 1:
                                $bg_color = 'bg-danger';
                                break;
                            default:
                                $bg_color = '';
                        }
                        echo "<td class='text-center overall-rank $bg_color'>" . $row['average_final_rank'] . "</td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../footer.php"; ?>

<script>
    $(document).ready(function() {
        $('#my_table').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            dom: "Bfrtip",
            buttons: [{
                    extend: "csv",
                    className: "btn-sm ",
                },
                {
                    extend: "excel",
                    className: "btn-sm btn btn-success",
                },
                {
                    extend: "print",
                    className: "btn-sm btn btn-success",
                    title: '.',
                    message: function() {
                        return '<div style="position:relative;">\
                            <img src="../assets/images/loreto1.png" height="100px" width="100px" style="position: absolute;top:0;left:50px;">\
                            <img src="../assets/images/sfxc.png" height="100px" width="100px" style="position: absolute;top:0;left:150px;">\
                            <center><h4 style="margin-top:-40px;">SPECIAL AWARDS SUMMARY</h4><h6>SFXC TABULATION SYSTEM</h6></center><br><br>\
                            <center><h5>Best in <?php echo $criteria_desc; ?></h5></center>\
                        </div>';
                    },
                    customize: function(win) {


                        $(win.document.body).find('table').addClass('table-bordered'); // Add border to printed table

                        // Apply background color to the last column of each row based on row data
                        $(win.document.body).find('table tr').each(function() {
                            var rank = parseInt($(this).find('td:last-child').text().trim());
                            var bgColor = '';
                            switch (rank) {
                                case 1:
                                    bgColor = 'red';
                                    break;
                                default:
                                    bgColor = '';
                            }
                            $(this).find('td:last-child').css('background-color', bgColor);
                            $(this).find('td:last-child').css('font-weight', 'bold');
                        });

                        //Remove Body Background color
                        $(win.document.body).css('background-color', 'transparent');
                        $(win.document.body).find('table').addClass('table-bordered').css('border-color', 'green');
                    }
                }
            ]
        });


        $('#my_table_2').DataTable({
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            dom: "Bfrtip",
            buttons: [{
                    extend: "csv",
                    className: "btn-sm ",
                },
                {
                    extend: "excel",
                    className: "btn-sm btn btn-success",
                },
                {
                    extend: "print",
                    className: "btn-sm btn btn-success",
                    title: '.',
                    message: function() {
                        return '<div style="position:relative;">\
                            <img src="../assets/images/loreto1.png" height="100px" width="100px" style="position: absolute;top:0;left:50px;">\
                            <img src="../assets/images/sfxc.png" height="100px" width="100px" style="position: absolute;top:0;left:150px;">\
                            <center><h4 style="margin-top:-40px;">SPECIAL AWARDS SUMMARY</h4><h6>SFXC TABULATION SYSTEM</h6></center><br><br>\
                            <center><h5>Best in <?php echo $criteria_desc; ?></h5></center>\
                        </div>';
                    },
                    customize: function(win) {


                        $(win.document.body).find('table').addClass('table-bordered'); // Add border to printed table

                        // Apply background color to the last column of each row based on row data
                        $(win.document.body).find('table tr').each(function() {
                            var rank = parseInt($(this).find('td:last-child').text().trim());
                            var bgColor = '';
                            switch (rank) {
                                case 1:
                                    bgColor = 'red';
                                    break;
                                default:
                                    bgColor = '';
                            }
                            $(this).find('td:last-child').css('background-color', bgColor);
                            $(this).find('td:last-child').css('font-weight', 'bold');
                        });

                        //Remove Body Background color
                        $(win.document.body).css('background-color', 'transparent');
                        $(win.document.body).find('table').addClass('table-bordered').css('border-color', 'green');
                    }
                }
            ]
        });
    });
</script>