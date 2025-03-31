<?php
include '../../database_connection/database_connection.php';

// Set the number of records per page
$records_per_page = 2;

// Get the current page number from URL, default to 1 if not set
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $records_per_page;

// Base queries
$mysql_query_1 = "SELECT * FROM internal_registration";
$mysql_query_2 = "SELECT * FROM industrial_registration";

// Handle search functionality
if (isset($_POST["btn_search"])) {
    $search_by = $_POST["filter-by"];
    $search_term = $_POST["txt_search_term"];

    if ($search_by != "" && $search_term != "" && $search_by != "Filter By") {
        switch ($search_by) {
            case 'First Name':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE first_name LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE first_name LIKE '%$search_term%'";
                break;
            case 'Last Name':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE last_name LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE last_name LIKE '%$search_term%'";
                break;
            case 'Registration Number':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE index_number LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE index_number LIKE '%$search_term%'";
                break;
            case 'Programme':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE programme LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE programme LIKE '%$search_term%'";
                break;
            case 'Year':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE level LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE level LIKE '%$search_term%'";
                break;
            case 'Session':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE session LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE session LIKE '%$search_term%'";
                break;
            case 'Score':
                $mysql_query_1 = "SELECT * FROM internal_registration WHERE company_supervisor_grade LIKE '%$search_term%'";
                $mysql_query_2 = "SELECT * FROM industrial_registration WHERE company_supervisor_grade LIKE '%$search_term%'";
                break;
            default:
                $mysql_query_1 = "SELECT * FROM internal_registration";
                $mysql_query_2 = "SELECT * FROM industrial_registration";
                break;
        }
    }
}

// Add LIMIT clause for pagination
$mysql_query_1 .= " LIMIT $start_from, $records_per_page";
$mysql_query_2 .= " LIMIT $start_from, $records_per_page";

// Count total records for pagination
$total_query_1 = "SELECT COUNT(*) FROM internal_registration" . (strpos($mysql_query_1, 'WHERE') ? strstr($mysql_query_1, 'WHERE') : '');
$total_query_2 = "SELECT COUNT(*) FROM industrial_registration" . (strpos($mysql_query_2, 'WHERE') ? strstr($mysql_query_2, 'WHERE') : '');

$total_result_1 = mysqli_query($conn, $total_query_1);
$total_result_2 = mysqli_query($conn, $total_query_2);

$total_rows_1 = mysqli_fetch_array($total_result_1)[0];
$total_rows_2 = mysqli_fetch_array($total_result_2)[0];
$total_rows = $total_rows_1 + $total_rows_2;

$total_pages = ceil($total_rows / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en" class="bg-pink">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EUIAMS</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="company_supervisor_score.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

  <script type="text/javascript">
  function printTable() {
    var divContents = document.getElementById("table-container").innerHTML;
    var a = window.open('', '', 'height=500, width=800');
    a.document.write('<html><head><title>Company Supervisors Score</title></head><body>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
  }
  </script>

  <style>
  .pagination {
    margin-top: 20px;
    justify-content: center;
  }

  .pagination .page-item.active .page-link {
    background-color: #f39c12;
    border-color: #f39c12;
  }

  .pagination .page-link {
    color: #f39c12;
  }

  .pagination .page-link:hover {
    color: #fff;
    background-color: #e67e22;
    border-color: #e67e22;
  }
  </style>
</head>

<body>

  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em> </span>
      <span style="font-family:serif"><?php echo "Admin"; ?></span>
    </div>
  </div>

  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="../view_registered_students/view_registered_students.php">
        <li class="menu_items_list">Registered Students</li>
      </a>
      <a class="menu_items_link" href="../../add_position.php">
        <li class="menu_items_list">Add Attachment Positions</li>
      </a>
      <a class="menu_items_link" href="../students_assumptions/students_assumptions.php">
        <li class="menu_items_list">Student Assumptions</li>
      </a>
      <a class="menu_items_link" href="../student_stat/student_stat.php">
        <li class="menu_items_list">Student Statistics</li>
      </a>
      <a class="menu_items_link" href="../../add_supervisor.php">
        <li class="menu_items_list">Add Supervisor</li>
      </a>
      <a class="menu_items_link" href="../visiting_score/visiting_supervisors_score.php">
        <li class="menu_items_list">Visiting Supervisors Score</li>
      </a>
      <a class="menu_items_link" href="company_supervisor_score.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Company Supervisor Score</li>
      </a>
      <a class="menu_items_link" href="../../admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="../../logbook_report.php">
        <li class="menu_items_list">Logbook Report</li>
      </a>
      <a class="menu_items_link" href="../change_password/change_password.php">
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
    <div class="container-fluid">
      <div class="panel">
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle">Company Supervisors Score</h2>
        </div>
        <div class="panel-body pbody">
          <form method="post" action="">
            <div class="container">
              <div class="row">
                <div class="col-xs-5 col-xs-offset-6">
                  <div class="input-group">
                    <div class="input-group-btn search-panel">
                      <select class="form-control search_by_side" name="filter-by">
                        <option value="Filter By">Filter By</option>
                        <option>First Name</option>
                        <option>Last Name</option>
                        <option>Registration Number</option>
                        <option>Programme</option>
                        <option>Year</option>
                        <option>Session</option>
                        <option>Score</option>
                      </select>
                    </div>
                    <input type="text" class="form-control" name="txt_search_term" placeholder="Search term...">
                    <span class="input-group-btn">
                      <input type="submit" class="btn btn-primary" value="Search" name="btn_search" id="btn_search">
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <br>

          <!-- Add Print Button -->
          <button class="btn btn-success" onclick="printTable()">Print</button>

          <div id="table-container">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="text-align:center">Student Name</th>
                  <th style="text-align:center">Registration Number</th>
                  <th style="text-align:center">Programme</th>
                  <th style="text-align:center">Year</th>
                  <th style="text-align:center">Session</th>
                  <th style="text-align:center">Registration Type</th>
                  <th style="text-align:center">Company Supervisor Name</th>
                  <th style="text-align:center">Company Supervisor Contact</th>
                  <th style="text-align:center">Score</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $execute_result_query = mysqli_query($conn, $mysql_query_1);
                while ($row_set = mysqli_fetch_array($execute_result_query)) {
                  echo "<tr style='text-align:center;font-size:1.1em'>";
                  echo "<td>" . $row_set["first_name"] . " " . $row_set["last_name"] . "</td>";
                  echo "<td>" . $row_set["index_number"] . "</td>";
                  echo "<td>" . $row_set["programme"] . "</td>";
                  echo "<td>" . $row_set["level"] . "</td>";
                  echo "<td>" . $row_set["session"] . "</td>";
                  echo "<td>Internal Registration</td>";
                  echo "<td>" . $row_set["company_supervisor_name"] . "</td>";
                  echo "<td>" . $row_set["company_supervisor_contact"] . "</td>";
                  echo "<td>" . $row_set["company_supervisor_grade"] . "</td>";
                  echo "</tr>";
                }

                $execute_result_query_2 = mysqli_query($conn, $mysql_query_2);
                while ($row_set_2 = mysqli_fetch_array($execute_result_query_2)) {
                  echo "<tr style='text-align:center;font-size:1.1em'>";
                  echo "<td>" . $row_set_2["first_name"] . " " . $row_set_2["last_name"] . "</td>";
                  echo "<td>" . $row_set_2["index_number"] . "</td>";
                  echo "<td>" . $row_set_2["programme"] . "</td>";
                  echo "<td>" . $row_set_2["level"] . "</td>";
                  echo "<td>" . $row_set_2["session"] . "</td>";
                  echo "<td>Industrial Registration</td>";
                  echo "<td>" . $row_set_2["company_supervisor_name"] . "</td>";
                  echo "<td>" . $row_set_2["company_supervisor_contact"] . "</td>";
                  echo "<td>" . $row_set_2["company_supervisor_grade"] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Controls -->
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo; Previous</span>
                </a>
              </li>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              </li>
              <?php endfor; ?>

              <?php if ($page < $total_pages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                  <span aria-hidden="true">Next &raquo;</span>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

</body>

</html>