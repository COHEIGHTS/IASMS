<?php
// Include the database connection
include 'database_connection/database_connection.php';

// Define number of records per page
$records_per_page = 4;

// Get the current page number from the query string, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $records_per_page;

// Fetch the total number of supervisors in the database
$sql_count = "SELECT COUNT(*) AS total FROM supervisors_login";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch the supervisors for the current page
$sql_select = "SELECT * FROM supervisors_login ORDER BY date DESC LIMIT $start_from, $records_per_page";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Supervisors</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
  <style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f7fa;
    color: #333;
    margin: 0;
  }

  .main-content {
    margin-left: 220px;
    padding-top: 70px;
    padding-left: 30px;
  }

  #top-navigation {
    background-color: green;
    padding: 10px;
    text-align: right;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  #top-navigation #student_name {
    color: white;
    font-size: 1.2em;
  }

  #left_side_bar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 220px;
    background-color: green;
    padding-top: 50px;
    overflow-y: auto;
    z-index: 999;
  }

  #menu_list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .menu_items_link {
    color: white;
    text-decoration: none;
  }

  .menu_items_list {
    padding: 15px;
    border-bottom: 1px solid #444;
  }

  .menu_items_list:hover {
    background-color: #555;
  }

  .container {
    margin-top: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 100%;
  }

  h2 {
    font-weight: 700;
    color: #4CAF50;
    text-align: center;
  }

  table {
    margin-top: 20px;
  }

  table th,
  table td {
    text-align: center;
    padding: 12px;
    border: 1px solid #ddd;
  }

  table tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s ease;
  }

  .btn {
    border-radius: 50px;
    padding: 10px 20px;
  }

  .pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
  }
  </style>
</head>

<body>

  <!-- Top Navigation Bar -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:orange;font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
      <span style="font-family:serif"><?php echo "Admin"; ?></span>
    </div>
  </div>

  <!-- Left Sidebar -->
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
      </a>
      <a class="menu_items_link" href="../../admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="../../logbook_report.php">
        <li class="menu_items_list">Logbook Report</li>
      </a>
      <!-- New Link for Activity Logs -->

      <a class="menu_items_link" href="admin/change_password/change_password.php">
        <li class="menu_items_list">Change Password</li>
      </a>
      <a class="menu_items_link" href="../../add_admin.php">
        <li class="menu_items_list">Add Admin</li>
      </a>
      <a class="menu_items_link" href="../../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>
  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      <h2>List of Supervisors</h2>

      <?php if ($result->num_rows > 0) { ?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['password']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
              <a href="edit_supervisor.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete</button>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } else {
        echo "<div class='alert alert-warning'>No supervisors found.</div>";
      } ?>

      <a href="add_supervisor.php" class="btn btn-primary w-100">Add New Supervisor</a>
    </div>
  </div>

  <script>
  function confirmDelete(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "delete_supervisor.php?id=" + id;
      }
    });
  }
  </script>

</body>

</html>