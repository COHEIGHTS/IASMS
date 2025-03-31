<?php
// Include database connection
include 'database_connection/database_connection.php';

// Fetch available attachment positions
$sql = "SELECT * FROM attachment_positions WHERE status = 'active' AND available_positions > 0";
$result = mysqli_query($conn, $sql);

// Fetch student name from cookies
$student_fname = $_COOKIE["student_first_name"] ?? 'Student';
$student_lname = $_COOKIE["student_last_name"] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Available Attachment Positions</title>

  <!-- Linking CSS files -->
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-select.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <link rel="stylesheet" href="register_page.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables@1.10.25/css/jquery.dataTables.min.css" />

  <!-- Custom CSS for Table Styling -->
  <style>
  /* Styling for the table */
  #positionsTable {
    width: 100%;
    border-collapse: collapse;
    border-radius: 8px;
    overflow: hidden;
  }

  #positionsTable th {
    background-color: #007BFF;
    color: white;
    text-align: center;
    padding: 12px;
  }

  #positionsTable td {
    text-align: center;
    padding: 10px;
    font-size: 14px;
  }

  #positionsTable tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #positionsTable tr:hover {
    background-color: #ddd;
  }

  /* Responsive Table */
  .table-responsive {
    padding: 20px;
    margin-top: 20px;
  }
  </style>

  <!-- jQuery and Bootstrap JS -->
  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0); font-size:1.1em;"><em>Welcome,</em></span>
      <span style="font-family:serif;"><?php echo "$student_fname $student_lname"; ?></span>
    </div>
  </div>

  <!-- Left Sidebar -->
  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="../instructions_page/instructions_page.php">
        <li class="menu_items_list">Instructions</li>
      </a>
      <a class="menu_items_link" href="../view_position.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Available Attachment Positions
        </li>
      </a>
      <a class="menu_items_link" href="../Register_Page/register_page.php">
        <li class="menu_items_list">Register</li>
      </a>
      <a class="menu_items_link" href="../student_assumption/student_assumption.php">
        <li class="menu_items_list">Submit Assumption</li>
      </a>
      <a class="menu_items_link" href="../e-logbook/elogbook.php">
        <li class="menu_items_list">E-Logbook</li>
      </a>
      <a class="menu_items_link" href="../company_supervisor/company_supervisor_login.php">
        <li class="menu_items_list">Company Supervisor</li>
      </a>
      <a class="menu_items_link" href="../visiting_supervisor/visiting_supervisor_login.php">
        <li class="menu_items_list">Visiting Supervisor</li>
      </a>
      <a class="menu_items_link" href="../submit_report/submit_report.php">
        <li class="menu_items_list">Submit Report</li>
      </a> <a class="menu_items_link" href="admin/change_password/change_password.php">
        <li class="menu_items_list">Change Password</li>
      </a>
      <a class="menu_items_link" href="../../add_admin.php">
        <li class="menu_items_list">Add Admin</li>
      </a>
      <a class="menu_items_link" href="../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <!-- Main Content -->
  <div id="main_content">
    <h2 class="text-center">Available Attachment Positions</h2>

    <div class="table-responsive">
      <table id="positionsTable" class="table table-bordered">
        <thead>
          <tr>
            <th>Position Name</th>
            <th>Department</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Available Positions</th>
            <th>Organization</th>
            <th>Contact Email</th>
            <th>Apply</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['position_name']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo date("d M Y", strtotime($row['start_date'])); ?></td>
            <td><?php echo date("d M Y", strtotime($row['end_date'])); ?></td>
            <td><?php echo $row['available_positions']; ?></td>
            <td><?php echo $row['organization_name']; ?></td>
            <td>
              <span data-toggle="tooltip" title="Click to contact the organization">
                <?php echo $row['organization_email']; ?>
              </span>
            </td>
            <td>
              <a href="../apply_position.php?position_id=<?php echo $row['id']; ?>" class="btn btn-success">Apply</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- DataTables and Tooltip Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/datatables@1.10.25/js/jquery.dataTables.min.js"></script>

  <script>
  $(document).ready(function() {
    // Initialize DataTables with pagination and styling
    $('#positionsTable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "pageLength": 5, // Show 5 records per page
      "language": {
        "paginate": {
          "previous": "<",
          "next": ">"
        }
      }
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
  });
  </script>

</body>

</html>