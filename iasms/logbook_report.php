<?php
// Include database connection
include 'database_connection/database_connection.php';

// Get the selected week from the form (default to Week 1 if not set)
$week_number = isset($_GET['week']) ? intval($_GET['week']) : 1;
$table_name = "week" . $week_number . "_table"; // Dynamically set table name

// Check if the table exists before querying
$check_table = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($check_table) == 0) {
    die("<div class='alert alert-danger text-center'>Error: Table for Week $week_number does not exist!</div>");
}

// Pagination settings
$records_per_page = 3;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$start_from = ($page - 1) * $records_per_page;

// Fetch total number of records for pagination
$total_query = "SELECT COUNT(*) FROM $table_name";
$total_result = mysqli_query($conn, $total_query);
$total_rows = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_rows / $records_per_page);

// Fetch data from the selected week's table with pagination
$sql = "SELECT * FROM $table_name ORDER BY date ASC LIMIT $start_from, $records_per_page";
$result = mysqli_query($conn, $sql);

// Check if the export to Excel button is clicked
if (isset($_POST['export'])) {
    $filename = "Week_{$week_number}_Logbook_Report.xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo "Username\tIndex Number\tMonday Job\tMonday Skill\tTuesday Job\tTuesday Skill\tWednesday Job\tWednesday Skill\tThursday Job\tThursday Skill\tFriday Job\tFriday Skill\n";
    $export_sql = "SELECT * FROM $table_name ORDER BY date ASC"; // Export all records, not paginated
    $export_result = mysqli_query($conn, $export_sql);
    if (mysqli_num_rows($export_result) > 0) {
        while ($row = mysqli_fetch_assoc($export_result)) {
            echo htmlspecialchars("{$row['username']}\t{$row['index_number']}\t{$row['monday_job_assigned']}\t{$row['monday_special_skill_acquired']}\t");
            echo htmlspecialchars("{$row['tuesday_job_assigned']}\t{$row['tuesday_special_skill_acquired']}\t{$row['wednesday_job_assigned']}\t{$row['wednesday_special_skill_acquired']}\t");
            echo htmlspecialchars("{$row['thursday_job_assigned']}\t{$row['thursday_special_skill_acquired']}\t{$row['friday_job_assigned']}\t{$row['friday_special_skill_acquired']}\n");
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EUIAMS - Week <?php echo $week_number; ?> Logbook Report</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Main Page Style (for top and left navigation) -->
  <link rel="stylesheet" href="css/main_page_style.css" />
  <!-- Google Fonts for main content -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <style>
  body {
    font-family: 'Roboto', sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    /* Prevent horizontal scrolling */
  }

  /* Top Navigation */
  #top-navigation {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgb(0, 102, 14);
    color: white;
    padding: 15px;
    z-index: 1000;
  }

  #student_name span {
    font-size: 1.1em;
  }

  #student_name span:first-child {
    color: rgb(255, 198, 0);
  }

  /* Left Sidebar */
  #left_side_bar {
    position: fixed;
    top: 0px;
    /* Adjust based on top navigation height */
    left: 0;
    width: 220px;
    /* Fixed width */
    height: calc(100vh - 60px);
    /* Full height minus top navigation */
    background: green;
    box-shadow: green;
    z-index: 999;
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
    color: #fff;
  }

  .menu_items_link {
    text-decoration: none;
    color: inherit;
    display: block;
  }

  /* Main Content */
  #main_content {
    margin-left: 240px;
    /* Increased to account for sidebar width + padding */
    padding: 80px 30px 30px;
    /* Top padding matches top navigation height */
    min-height: 100vh;
    width: calc(100% - 240px);
    /* Ensure it fits beside sidebar */
  }

  .container {
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  h2,
  h3 {
    color: #003366;
    font-weight: 700;
  }

  .form-select,
  .btn {
    border-radius: 6px;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .btn-primary {
    background: #f39c12;
    border: none;
  }

  .btn-primary:hover {
    background: #e67e22;
  }

  .btn-success {
    background: #28a745;
    border: none;
  }

  .btn-success:hover {
    background: #218838;
  }

  .table-responsive {
    margin-top: 20px;
    overflow-x: auto;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
  }

  .table th {
    background: #003366;
    color: #fff;
    font-weight: 600;
    padding: 12px;
    text-align: center;
  }

  .table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
  }

  .table tr:nth-child(even) {
    background: #f9f9f9;
  }

  .table tr:hover {
    background: #f1f1f1;
  }

  .alert {
    margin: 20px 0;
  }

  .back-btn {
    margin-top: 20px;
    text-align: center;
  }

  /* Pagination Styling */
  .pagination {
    margin-top: 20px;
    justify-content: center;
  }

  .pagination .page-item.active .page-link {
    background-color: #f39c12;
    border-color: #f39c12;
    color: #fff;
  }

  .pagination .page-link {
    color: #f39c12;
    border-radius: 4px;
    margin: 0 2px;
  }

  .pagination .page-link:hover {
    background-color: #e67e22;
    color: #fff;
    border-color: #e67e22;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    #left_side_bar {
      width: 200px;
      /* Slightly narrower sidebar */
    }

    #main_content {
      margin-left: 220px;
      /* Adjusted for narrower sidebar */
      width: calc(100% - 220px);
      padding: 70px 15px;
    }
  }

  @media (max-width: 576px) {
    #left_side_bar {
      position: static;
      /* Sidebar becomes static on small screens */
      width: 100%;
      height: auto;
    }

    #main_content {
      margin-left: 0;
      /* No margin when sidebar is not fixed */
      width: 100%;
      padding: 20px;
    }
  }
  </style>
</head>

<body>

  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span><em>Welcome,</em></span>
      <span><?php echo "Admin"; ?></span>
    </div>
  </div>

  <!-- Left Sidebar -->
  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="admin/view_registered_students/view_registered_students.php">
        <li class="menu_items_list">Registered Students</li>
      </a>
      <a class="menu_items_link" href="add_position.php">
        <li class="menu_items_list">Add Attachment Positions</li>
      </a>
      <a class="menu_items_link" href="admin/students_assumptions/students_assumptions.php">
        <li class="menu_items_list">Student Assumptions</li>
      </a>
      <a class="menu_items_link" href="admin/student_stat/student_stat.php">
        <li class="menu_items_list">Student Statistics</li>
      </a>
      <a class="menu_items_link" href="add_supervisor.php">
        <li class="menu_items_list">Add Supervisor</li>
      </a>
      <a class="menu_items_link" href="admin/visiting_score/visiting_supervisors_score.php">
        <li class="menu_items_list">Visiting Supervisors Score</li>
      </a>
      <a class="menu_items_link" href="admin/company_score/company_supervisor_score.php">
        <li class="menu_items_list">Company Supervisor Score</li>
      </a>
      <a class="menu_items_link" href="admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="logbook_report.php">
        <li class="menu_items_list" style="background-color:orange;">Logbook Report</li>
      </a>
      <a class="menu_items_link" href="admin/change_password/change_password.php">
        <li class="menu_items_list">Change Password</li>
      </a>
      <a class="menu_items_link" href="../../add_admin.php">
        <li class="menu_items_list">Add Admin</li>
      </a>
      <a class="menu_items_link" href="index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <!-- Main Content -->
  <div id="main_content">
    <div class="container">
      <h2 class="text-center">Weekly Logbook Report</h2>

      <!-- Form to select the week -->
      <form method="GET" class="text-center mb-4">
        <label for="week" class="form-label fw-bold">Choose Week:</label>
        <select name="week" id="week" class="form-select d-inline-block w-auto">
          <?php for ($i = 1; $i <= 10; $i++) { ?>
          <option value="<?php echo $i; ?>" <?php echo ($week_number == $i) ? 'selected' : ''; ?>>
            Week <?php echo $i; ?>
          </option>
          <?php } ?>
        </select>
        <button type="submit" class="btn btn-primary ms-2">View Report</button>
        <!-- Preserve page parameter if set -->
        <?php if (isset($_GET['page'])) { ?>
        <input type="hidden" name="page" value="<?php echo htmlspecialchars($page); ?>">
        <?php } ?>
      </form>

      <!-- Export to Excel Button -->
      <div class="text-center mb-4">
        <form method="POST">
          <button type="submit" name="export" class="btn btn-success">Export to Excel</button>
        </form>
      </div>

      <h3 class="text-center">Week <?php echo $week_number; ?> Report</h3>

      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Username</th>
              <th>Index Number</th>
              <th>Monday Job</th>
              <th>Monday Skill</th>
              <th>Tuesday Job</th>
              <th>Tuesday Skill</th>
              <th>Wednesday Job</th>
              <th>Wednesday Skill</th>
              <th>Thursday Job</th>
              <th>Thursday Skill</th>
              <th>Friday Job</th>
              <th>Friday Skill</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo htmlspecialchars($row['username'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['index_number'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['monday_job_assigned'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['monday_special_skill_acquired'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['tuesday_job_assigned'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['tuesday_special_skill_acquired'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['wednesday_job_assigned'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['wednesday_special_skill_acquired'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['thursday_job_assigned'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['thursday_special_skill_acquired'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['friday_job_assigned'] ?? 'N/A'); ?></td>
              <td><?php echo htmlspecialchars($row['friday_special_skill_acquired'] ?? 'N/A'); ?></td>
            </tr>
            <?php } 
            } else { ?>
            <tr>
              <td colspan="12" class="text-center text-danger fw-bold">No records found for Week
                <?php echo $week_number; ?>.</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination Controls -->
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?week=<?php echo $week_number; ?>&page=<?php echo $page - 1; ?>"
              aria-label="Previous">
              <span aria-hidden="true">« Previous</span>
            </a>
          </li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
            <a class="page-link" href="?week=<?php echo $week_number; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
          <?php endfor; ?>

          <?php if ($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?week=<?php echo $week_number; ?>&page=<?php echo $page + 1; ?>"
              aria-label="Next">
              <span aria-hidden="true">Next »</span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>

      <!-- Back to Dashboard Button -->
      <div class="back-btn">
        <a href="admin/view_registered_students/view_registered_students.php" class="btn btn-primary">Back to
          Dashboard</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>