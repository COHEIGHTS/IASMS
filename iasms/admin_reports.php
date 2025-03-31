<?php
include 'database_connection/database_connection.php';

// Fetch reports from the database
$sql = "SELECT id, student_index, file_path, submission_date FROM reports ORDER BY submission_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - View Reports</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <link rel="stylesheet" href="../../css/main_page_style.css">

  <style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f7fa;
    color: #333;
    margin: 0;
    padding: 0;
  }

  /* Top Navigation */
  #top-navigation {
    background-color: green;
    padding: 10px;
    text-align: center;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    height: 50px;
    /* Explicit height */
  }

  #top-navigation #student_name {
    color: white;
    font-size: 1.2em;
  }

  /* Left Sidebar */
  #left_side_bar {
    position: fixed;
    top: 0px;
    /* Offset by top navigation height */
    left: 0;
    height: calc(100vh - 50px);
    /* Full height minus top nav */
    width: 220px;
    background-color: green;
    padding-top: 10px;
    overflow-y: auto;
    /* Enable scrolling */
    overflow-x: hidden;
    z-index: 999;
  }

  /* Sidebar Menu */
  #menu_list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .menu_items_link {
    color: white;
    text-decoration: none;
    display: block;
  }

  .menu_items_list {
    padding: 15px;
    border-bottom: 1px solid #444;
    cursor: pointer;
    white-space: nowrap;
    /* Prevent text wrapping */
  }

  .menu_items_list:hover {
    background-color: #555;
  }

  /* Main Content */
  .main-content {
    margin-left: 220px;
    padding: 80px 30px;
  }

  .container {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 900px;
  }

  h2 {
    font-weight: 700;
    color: #4CAF50;
    text-align: center;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th,
  td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
  }

  th {
    background: #003366;
    color: white;
  }

  tr:nth-child(even) {
    background: #f9f9f9;
  }

  .download-btn {
    text-decoration: none;
    background: #f39c12;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
  }

  .download-btn:hover {
    background: #e08e0b;
  }
  </style>
</head>

<body>

  <!-- Top Navigation Bar -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:orange;font-size:1.1em"><em>Welcome,</em> </span>
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

  <!-- Main Content Section -->
  <div class="main-content">
    <div class="container">
      <h2>Submitted Reports</h2>
      <table>
        <thead>
          <tr>
            <th>Student Index</th>
            <th>Report File</th>
            <th>Submission Date</th>
            <th>Download</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $file_path = "submit_report/uploads/" . basename($row['file_path']);
              if (file_exists($file_path)) {
                echo "<tr>
                          <td>{$row['student_index']}</td>
                          <td>" . basename($row['file_path']) . "</td>
                          <td>{$row['submission_date']}</td>
                          <td><a href='$file_path' class='download-btn' download><i class='fa fa-download'></i> Download</a></td>
                      </tr>";
              } else {
                echo "<tr>
                          <td>{$row['student_index']}</td>
                          <td>" . basename($row['file_path']) . "</td>
                          <td>{$row['submission_date']}</td>
                          <td style='color: red;'>File Not Found</td>
                      </tr>";
              }
            }
          } else {
            echo "<tr><td colspan='4' style='text-align: center; color: red;'>No reports submitted yet.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>