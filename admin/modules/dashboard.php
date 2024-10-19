<?php
include('../header.php');
include('dash/dashboards.php');

$sql = "SELECT DISTINCT criteria_id, criteria_desc, percentage FROM tbl_criteria WHERE round_no = '$round_no'";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");
$opt1 = '';
while ($row = mysqli_fetch_assoc($result)) {
    $opt1 .= '<li><a class="dropdown-item" href="special_awards?criteria_id=' . $row['criteria_id'] . '&criteria_desc=' . $row['criteria_desc'] . '&c_percentage=' . $row['percentage'] . '" >' . $row['criteria_desc'] . '</a></li>';
}

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

<h5>DASHBOARD</h5>

<div class="row">
    <div class="col-12 col-md-12 d-flex">
        <div class="card flex-fill border-0">
            <div class="card-body py-4">
                <h6><i class="fa fa-trophy"></i> Detailed Tabulated Result</h6>
                <hr>
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <!-- BUTTONS -->
                        <div class="d-flex ">
                            <button class="btn btn-md btn-rasied btn-success btn-sm " onclick="refresh()"><i class="fa fa-list"></i> Display Tabulation Result</button>&nbsp;&nbsp;
                            <div class="dropdown">
                                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-list"></i> Command Options
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="import_previous()"><i class="fa fa-sort-amount-down"></i> Import Scores from Previous Round</a></li>
                                    <li><a class="dropdown-item" href="general_result"><i class="fa fa-list"></i> Print General Tabulated Result</a></li>
                            </div>&nbsp;&nbsp;
                            <div class="dropdown">
                                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-trophy"></i> Special Awards
                                </button>
                                <ul class="dropdown-menu">
                                    <?php echo $opt1; ?>
                            </div>
                        </div>
                        <!--END BUTTONS -->
                        <div class="card radius-10">
                            <div class="card-body">
                                <div class="table-responsive">

                                    <?php
                                    if ($dashboard) {

                                        $judges = array();
                                        foreach ($dashboard as $row) {
                                            $judgeId = $row['full_name'];
                                            if (!isset($judges[$judgeId])) {
                                                $judges[$judgeId] = array();
                                            }
                                            $judges[$judgeId][] = $row;
                                        }

                                        foreach ($judges as $judgeId => $judgeRows) {
                                            echo '<table class="table table-bordered table-secondary my_table">';
                                            echo '<thead class="fw-bold">';
                                            echo '<tr>';
                                            echo '<th colspan="' . (count($judgeRows[0]) - 1) . '" class="text-left bg-light"><h5 class="fw-bold">' . $judgeId . '</h5></th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                            echo '<th class="text-center">No.</th>';
                                            echo '<th class="text-center">Contestant Name</th>';
                                            // Add headers for dynamic criteria scores
                                            foreach ($judgeRows[0] as $key => $value) {
                                                if (strpos($key, 'criteria_') !== false) {
                                                    echo '<th class="text-center">' . str_replace(array('criteria_', '_score'), '', $key . '%') . '</th>';
                                                }
                                            }
                                            echo '<th class="text-center">Total Score</th>';
                                            echo '<th class="text-center">Total Percentage</th>';
                                            echo '<th class="text-center">Rank</th>';
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            $hasData = false; // Flag to check if there is any data
                                            foreach ($judgeRows as $row) {
                                                echo '<tr>';
                                                echo '<td class="text-center">' . $row['seq_no'] . '</td>';
                                                echo '<td class="text-left">' . $row['contestant_name'] . '</td>';
                                                // Display dynamic criteria scores
                                                foreach ($row as $key => $value) {
                                                    if (strpos($key, 'criteria_') !== false) {
                                                        if ($value !== null) {
                                                            echo '<td class="text-center bg-warning">' . $value . '</td>';
                                                            $hasData = true; // Data exists, set flag to true
                                                        } else {
                                                            echo '<td class="text-center">' . $value . '</td>';
                                                        }
                                                    }
                                                }
                                                // Color the total score and total percentage
                                                echo '<td class="text-center ' . ($row['total_score'] !== null && $row['total_score'] !== "" ? 'bg-warning' : '') . '">' . $row['total_score'] . '</td>';
                                                echo '<td class="text-center ' . ($row['total_percentage'] !== null && $row['total_percentage'] !== "" ? 'bg-warning' : '') . '">' . $row['total_percentage'] . '</td>';
                                                // Color the rank column
                                                switch ($row['rank_per_judge']) {
                                                    case 1:
                                                        echo '<td class="text-center bg-danger">' . $row['rank_per_judge'] . '</td>';
                                                        break;
                                                    case 2:
                                                        echo '<td class="text-center bg-secondary">' . $row['rank_per_judge'] . '</td>';
                                                        break;
                                                    case 3:
                                                        echo '<td class="text-center bg-success">' . $row['rank_per_judge'] . '</td>';
                                                        break;
                                                    case 4:
                                                        echo '<td class="text-center bg-primary">' . $row['rank_per_judge'] . '</td>';
                                                        break;
                                                    case 5:
                                                        echo '<td class="text-center bg-info">' . $row['rank_per_judge'] . '</td>';
                                                        break;
                                                    default:
                                                        echo '<td class="text-center">' . $row['rank_per_judge'] . '</td>';
                                                }
                                                echo '</tr>';
                                            }

                                            echo '</tbody>';
                                            echo '</table>';
                                        }
                                    } else {
                                    ?>
                                        <h2 class="text-center">On Going Tabulation...</h2>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('../footer.php');
    include "modal/modal_dashboard.php";
    ?>

    <script>
        function refresh() {
            window.location.reload();

        }

        function import_previous() {
            $('#list_add_previous_modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#list_add_previous_modal').modal('show')
        }


        $(document).ready(function() {
            //-------------------------------------------- ADD PER ROUND ---------------------------------------//
            $('#form_prev_round').on('submit', function(e) {
                e.preventDefault();

                let prev_round       = $('#prev_round').val();
                let curr_criteria    = $('#curr_criteria').val();
                let contestant_curr  = $('#contestant_curr').val();
 
                $.ajax({
                    url: 'dash/import_score_prev',
                    type: 'POST',
                    data: {
                        prev_round: prev_round,
                        curr_criteria: curr_criteria,
                        contestant_curr: contestant_curr
                    },
                    dataType: 'JSON',
                    beforeSend: function() {

                    }
                }).done(function(res) {
                    if (res.res_success == 1) {
                        swal('Successfully Imported Previous Scores','','success');

                    } else {
                        swal(`${res.res_message}`, '', 'error');
                    }

                }).fail(function() {
                    console.log('fail')
                })
            })


        //     var table = $('.my_table').DataTable({
        //         "ordering": false,
        //         "searching": false,
        //         "paging": false,
        //         "info": false,
        //         dom: "Bfrtip",
        //         buttons: [
        //             {
        //                 extend: "print",
        //                 className: "btn-sm btn btn-success",
        //                 title: '.',
        //                 message: function() {
        //             return '<div style="position:relative;">\
        //                 <img src="../assets/images/rosario.jpeg" height="100px" width="100px" style="position: absolute;top:0;left:50px;">\
        //                 <img src="../assets/images/sfxc.png" height="100px" width="100px" style="position: absolute;top:0;left:150px;">\
        //                 <center><h4 style="margin-top:-40px;">DETAILED TABULATED SUMMARY</h4><h6>SFXC TABULATION SYSTEM</h6></center><br><br>\
        //             </div>';
        //         },
        //         customize: function(win) {
        //             // Add a print-specific style to remove body background color
        //             $(win.document.body).find('style').append('body { background-color: white !important; }');

        //             $(win.document.body).find('table').addClass('table-bordered'); // Add border to printed table

        //             // Apply background color to the last column of each row based on row data
        //             $(win.document.body).find('table tr').each(function() {
        //                 var rank = parseInt($(this).find('td:last-child').text().trim());
        //                 var bgColor = '';
        //                 switch (rank) {
        //                     case 1:
        //                         bgColor = 'red';
        //                         break;
        //                     case 2:
        //                         bgColor = 'yellow';
        //                         break;
        //                     case 3:
        //                         bgColor = 'lightgreen';
        //                         break;
        //                     case 4:
        //                         bgColor = 'skyblue';
        //                         break;
        //                     case 5:
        //                         bgColor = 'gray';
        //                         break;
        //                     default:
        //                         bgColor = '';
        //                 }
        //                 $(this).find('td:last-child').css('background-color', bgColor);
        //                 $(this).find('td:last-child').css('font-weight', 'bold');
        //             });
        //         }
        //             }
        //         ]

        //     });
        })
    </script>