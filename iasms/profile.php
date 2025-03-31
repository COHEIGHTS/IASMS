<?php
// Include database connection
include 'database_connection/database_connection.php';

// Initialize variables for feedback
$message = "";

// Handle form submission
if (isset($_POST['btn_add_admin'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Basic validation
    if (empty($username) || empty($password)) {
        $message = "<p style='color: red;'>Please fill in all fields.</p>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the insert query
        $sql = "INSERT INTO system_admin (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Admin added successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error adding admin: " . $conn->error . "</p>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add System Admin</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-select.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <!-- JavaScript -->
  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>

  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
    padding: 0;
  }

  #top-navigation {
    width: 100%;
    height: 60px;
    background-color: green;
    color: white;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0 20px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  #student_name {
    font-size: 1.1em;
  }

  #left_side_bar {
    width: 250px;
    background-color: green;
    height: calc(100vh - 60px);
    position: fixed;
    top: 0px;
    /* Adjusted to sit below top nav */
    left: 0;
    overflow-y: auto;
    border-right: 1px solid #ddd;
  }

  #menu_list {
    list-style-type: none;
    padding: 10px 0;
  }

  .menu_items_list {
    padding: 10px 20px;
    font-size: 1em;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .menu_items_list:hover {
    background-color: #ddd;
    padding-left: 25px;
  }

  .menu_items_link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  #main_content {
    margin-left: 250px;
    margin-top: 60px;
    padding: 20px;
    min-height: calc(100vh - 60px);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Larger form styling */
  .form-container {
    background: #ffffff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    /* Increased max-width */
    text-align: center;
    animation: fadeIn 0.5s ease-in-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .form-container h2 {
    margin-bottom: 30px;
    /* Increased margin */
    color: #333;
    font-weight: 600;
    font-size: 2rem;
    /* Larger font-size */
    letter-spacing: 0.5px;
  }

  .form-container form {
    display: flex;
    flex-direction: column;
    gap: 25px;
    /* Increased gap */
  }

  .form-container .group {
    text-align: left;
  }

  .form-container .label {
    display: block;
    margin-bottom: 12px;
    /* Increased margin */
    font-size: 1.1rem;
    /* Larger font-size */
    color: #333;
    font-weight: 500;
  }

  .form-container .input {
    width: 100%;
    padding: 14px;
    /* Increased padding */
    border: 1px solid #ccc;
    border-radius: 6px;
    background: #f9f9f9;
    color: #333;
    font-size: 1.1rem;
    /* Larger font-size */
    outline: none;
    transition: all 0.3s ease;
  }

  .form-container .input:focus {
    border-color: #28a745;
    background: #fff;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.2);
  }

  .form-container .input::placeholder {
    color: #999;
  }

  .form-container .button {
    padding: 15px;
    /* Increased padding */
    border: none;
    background: linear-gradient(90deg, #28a745, #34c759);
    color: white;
    font-size: 1.1rem;
    /* Larger font-size */
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .form-container .button:hover {
    background: linear-gradient(90deg, #218838, #2ba84a);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
  }

  .form-container .button:active {
    transform: translateY(1px);
    box-shadow: none;
  }

  .form-container .message {
    margin-top: 25px;
    /* Increased margin */
    font-size: 1rem;
    /* Larger font-size */
    font-weight: 500;
  }

  @media (max-width: 768px) {
    #left_side_bar {
      width: 200px;
    }

    #main_content {
      margin-left: 200px;
    }
  }

  @media (max-width: 480px) {
    #left_side_bar {
      width: 100%;
      height: auto;
      position: relative;
      top: 0;
    }

    #main_content {
      margin-left: 0;
      margin-top: 0;
      padding: 20px;
    }

    .form-container {
      padding: 25px;
      max-width: 100%;
    }

    .form-container h2 {
      font-size: 1.7rem;
      /* Adjusted for smaller screens */
    }

    .form-container .input,
    .form-container .button {
      font-size: 1rem;
      /* Adjusted for smaller screens */
      padding: 12px;
    }
  }
  </style>
</head>

<body>
  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em> </span>
      <span style="font-family:serif">Admin</span>
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
      <a class="menu_items_link" href="../../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <!-- Main Content -->
  <div id="main_content">
    <div class="form-container">
      <h2>Add System Admin</h2>
      <form method="post" action="">
        <div class="group">
          <label for="username" class="label">Username</label>
          <input id="username" type="text" class="input" name="username" placeholder="Enter username" required>
        </div>
        <div class="group">
          <label for="password" class="label">Password</label>
          <input id="password" type="password" class="input" name="password" placeholder="Enter password" required>
        </div>
        <div class="group">
          <input type="submit" class="button" value="Add Admin" name="btn_add_admin">
        </div>
      </form>
      <div class="message">
        <?php echo $message; ?>
      </div>
    </div>
  </div>
</body>

</html>