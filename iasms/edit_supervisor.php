<?php
// Include the database connection
include 'database_connection/database_connection.php';

if (isset($_GET['id'])) {
    // Get the supervisor ID from the URL
    $supervisor_id = $_GET['id'];

    // Fetch the supervisor's current details
    $sql_select = "SELECT * FROM supervisors_login WHERE id = '$supervisor_id'";
    $result = $conn->query($sql_select);
    $supervisor = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the form inputs
        $username = $_POST['username'];
        $password = $_POST['password'];
        $status = $_POST['status'];

        // Update the supervisor details in the database
        $sql_update = "UPDATE supervisors_login SET username = '$username', password = '$password', status = '$status' WHERE id = '$supervisor_id'";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "<script>alert('Supervisor updated successfully.'); window.location.href = '../../view_supervisor.php';</script>";
        } else {
            echo "<script>alert('Error updating supervisor.');</script>";
        }
    }
} else {
    echo "<script>alert('Supervisor ID is missing.'); window.location.href = '../../view_supervisor.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-pink">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Supervisor</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/main_page_style.css">

  <script src="../../js/jquery-3.1.1.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
      <span style="font-family:serif"><?php echo "Admin" ?></span>
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
  <div id="main_content">
    <div class="container-fluid">
      <div class="panel">
        <div class="panel-heading industrial_phead">
          <h2 class="panel-title industrial_ptitle">Edit Supervisor</h2>
        </div>

        <div class="panel-body industrial_pbody">
          <div class="panel">
            <div class="panel-body">
              <form method="POST" action="edit_supervisor.php?id=<?php echo $supervisor['id']; ?>">
                <div class="form-group">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control form-control-adjusted" id="username" name="username"
                    value="<?php echo $supervisor['username']; ?>" required>
                </div>

                <div class="form-group">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control form-control-adjusted" id="password" name="password"
                    value="<?php echo $supervisor['password']; ?>" required>
                </div>

                <div class="form-group">
                  <label for="status" class="form-label">Status</label>
                  <input type="text" class="form-control form-control-adjusted" id="status" name="status"
                    value="<?php echo $supervisor['status']; ?>" required>
                </div>

                <div id="btn_submit_holder">
                  <button type="submit" class="btn btn-primary">Update Supervisor</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>