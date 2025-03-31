<?php
// Include database connection
include 'database_connection/database_connection.php';

// Fetch available attachment positions
$sql = "SELECT * FROM attachment_positions WHERE status = 'active' AND available_positions > 0";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Attachment Positions</title>

  <!-- Bootstrap CSS (for styling) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables CSS for better table functionality -->
  <link href="https://cdn.jsdelivr.net/npm/datatables@1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- Optional: Custom CSS -->
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
  }

  h2 {
    text-align: center;
    margin-top: 20px;
    font-size: 28px;
    color: #343a40;
  }

  .table {
    margin-top: 20px;
  }

  .table thead {
    background-color: #007bff;
    color: white;
  }

  .table tbody tr:hover {
    background-color: #f1f1f1;
  }

  .tooltip-inner {
    background-color: #333;
    color: #fff;
  }

  .table-responsive {
    margin-top: 20px;
  }
  </style>
</head>

<body>

  <div class="container">
    <h2>Available Attachment Positions</h2>

    <div class="table-responsive">
      <table id="positionsTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Position Name</th>
            <th>Department</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Available Positions</th>
            <th>Organization</th>
            <th>Contact Email</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['position_name']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['end_date']; ?></td>
            <td><?php echo $row['available_positions']; ?></td>
            <td><?php echo $row['organization_name']; ?></td>
            <td>
              <span data-toggle="tooltip" title="Click to contact the organization">
                <?php echo $row['organization_email']; ?>
              </span>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables JS for Table functionality -->
  <script src="https://cdn.jsdelivr.net/npm/datatables@1.10.25/js/jquery.dataTables.min.js"></script>

  <!-- Initialize DataTables and Tooltips -->
  <script>
  $(document).ready(function() {
    // Initialize DataTables for pagination and search
    $('#positionsTable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
  });
  </script>

</body>

</html>