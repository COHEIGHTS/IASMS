<?php
// Include database connection
include 'database_connection/database_connection.php';

// Handle form submission to add new attachment position
if (isset($_POST['add_position'])) {
    $position_name = mysqli_real_escape_string($conn, $_POST['position_name']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $available_positions = mysqli_real_escape_string($conn, $_POST['available_positions']);
    $organization_name = mysqli_real_escape_string($conn, $_POST['organization_name']);
    $organization_email = mysqli_real_escape_string($conn, $_POST['organization_email']);
    
    // Insert into the database
    $sql = "INSERT INTO attachment_positions (position_name, department, start_date, end_date, description, available_positions, organization_name, organization_email, status)
            VALUES ('$position_name', '$department', '$start_date', '$end_date', '$description', '$available_positions', '$organization_name', '$organization_email', 'active')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Position added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error adding position: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EUIAMS - Add Position</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="view_registered_students.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em> </span>
      <span style="font-family:serif"><?php echo "Admin" ?></span>
    </div>
  </div>

  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="admin/view_registered_students/view_registered_students.php">
        <li class="menu_items_list">Registered Students</li>
      </a>
      <a class="menu_items_link" href="../../add_position.php">
        <li class="menu_items_list" style="background-color:orange;">Add Attachment Positions</li>
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
      <a class="menu_items_link" href="#">
        <li class="menu_items_list">Visiting Supervisors Score</li>
      </a>
      <a class="menu_items_link" href="../company_score/company_supervisor_score.php">
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
    <div class="container mt-5">
      <div class="panel">
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle">Add New Attachment Position</h2>
        </div>
        <div class="panel-body pbody">
          <form method="POST" action="">
            <div class="row g-3">
              <div class="col-md-6 mb-3">
                <label for="position_name" class="form-label">Position Name</label>
                <input type="text" class="form-control" id="position_name" name="position_name"
                  placeholder="e.g., Software Intern" required>
              </div>

              <div class="col-md-6 mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department"
                  placeholder="e.g., IT Department" required>
              </div>

              <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
              </div>

              <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
              </div>

              <div class="col-12 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"
                  placeholder="Briefly describe the position..." required></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="available_positions" class="form-label">Available Positions</label>
                <input type="number" class="form-control" id="available_positions" name="available_positions" min="1"
                  placeholder="e.g., 5" required>
              </div>

              <div class="col-md-6 mb-3">
                <label for="organization_name" class="form-label">Organization Name</label>
                <input type="text" class="form-control" id="organization_name" name="organization_name"
                  placeholder="e.g., TechCorp" required>
              </div>

              <div class="col-12 mb-4">
                <label for="organization_email" class="form-label">Organization Email</label>
                <input type="email" class="form-control" id="organization_email" name="organization_email"
                  placeholder="e.g., contact@techcorp.com" required>
              </div>

              <div class="col-12 text-center">
                <button type="submit" name="add_position" class="btn btn-primary w-50">Add Position</button>
              </div>

              <div class="col-12 text-center mt-3">
                <a href="view_added_position.php" class="btn btn-secondary w-50">Manage Added Positions</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <style>
  /* Form-specific styling */
  .panel-body {
    padding: 30px;
    /* Consistent padding */
  }

  .form-label {
    font-weight: 600;
    color: #2c3e50;
    /* Darker color for contrast */
    margin-bottom: 8px;
  }

  .form-control {
    border-radius: 6px;
    border: 1px solid #ced4da;
    padding: 10px 12px;
    font-size: 16px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .form-control:focus {
    border-color: #f39c12;
    /* Orange focus border */
    box-shadow: 0 0 5px rgba(243, 156, 18, 0.5);
    outline: none;
  }

  .form-control::placeholder {
    color: #6c757d;
    /* Subtle placeholder color */
    font-style: italic;
  }

  textarea.form-control {
    resize: vertical;
    /* Allow vertical resizing only */
  }

  .btn-primary {
    background: #f39c12;
    /* Orange theme */
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 6px;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .btn-primary:hover {
    background: #e67e22;
    /* Darker orange on hover */
    transform: translateY(-2px);
  }

  .btn-secondary {
    background: #6c757d;
    /* Gray for secondary button */
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 6px;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .btn-secondary:hover {
    background: #5a6268;
    /* Darker gray on hover */
    transform: translateY(-2px);
  }

  .alert {
    margin-bottom: 20px;
    border-radius: 6px;
  }
  </style>

</body>

</html>