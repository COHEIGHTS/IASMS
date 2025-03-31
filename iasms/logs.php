<?php
// Include the database connection
include 'database_connection/database_connection.php';

// Define number of records per page
$records_per_page = 4;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $records_per_page;

// Fetch the total number of logs in the database
$sql_count = "SELECT COUNT(*) AS total FROM activity_logs";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch the logs for the current page
$sql_select = "SELECT * FROM activity_logs ORDER BY timestamp DESC LIMIT $start_from, $records_per_page";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en" class="bg-pink">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EUIAMS</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="view_registered_students.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

  <style>
  /* Adjust container to avoid being blocked by the navigation bars */
  .container {
    margin-left: 260px;
    /* Adjust based on sidebar width */
    padding-top: 80px;
    /* Adjust based on top navigation height */
    max-width: 80%;
  }

  /* Custom styles for the title */
  h2 {
    color: #ff5733;
    /* Change this color to whatever you prefer */
    font-family: Arial, sans-serif;
    /* Optional: change the font if you like */
    font-size: 2em;
    /* Optional: adjust the size of the title */
    text-align: center;
    /* Optional: center-align the title */
  }

  /* Make sure the table is responsive */
  .table {
    width: 100%;
    margin-top: 20px;
  }

  /* Custom styles for table headers and data cells */
  th,
  td {
    text-align: center;
  }

  .alert {
    margin-top: 20px;
  }
  </style>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
      <span style="font-family:serif"><?php echo "Admin" ?></span>
    </div>
  </div>

  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="admin/view_registered_students/view_registered_students.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Registered Students</li>
      </a>
      <a class="menu_items_link" href="../../add_position.php">
        <li class="menu_items_list">Add Attachment Positions</li>
      </a>
      <a class="menu_items_link" href="admin/students_assumptions/students_assumptions.php">
        <li class="menu_items_list">Student Assumptions</li>
      </a>
      <a class="menu_items_link" href="admin/student_stat/student_stat.php">
        <li class="menu_items_list">Student Statistics</li>
      </a>
      <a class="menu_items_link" href="../../add_supervisor.php">
        <li class="menu_items_list">Add Supervisor</li>
      </a>
      <a class="menu_items_link" href="admin/visiting_score/visiting_supervisors_score.php">
        <li class="menu_items_list">Visiting Supervisors Score</li>
      </a>
      <a class="menu_items_link" href="admin/company_score/company_supervisor_score.php">
        <li class="menu_items_list">Company Supervisor Score</li>
      </a><a class="menu_items_link" href="../../admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="../../logbook_report.php">
        <li class="menu_items_list">Logbook Report</li>
      </a>
      <!-- New Link for Activity Logs -->
      <a class="menu_items_link" href="../../logs.php">
        <li class="menu_items_list">Activity Logs</li>
      </a>
      <a class="menu_items_link" href="admin/change_password/change_password.php">
        <li class="menu_items_list">Change Password</li>
      </a>
      <a class="menu_items_link" href="../../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="container">
    <h2>Activity Logs</h2>

    <?php if ($result->num_rows > 0) { ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>User ID</th>
          <th>Action</th>
          <th>Device Info</th>
          <th>IP Address</th>
          <th>Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['user_id'] ?? 'Guest'; ?></td>
          <td><?php echo $row['action']; ?></td>
          <td><?php echo $row['device_info']; ?></td>
          <td><?php echo $row['ip_address']; ?></td>
          <td><?php echo $row['timestamp']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } else { echo "<div class='alert alert-warning'>No activity logs found.</div>"; } ?>
  </div>

</body>

</html>