<?php
// Include database connection
include 'database_connection/database_connection.php';

// Fetch student name from cookies
$student_fname = $_COOKIE["student_first_name"];
$student_lname = $_COOKIE["student_last_name"];

if (isset($_GET['position_id'])) {
    $position_id = $_GET['position_id'];
    
    // Fetch position details to display
    $sql = "SELECT * FROM attachment_positions WHERE id = $position_id";
    $result = mysqli_query($conn, $sql);
    $position = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apply for Attachment Position</title>

  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-select.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <link rel="stylesheet" href="register_page.css" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>

  <style>
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
  }

  .container {
    max-width: 800px;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 50px;
  }

  h3 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    font-weight: bold;
  }

  p {
    color: #666;
    font-size: 16px;
    margin-bottom: 30px;
  }
  </style>
</head>

<body>

  <!-- Top Navigation Bar -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
      <span style="font-family:serif"><?php echo $student_fname . " " . $student_lname; ?></span>
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
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Register</li>
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
      </a>
      <a class="menu_items_link" href="../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <!-- Main Content -->
  <div id="main_content">
    <div class="container">
      <h3>Apply for Attachment Position: <?php echo $position['position_name']; ?></h3>
      <p><strong>Organization:</strong> <?php echo $position['organization_name']; ?></p>
      <p><strong>Application Email:</strong> <?php echo $position['organization_email']; ?></p>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #4CAF50; color: white;">
            <h5 class="modal-title" id="applicationModalLabel">Application Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="background-color: #e9f7e9;">
            <p>To apply for this position, send your application directly to the email of the organization:</p>
            <p><strong><?php echo $position['organization_email']; ?></strong></p>
          </div>
          <div class="modal-footer" style="background-color: #f1f1f1;">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Show modal on page load -->
  <script>
  $(document).ready(function() {
    $('#applicationModal').modal('show');
  });
  </script>

</body>

</html>