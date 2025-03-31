<?php
// Include database connection
include 'database_connection/database_connection.php';
$alertMessage = ""; // Initialize alert message

// Handle the delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM attachment_positions WHERE id = '$delete_id'";
    if (mysqli_query($conn, $sql)) {
        $alertMessage = "<div class='alert alert-success alert-dismissible fade show custom-alert' role='alert'>
                <strong>Success!</strong> Position deleted successfully.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    } else {
        $alertMessage = "<div class='alert alert-danger alert-dismissible fade show custom-alert' role='alert'>
                <strong>Error!</strong> Error deleting position: " . mysqli_error($conn) . "
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

// Pagination logic
$limit = 4;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total number of positions
$sql_count = "SELECT COUNT(*) FROM attachment_positions";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_row($result_count);
$total_records = $row_count[0];
$total_pages = ceil($total_records / $limit);

// Fetch positions for the current page (Ordered by latest first)
$sql = "SELECT * FROM attachment_positions ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Positions</title>
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/main_page_style.css">
  <style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f7fa;
  }

  .container {
    margin-top: 50px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
  }

  h2 {
    font-weight: 700;
    color: #4CAF50;
    text-align: center;
  }

  .custom-alert {
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    width: 50%;
    z-index: 1000;
    text-align: center;
    animation: slideDown 0.5s ease-out;
  }

  .pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  .pagination-container a {
    margin: 0 5px;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    background-color: #f1f1f1;
  }

  .pagination-container a:hover,
  .pagination-container .active {
    background-color: #007bff;
    color: white;
  }

  .pagination-container .disabled {
    background-color: #ddd;
    cursor: not-allowed;
  }
  </style>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name"><span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp; </span>
      <span style="font-family:serif"><?php echo "Admin"; ?></span>
    </div>
  </div>

  <!-- Left Sidebar -->
  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="admin/view_registered_students/view_registered_students.php">
        <li class="menu_items_list" style="background-color:;padding-left:16px">Registered Students</li>
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

  <div id="main_content">
    <div class="container">
      <h2>Manage Attachment Positions</h2>

      <?php echo $alertMessage; ?>

      <?php if (mysqli_num_rows($result) > 0): ?>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Position Name</th>
            <th>Department</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Description</th>
            <th>Available Positions</th>
            <th>Organization Name</th>
            <th>Organization Email</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['position_name']; ?></td>
            <td><?php echo $row['department']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['end_date']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['available_positions']; ?></td>
            <td><?php echo $row['organization_name']; ?></td>
            <td><?php echo $row['organization_email']; ?></td>
            <td><span class="badge bg-<?php echo ($row['status'] == 'active') ? 'success' : 'danger'; ?>">
                <?php echo ucfirst($row['status']); ?></span>
            </td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
              <a href="edit_position.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this position?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="pagination-container">
        <?php if ($page > 1): ?>
        <a href="?page=<?php echo ($page - 1); ?>" class="btn btn-secondary">Previous</a>
        <?php else: ?>
        <a href="#" class="btn btn-secondary disabled">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="btn btn-<?php echo ($page == $i) ? 'primary' : 'light'; ?>">
          <?php echo $i; ?>
        </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo ($page + 1); ?>" class="btn btn-secondary">Next</a>
        <?php else: ?>
        <a href="#" class="btn btn-secondary disabled">Next</a>
        <?php endif; ?>
      </div>

      <?php else: ?>
      <div class="alert alert-warning">No positions found.</div>
      <?php endif; ?>
    </div>
  </div>

</body>

</html>