<?php

include '../database_connection/database_connection.php';

$student_fname = $_COOKIE["student_first_name"];
$student_lname = $_COOKIE["student_last_name"];
$other_name_status = "";
$index_status = "";
$first_name_holder = $student_fname;
$last_name_holder = $student_lname;
$index_number_holder = $_COOKIE["student_index_number"];
$submit_status = "";

$programmes = array("-", "Computer Science", "Education", "Mechanical Engineering", "Electrical Engineering", "", "Actuarial Science", "Econ&Stat");

$faculties = array("-", "Science", "Education", "Engineering", "FASS", "Agriculture");

$sessions = array("-", "On-site", "Remote");

$levels = array("-", "2", "3", "4", "5");

if (isset($_POST["btn_submit"])) {
    if ($_POST["student_programme"] != "" && $_POST["student_level"] != "" && $_POST["student_session"] != "") {
        $other_name = $_POST["student_other_name"];
        $student_programme_selected = $_POST["student_programme"];
        $student_level_selected = $_POST["student_level"];
        $student_session_selected = $_POST["student_session"];
        $student_index = $_POST["txt_index_number"];
        $student_faculty = $_POST["student_faculty"];

        $check_user_existence = "SELECT * FROM internal_registration WHERE index_number='$student_index' LIMIT 1";
        $execute_check_existence = mysqli_query($conn, $check_user_existence);
        $check_user = mysqli_num_rows($execute_check_existence);
        if ($check_user == 1) {
            echo "<script>alert('Sorry You Have Registered Already')</script>";
        } else {
            $insert_details_command = "INSERT INTO internal_registration (`id`, `first_name`, `last_name`, `other_name`, `index_number`, `programme`, `level`, `session`,`faculty`,`date`) VALUES (NULL, '$student_fname', '$student_lname', '$other_name', '$student_index', '$student_programme_selected', '$student_level_selected', '$student_session_selected', '$student_faculty', CURRENT_TIMESTAMP)";
            if ($run_query = mysqli_query($conn, $insert_details_command)) {
                echo "<script>alert('Details Have Been Submitted Successfully')</script>";
            } else {
                echo "<script>alert('Details Not Submitted')</script>";
            }
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

  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-select.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <link rel="stylesheet" href="internal_and_industrial_registration.css" />

  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</head>

<body>
  <div id="top-navigation">

    <div id="student_name"><span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp; </span><span
        style="font-family:serif"><?php echo $student_fname." ".$student_lname;?></span></div>
  </div>

  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="../instructions_page/instructions_page.php">
        <li class="menu_items_list">Instructions</li>
      </a>
      <a class="menu_items_link" href="../view_position.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Available Attachment Positions
        </li>
      </a>
      <a class="menu_items_link" href="../Register_page/Register_page.php">
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

  <div id="main_content">
    <div class="container-fluid">
      <div class="panel">
        <div class="panel-heading vira_phead">
          <h2 class="panel-title vira_ptitle">Internal Attachment Registration</h2>
        </div>
        <div class="panel-body vira_pbody">
          <form method="post" action="">
            <div class="form-group">
              <label for="txtfname">First Name</label>
              <input type="text" class="form-control form-control-adjusted" id="txtfname" placeholder="Enter first name"
                disabled value="<?php echo $first_name_holder; ?>">
            </div>

            <div class="form-group">
              <label for="txtlname">Last Name</label>
              <input type="text" class="form-control form-control-adjusted" id="txtlname" placeholder="Enter last name"
                disabled value="<?php echo $last_name_holder; ?>">
            </div>

            <div class="form-group">
              <label for="txtothername">Other Name(s)</label>
              <input type="text" class="form-control form-control-adjusted" id="txtothername"
                placeholder="Enter other name(s)" name="student_other_name">
            </div>

            <div class="form-group">
              <label for="txtindexnumber">Index Number</label>
              <input type="text" class="form-control form-control-adjusted" id="txtindexnumber"
                placeholder="Enter index number" name="txt_index_number" value="<?php echo $index_number_holder; ?>">
            </div>

            <div class="form-group">
              <label for="selected_programme">Select Programme:</label>
              <select class="form-control form-control-adjusted" id="selected_programme" name="student_programme">
                <?php foreach ($programmes as $val) { echo "<option>".$val."</option>"; }; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="selected_level">Select Level:</label>
              <select class="form-control form-control-adjusted" id="selected_level" name="student_level">
                <?php foreach ($levels as $val) { echo "<option>".$val."</option>"; }; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="selected_session">Select Session:</label>
              <select class="form-control form-control-adjusted" id="selected_session" name="student_session">
                <?php foreach ($sessions as $val) { echo "<option>".$val."</option>"; }; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="selected_faculty">Select Faculty:</label>
              <select class="form-control form-control-adjusted" id="selected_faculty" name="student_faculty">
                <?php foreach ($faculties as $val) { echo "<option>".$val."</option>"; }; ?>
              </select>
            </div>

            <div id="btn_submit_holder">
              <input type="submit" class="btn btn-primary" value="Submit" name="btn_submit" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>