<?php
// Include database connection
include 'database_connection/database_connection.php';

// Initialize alert message
$alertMessage = "";

// Fetch the position data based on the ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM attachment_positions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $position = mysqli_fetch_assoc($result);

    if (!$position) {
        die("No position found with the provided ID.");
    }
} else {
    die("Invalid request.");
}

// Handle form submission to update position
if (isset($_POST['update_position'])) {
    $position_name = trim($_POST['position_name']);
    $department = trim($_POST['department']);
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $description = trim($_POST['description']);
    $available_positions = trim($_POST['available_positions']);
    $organization_name = trim($_POST['organization_name']);
    $organization_email = trim($_POST['organization_email']);

    $sql = "UPDATE attachment_positions SET position_name=?, department=?, start_date=?, 
            end_date=?, description=?, available_positions=?, organization_name=?, 
            organization_email=? WHERE id=?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssisi", $position_name, $department, $start_date, 
                            $end_date, $description, $available_positions, 
                            $organization_name, $organization_email, $id);

    if (mysqli_stmt_execute($stmt)) {
        $alertMessage = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            Position updated successfully!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        // Refresh position data after update
        $sql = "SELECT * FROM attachment_positions WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $position = mysqli_fetch_assoc($result);
    } else {
        $alertMessage = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            Error updating position: " . mysqli_error($conn) . "
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Position</title>
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/main_page_style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fc;
    margin: 0;
    /* Remove default body margin */
    padding: 0;
    /* Remove default body padding */
    overflow-x: hidden;
    /* Prevent horizontal scrolling */
  }

  /* Top Navigation */
  #top-navigation {
    position: fixed;
    top: 0;
    /* Ensure it’s at the very top */
    left: 0;
    width: 100%;
    background: green;
    /* Dark blue background */
    color: #fff;
    padding: 15px;
    z-index: 1000;
    /* Stay above other content */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  #student_name span {
    font-size: 1.1em;
  }

  #student_name span:first-child {
    color: rgb(255, 198, 0);
    /* Orange "Welcome" */
  }

  /* Left Sidebar */
  #left_side_bar {
    position: fixed;
    top: 0;
    /* Align with top navigation */
    left: 0;
    width: 220px;
    /* Fixed width */
    height: 100vh;
    /* Full height */
    background: green;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    z-index: 999;
    /* Below top navigation but above main content */
    overflow-y: auto;
    /* Scrollable if content exceeds height */
  }

  #menu_list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .menu_items_list {
    padding: 15px 20px;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .menu_items_list:hover,
  .menu_items_link:hover .menu_items_list {
    background: #f39c12;
    /* Orange hover */
    color: #fff;
  }

  .menu_items_link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  /* Main Content */
  .container {
    max-width: 800px;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    margin: 80px auto 50px;
    /* Adjusted top margin to clear top navigation */
  }

  h2 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 25px;
    text-align: center;
  }

  .form-label {
    font-weight: 600;
    color: #34495e;
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
    /* Orange focus */
    box-shadow: 0 0 5px rgba(243, 156, 18, 0.5);
    outline: none;
  }

  .form-control::placeholder {
    color: #6c757d;
    font-style: italic;
  }

  textarea.form-control {
    resize: vertical;
  }

  .btn-primary {
    background: #f39c12;
    /* Orange theme */
    border: none;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 6px;
    transition: background 0.3s ease, transform 0.2s ease;
    width: 100%;
    max-width: 300px;
    /* Limit button width */
  }

  .btn-primary:hover {
    background: #e67e22;
    /* Darker orange */
    transform: translateY(-2px);
  }

  .alert {
    border-radius: 6px;
    margin-bottom: 20px;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    #left_side_bar {
      width: 200px;
      /* Slightly narrower sidebar */
    }

    .container {
      margin-left: 220px;
      /* Clear sidebar */
      margin-right: 20px;
      width: calc(100% - 240px);
    }
  }

  @media (max-width: 576px) {
    #left_side_bar {
      position: static;
      /* Sidebar becomes static on small screens */
      width: 100%;
      height: auto;
    }

    .container {
      margin: 20px auto;
      /* Stack below sidebar */
      width: 90%;
      /* Responsive width */
    }

    .btn-primary {
      max-width: 100%;
    }
  }
  </style>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em> </span>
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

  <div class="container">
    <h2>Edit Position</h2>

    <?php echo $alertMessage; ?>

    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-6 mb-3">
          <label for="position_name" class="form-label">Position Name</label>
          <input type="text" class="form-control" id="position_name" name="position_name"
            value="<?php echo htmlspecialchars($position['position_name'] ?? ''); ?>"
            placeholder="e.g., Software Intern" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="department" class="form-label">Department</label>
          <input type="text" class="form-control" id="department" name="department"
            value="<?php echo htmlspecialchars($position['department'] ?? ''); ?>" placeholder="e.g., IT Department"
            required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="start_date" class="form-label">Start Date</label>
          <input type="date" class="form-control" id="start_date" name="start_date"
            value="<?php echo htmlspecialchars($position['start_date'] ?? ''); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="end_date" class="form-label">End Date</label>
          <input type="date" class="form-control" id="end_date" name="end_date"
            value="<?php echo htmlspecialchars($position['end_date'] ?? ''); ?>" required>
        </div>

        <div class="col-12 mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="4"
            placeholder="Briefly describe the position..."
            required><?php echo htmlspecialchars($position['description'] ?? ''); ?></textarea>
        </div>

        <div class="col-md-6 mb-3">
          <label for="available_positions" class="form-label">Available Positions</label>
          <input type="number" class="form-control" id="available_positions" name="available_positions"
            value="<?php echo htmlspecialchars($position['available_positions'] ?? ''); ?>" min="1"
            placeholder="e.g., 5" required>
        </div>

        <div class="col-md-6 mb-3">
          <label for="organization_name" class="form-label">Organization Name</label>
          <input type="text" class="form-control" id="organization_name" name="organization_name"
            value="<?php echo htmlspecialchars($position['organization_name'] ?? ''); ?>" placeholder="e.g., TechCorp"
            required>
        </div>

        <div class="col-12 mb-4">
          <label for="organization_email" class="form-label">Organization Email</label>
          <input type="email" class="form-control" id="organization_email" name="organization_email"
            value="<?php echo htmlspecialchars($position['organization_email'] ?? ''); ?>"
            placeholder="e.g., contact@techcorp.com" required>
        </div>

        <div class="col-12 text-center">
          <button type="submit" name="update_position" class="btn btn-primary">Update Position</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS (required for alert dismiss functionality) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>