<?php
// Include the database connection
include 'database_connection/database_connection.php';

// Define the action when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $status = $_POST['status'];
    $date = date('Y-m-d H:i:s'); // Get the current date and time for the timestamp

    // Hash the password for secure storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new record into the database
    $sql_insert = "INSERT INTO supervisors_login (username, password, date, status) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ssss", $username, $hashed_password, $date, $status);

    // Execute the query
    if ($stmt_insert->execute()) {
        $alert_message = "<div class='alert alert-success alert-dismissible fade show' role='alert'>New supervisor added successfully!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } else {
        $alert_message = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Error: " . $conn->error . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Supervisor</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  /* Global Styles */
  body {
    font-family: 'Roboto', sans-serif;
    background: #f4f7fa;
    color: #333;
  }

  /* Top Navigation Bar */
  #top-navigation {
    background: linear-gradient(90deg, #006605, #008a39);
    /* Green gradient */
    padding: 15px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: flex-end;
    /* Align content to the right */
    align-items: center;
  }

  #student_name {
    color: #fff;
    font-size: 1.3em;
    margin-right: 20px;
    /* Space from the right edge */
  }

  #student_name span:first-child {
    color: #f39c12;
    /* Orange for "Welcome," */
  }

  /* Left Sidebar */
  #left_side_bar {
    width: 250px;
    height: 100vh;
    background: linear-gradient(180deg, #006605, #008a39);
    /* Green gradient */
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 60px;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
  }

  #menu_list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .menu_items_link {
    text-decoration: none;
    display: block;
    transition: all 0.3s ease;
  }

  .menu_items_list {
    padding: 15px 20px;
    color: #ecf0f1;
    font-size: 16px;
    font-weight: 500;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
  }

  .menu_items_link:hover .menu_items_list {
    background: rgba(255, 255, 255, 0.1);
    color: #f39c12;
    padding-left: 25px;
  }

  .menu_items_list.active,
  .menu_items_list[style*="background-color:orange"] {
    background: #f39c12 !important;
    color: #fff !important;
    border-left: 4px solid #e67e22;
    padding-left: 16px;
  }

  /* Main Content */
  .main-content {
    margin-left: 250px;
    padding: 80px 20px 20px;
    min-height: 100vh;
  }

  .container {
    max-width: 600px;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  h2 {
    color: #006605;
    /* Match green theme */
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
  }

  /* Form Styling */
  .form-label {
    font-weight: 500;
    color: #34495e;
  }

  .form-control {
    border-radius: 5px;
    border: 1px solid #ced4da;
    padding: 10px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .form-control:focus {
    border-color: #f39c12;
    box-shadow: 0 0 5px rgba(243, 156, 18, 0.5);
    outline: none;
  }

  .btn-primary {
    background: #f39c12;
    border: none;
    padding: 12px;
    font-weight: 500;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .btn-primary:hover {
    background: #e67e22;
    transform: translateY(-2px);
  }

  .btn-info {
    background: #3498db;
    border: none;
    padding: 12px;
    font-weight: 500;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .btn-info:hover {
    background: #2980b9;
    transform: translateY(-2px);
  }

  .button-container {
    text-align: center;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    #left_side_bar {
      width: 200px;
    }

    .main-content {
      margin-left: 200px;
      padding: 70px 15px 15px;
    }

    .container {
      padding: 20px;
    }

    #student_name {
      font-size: 1.1em;
      margin-right: 15px;
    }
  }

  @media (max-width: 576px) {
    #left_side_bar {
      width: 100%;
      height: auto;
      position: relative;
      padding-top: 0;
    }

    .main-content {
      margin-left: 0;
      padding: 20px;
    }

    #top-navigation {
      padding: 10px;
      justify-content: center;
      /* Center on small screens if needed */
    }
  }
  </style>
</head>

<body>

  <!-- Top Navigation Bar -->
  <div id="top-navigation">
    <div id="student_name">
      <span><em>Welcome,</em></span>
      <span><?php echo "Admin" ?></span>
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

  <!-- Main Content Section -->
  <div class="main-content">
    <?php
    // Display alert message if it exists
    if (isset($alert_message)) {
        echo $alert_message;
    }
    ?>

    <div class="container">
      <h2>Add New Supervisor</h2>
      <form action="add_supervisor.php" method="POST" class="mt-4">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
            required>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option value="" disabled selected>Select status</option>
            <option value="Company">Company</option>
            <option value="Visiting">Visiting</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Supervisor</button>
      </form>

      <div class="button-container mt-3">
        <a href="../../view_supervisor.php" class="btn btn-info w-100">View Supervisors</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>