<?php include "../header.php"; ?>
<?php

$sql = "SELECT DISTINCT round_no FROM tbl_criteria";
$result = mysqli_query($db, $sql) or die("Bad SQL: $sql");

$opt1 = "<select class='' name='type' id = 'round_no_select' required style='width: 170px;'>";
$opt1 .= "<option value='' selected hidden>Select Round</option>";
while ($row = mysqli_fetch_assoc($result)) {
    $opt1 .= "<option value='" . $row['round_no'] . "'>Round " . $row['round_no'] . "</option>";
}
$opt1 .= "</select>";

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

    thead {
        position: sticky;
        top: 0;
        z-index: 100;
    }
</style>

<h5>Contestant Per Round</h5><br>
<div class="d-flex">
    <?php echo $opt1; ?>
    &nbsp;&nbsp;

    <div class="dropdown">
        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-list"></i> Command Options
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" onclick="contestant_per_round()"><i class="fa fa-plus-circle"></i> New Contestant Per Round</a></li>
            <li><a class="dropdown-item" href="#" onclick="set_active_round()"><i class="fa fa-check"></i> Set Active Round</a></li>
            <li><a class="dropdown-item" href="#" onclick="populate()"><i class="fa fa-folder"></i> Populate Tabulation Criteria Per Judge</a></li>
        </ul>
    </div>
</div><br>

<div class="card radius-10">
    <div class="card-body">
        <div class="table-responsive table-wrapper">
            <table class="table table-bordered table-hover" id="myTable">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 20px;">No.</th>
                        <th class="text-center" style="width: 200px;">Photo.</th>
                        <th class="text-center">Contestant</th>
                        <th class="text-center">Round No</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody style="overflow: auto;">

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include "../footer.php"; ?>
<?php include "modal/modal_active.php"; ?>

<script>
    function set_active_round() {
        $.ajax({
            url: 'contestants_round/active_view',
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {

            }
        }).done(function(res) {

            $("#add_active_round").val(res.round_no);
            $('#list_active_modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#list_active_modal').modal('show')

        })
    }

    function contestant_per_round() {

        $.ajax({
            url: 'contestants_round/active_view',
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {

            }
        }).done(function(res) {

            $("#per_active_round").val(res.round_no);
            $('#list_contestant_modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#list_contestant_modal').modal('show');

        })
    }


    function delete_contestant_round(contestant_round_id) {
        if (confirm("Are you sure you want to delete Contestant?")) {
            $.ajax({
                url: 'contestants_round/contestant_delete',
                type: 'POST',
                data: {
                    contestant_round_id: contestant_round_id

                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    $('#' + contestant_round_id).fadeOut('slow');
                    swal('Successfully Deleted', '', 'success');
                } else {
                    alert(res.res_message);
                }
            }).fail(function() {
                console.log("FAIL");
            })
        }
    }

    function populate() {
        if (confirm("Are you sure you want to populate criteria per judge??")) {
            $.ajax({
                url: 'contestants_round/active_view',
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {

                $("#populate_c").val(res.round_no);
                $('#list_populate_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                })
                $('#list_populate_modal').modal('show');

            })
        }
    }


    $(document).ready(function() {

        // Initialize DataTable
        var table = $('#myTable').DataTable({
            ajax: 'contestants_round/contestant_view', // API endpoint to fetch data
            "ordering": false,
            searching: false,
            paging: false,
            columns: [{
                    data: [0],
                    "className": "text-center"
                },
                {
                    data: [1],
                    "className": "text-center"
                },
                {
                    data: [2],
                    "className": "text-center"
                },
                {
                    data: [3],
                    "className": "text-center"
                },
                {
                    data: [4],
                    "className": "text-center"
                },
                {
                    data: null,
                    visible: false
                } // Hidden column for contestant_round_id
            ],
            "rowCallback": function(row, data) {
                $(row).attr('id', data[5]); // Use data[4] for contestant_round_id
            }
        });

        //-------------------------------------------- ADD ---------------------------------------//
        $('#form_active').on('submit', function(e) {
            e.preventDefault();

            let active_round = $('#add_active_round').val();


            $.ajax({
                url: 'contestants_round/add_active',
                type: 'POST',
                data: {
                    active_round: active_round
                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Set an Active Round', '', 'success');
                    // var currentPageIndex = table.page.info().page;
                    // table.ajax.reload(function() {
                    //     table.page(currentPageIndex).draw(false);
                    // }, false);

                    $('#list_active_modal').modal('hide');
                } else {
                    swal(`${res.res_message}`, '', 'error');
                }

            }).fail(function() {
                console.log('fail')
            })
        })


        //-------------------------------------------- ADD PER ROUND ---------------------------------------//
        $('#form_per_round').on('submit', function(e) {
            e.preventDefault();

            let contestant = $('#add_contestant').val();
            let round_no = $('#per_active_round').val();


            $.ajax({
                url: 'contestants_round/add_per_round',
                type: 'POST',
                data: {
                    contestant: contestant,
                    round_no: round_no
                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Added a Contestant', '', 'success');

                    var currentPageIndex = table.page.info().page;
                    table.ajax.reload(function() {
                        table.page(currentPageIndex).draw(false);
                    }, false);

                    $('#list_active_modal').modal('hide');
                } else {
                    swal(`${res.res_message}`, '', 'error');
                }

            }).fail(function() {
                console.log('fail')
            })
        })


        //-------------------------------------------- POPULATE TABULATION ---------------------------------------//
        $('#form_populate').on('submit', function(e) {
            e.preventDefault();

            let round_no = $('#populate_c').val();


            $.ajax({
                url: 'contestants_round/populate',
                type: 'POST',
                data: {
                    round_no: round_no
                },
                dataType: 'JSON',
                beforeSend: function() {

                }
            }).done(function(res) {
                if (res.res_success == 1) {
                    swal('Successfully Populated Criteria Per Judge', '', 'success');

                    $('#list_populate_modal').modal('hide');
                } else {
                    swal(`${res.res_message}`, '', 'error');
                }

            }).fail(function() {
                console.log('fail')
            })
        })



        // Check if DataTable is already initialized
        if (!$.fn.DataTable.isDataTable('#myTable')) {
            $('#myTable').DataTable({
                "ordering": false,
                searching: false,
                paging: false,
                columns: [{
                        data: [0],
                        "className": "text-center"
                    },
                    {
                        data: [1],
                        "className": "text-center"
                    },
                    {
                        data: [2],
                        "className": "text-center"
                    },
                    {
                        data: [3],
                        "className": "text-center"
                    },
                    {
                        data: [4],
                        "className": "text-center"
                    },
                    {
                        data: null,
                        visible: false
                    } // Hidden column for contestant_round_id
                ],
                "rowCallback": function(row, data) {
                    $(row).attr('id', data[5]); // Use data[4] for contestant_round_id
                }
            });
        }

        $('#round_no_select').on('change', function() {
            var tvalue = this.value;

            $.ajax({
                url: 'contestants_round/contestant_view2',
                type: 'POST',
                data: {
                    tvalue: tvalue
                },
                dataType: 'json',
                success: function(response) {
                    if (response.length === 0) {
                        swal('No Contestant Registered in that Round.', '', 'error');
                    } else {
                        // Clear existing data in the DataTable
                        $('#myTable').DataTable().clear();

                        // Add new data to the DataTable
                        $('#myTable').DataTable().rows.add(response.data).draw();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });


        //DOCUMENT READY
    })
</script>