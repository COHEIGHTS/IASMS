<?php
include '../../database_connection/database_connection.php';

$mysql_query_1 = "SELECT * FROM students_assumption";

if (isset($_POST["btn_search"])) {
    $search_by = $_POST["filter-by"];
    $search_term = $_POST["txt_search_term"];

    if ($search_by != "" && $search_term != "") {
        switch ($search_by) {
            case 'First Name':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE first_name LIKE '%$search_term%'";
                break;
            case 'Last Name':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE last_name LIKE '%$search_term%'";
                break;
            case 'Registration Number':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE index_number LIKE '%$search_term%'";
                break;
            case 'Programme':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE programme LIKE '%$search_term%'";
                break;
            case 'Year':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE level LIKE '%$search_term%'";
                break;
            case 'Session':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE session LIKE '%$search_term%'";
                break;
            case 'Region':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE company_region LIKE '%$search_term%'";
                break;
            case 'Company':
                $mysql_query_1 = "SELECT * FROM students_assumption WHERE company_name LIKE '%$search_term%'";
                break;
            default:
                $mysql_query_1 = "SELECT * FROM students_assumption";
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EUIASMS</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="students_assumptions.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>

  <script>
  function printTable() {
    var printContent = document.getElementById("print-section").innerHTML;
    var originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
  }
  </script>

  <style>
  @media print {

    #top-navigation,
    #left_side_bar,
    .btn {
      display: none;
    }
  }
  </style>

</head>

<body>

  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp; </span>
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
      <a class="menu_items_link" href="students_assumptions.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Student Assumptions</li>
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
      <a class="menu_items_link" href="../company_score/company_supervisor_score.php">
        <li class="menu_items_list">Company Supervisor Score</li>
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

  <div class="container-fluid">
    <div id="main_content">
      <div class="panel">
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle">Students Assumption</h2>
        </div>
        <div class="panel-body pbody">
          <form method="post" action="">
            <div class="row">
              <div class="col-xs-5 col-xs-offset-6">
                <div class="input-group">
                  <div class="input-group-btn search-panel">
                    <select class="form-control search_by_side" name="filter-by">
                      <option>Filter By</option>
                      <option>First Name</option>
                      <option>Last Name</option>
                      <option>Registration Number</option>
                      <option>Programme</option>
                      <option>Year</option>
                      <option>Session</option>
                      <option>Region</option>
                      <option>Company</option>
                    </select>
                  </div>
                  <input type="text" class="form-control" name="txt_search_term" placeholder="Search term...">
                  <span class="input-group-btn">
                    <input type="submit" class="btn btn-primary" value="Search" name="btn_search">
                  </span>
                </div>
              </div>
            </div>
          </form>

          <br>
          <button class="btn btn-success" onclick="printTable()">Print</button>

          <div id="print-section">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="text-align:center">Student Name</th>
                  <th style="text-align:center">Registration Number</th>
                  <th style="text-align:center">Programme</th>
                  <th style="text-align:center">Year</th>
                  <th style="text-align:center">Session</th>
                  <th style="text-align:center">Supervisor Name</th>
                  <th style="text-align:center">Supervisor Contact</th>
                  <th style="text-align:center" width="5%">Supervisor E-mail</th>
                  <th style="text-align:center">Company Name</th>
                  <th style="text-align:center">Company Region</th>
                  <th style="text-align:center">Company Address</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $execute_result_query = mysqli_query($conn, $mysql_query_1);
                while ($row_set = mysqli_fetch_array($execute_result_query)) {
                    echo "<tr style='text-align:center;font-size:1.1em'>";
                    echo "<td>".$row_set["first_name"]."&nbsp;".$row_set["last_name"]."</td>";
                    echo "<td>".$row_set["index_number"]."</td>";
                    echo "<td>".$row_set["programme"]."</td>";
                    echo "<td>".$row_set["level"]."</td>";
                    echo "<td>".$row_set["session"]."</td>";
                    echo "<td>".$row_set["supervisor_name"]."</td>";
                    echo "<td>".$row_set["supervisor_contact"]."</td>";
                    echo "<td>".$row_set["supervisor_email"]."</td>";
                    echo "<td>".$row_set["company_name"]."</td>";
                    echo "<td>".$row_set["company_region"]."</td>";
                    echo "<td>".$row_set["company_address"]."</td>";
                    echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

</body>

</html>