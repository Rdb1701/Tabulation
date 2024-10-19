<?php include('../header.php');
// $contestant_round_id = isset($_GET['contestant_round_id']) ? mysqli_real_escape_string($db, trim($_GET['contestant_round_id'])) : '';
?>
<!-- <div class="card radius-12">
  <div class="card-body">
    <div class="table-responsive table-wrapper"> -->
<table class="table table-bordered table-hover table-secondary" id="myTable">
  <thead class="table-light">
    <tr>
      <th class="text-center" style="width: 300px;"></th>
      <th class="text-center" style="width: 400px;">Criteria for Judging</th>
      <th class="text-center">Score(0 -10)</th>
      <th class="text-center">% Equivalent</th>
    </tr>
  </thead>
  <tbody style="overflow: auto;">

  </tbody>
</table>
<!-- </div>
  </div>
</div> -->


<?php include('../footer.php') ?>

<script>
  //Score INPUT
  function score_put(inputElement, tabulation_id) {
    let score = $(inputElement).val();

    // Check if the input value is empty
    if (score.trim() === '') {
      return; 
    }


    if (score > 10) {
      swal("Maximum Score is 10. Please Input Again", '', 'error')
    } else {
      $.ajax({
        url: 'dash/score_input',
        type: 'POST',
        data: {
          score: score,
          tabulation_id: tabulation_id
        },
        dataType: 'JSON',
        beforeSend: function() {

        }
      }).done(function(res) {
        // loadContent(contestant_round_id);
      }).fail(function() {
        console.log("FAIL");
      });
    }
  }


  // Check if DataTable is already initialized
  if (!$.fn.DataTable.isDataTable('#myTable')) {
    $('#myTable').DataTable({
      "ordering": false,
      searching: false,
      paging: false,
      columns: [{
          data: [0],
          "className": "text-left",
          "orderable": false
        },
        {
          data: [1],
          "className": "text-left h3"
        },
        {
          data: [2],
          "className": "text-center h3"
        },
        {
          data: [3],
          "className": "text-center h3"
        }
      ],
      "createdRow": function(row, data, dataIndex) {
        if (dataIndex === 0) {
          $('td', row).eq(0).attr('rowspan', 7);
        } else {
          $('td', row).eq(0).remove(); // Remove the first column for all other rows
        }
      }
    });
  }


  function loadContent(contestant_round_id) {
    $.ajax({

      url: 'dash/dashboard_view',
      type: 'POST',
      data: {
        contestant_round_id: contestant_round_id
      },
      dataType: 'json',
      success: function(response) {
     
          // Clear existing data in the DataTable
          $('#myTable').DataTable().clear();

          // Add new data to the DataTable
          $('#myTable').DataTable().rows.add(response.data).draw();
        
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  }



    // Initialize DataTable
  // var table = $('#myTable').DataTable({
  //   searching: false,
  //   paging: false,
  //   "ordering": false,
  //   ajax: {
  //     url: 'dash/dashboard_view',
  //     type: 'POST',
  //     data: {
  //       contestant_round_id: idValue
  //     }
  //   },
  //   columns: [{
  //       data: [0],
  //       "className": "text-left",
  //       "orderable": false
  //     },
  //     {
  //       data: [1],
  //       "className": "text-left h3"
  //     },
  //     {
  //       data: [2],
  //       "className": "text-center h3"
  //     },
  //     {
  //       data: [3],
  //       "className": "text-center h3"
  //     }
  //   ],
  //   "createdRow": function(row, data, dataIndex) {
  //     if (dataIndex === 0) {
  //       $('td', row).eq(0).attr('rowspan', 7);
  //     } else {
  //       $('td', row).eq(0).remove(); // Remove the first column for all other rows
  //     }
  //   }
  // });
</script>