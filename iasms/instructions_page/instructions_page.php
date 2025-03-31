<?php

include '../database_connection/database_connection.php';

// Safely retrieve cookie values with fallback
$student_fname = $_COOKIE["student_first_name"] ?? '';
$student_lname = $_COOKIE["student_last_name"] ?? '';
$student_index_number = $_COOKIE["student_index_number"] ?? '';

// Check for supervisor assignment in internal registration
$mysql_check_supervisor_assigned = "SELECT * FROM internal_registration WHERE index_number='$student_index_number' LIMIT 1";
$execute_check_supervisor_assigned = mysqli_query($conn, $mysql_check_supervisor_assigned);

if ($execute_check_supervisor_assigned && mysqli_num_rows($execute_check_supervisor_assigned) == 1) {
    $get_entire_results = mysqli_fetch_array($execute_check_supervisor_assigned);

    $student_faculty = $get_entire_results["faculty"];
    $student_company_region = $get_entire_results["attachment_region"];
    $student_visiting_supervisor_name = $get_entire_results["visiting_supervisor_name"];

    if ($student_company_region != "unassigned" && $student_visiting_supervisor_name != "unassigned") {
        $contains_data = "true";

        $get_supervisors_contact_query = "SELECT * FROM visiting_lecturers WHERE lecturer_faculty='$student_faculty' AND lecturer_name='$student_visiting_supervisor_name' LIMIT 1";
        $execute_get_supervisor_contact = mysqli_query($conn, $get_supervisors_contact_query);

        if ($execute_get_supervisor_contact && mysqli_num_rows($execute_get_supervisor_contact) == 1) {
            $get_supervisors_contact = mysqli_fetch_array($execute_get_supervisor_contact);
            $lecturers_contact = $get_supervisors_contact["lecturer_phone_number"];

            $assign_contact_to_student = "UPDATE `internal_registration` SET `visiting_supervisor_contact` = '$lecturers_contact' WHERE `index_number` = '$student_index_number'";
            mysqli_query($conn, $assign_contact_to_student);
        }
    } else {
        $contains_data = "false";
    }
} else {
    // Check the industrial registration if not found in internal
    $mysql_check_supervisor_assigned = "SELECT * FROM industrial_registration WHERE index_number='$student_index_number' LIMIT 1";
    $execute_check_supervisor_assigned = mysqli_query($conn, $mysql_check_supervisor_assigned);

    if ($execute_check_supervisor_assigned && mysqli_num_rows($execute_check_supervisor_assigned) == 1) {
        $get_entire_results = mysqli_fetch_array($execute_check_supervisor_assigned);
        $student_faculty = $get_entire_results["faculty"];
        $student_company_region = $get_entire_results["attachment_region"];
        $student_visiting_supervisor_name = $get_entire_results["visiting_supervisor_name"];

        if ($student_company_region != "unassigned" && $student_visiting_supervisor_name != "unassigned") {
            $contains_data = "true";

            $get_supervisors_contact_query = "SELECT * FROM visiting_lecturers WHERE lecturer_faculty='$student_faculty' AND lecturer_name='$student_visiting_supervisor_name' LIMIT 1";
            $execute_get_supervisor_contact = mysqli_query($conn, $get_supervisors_contact_query);

            if ($execute_get_supervisor_contact && mysqli_num_rows($execute_get_supervisor_contact) == 1) {
                $get_supervisors_contact = mysqli_fetch_array($execute_get_supervisor_contact);
                $lecturers_contact = $get_supervisors_contact["lecturer_phone_number"];

                $assign_contact_to_student = "UPDATE `industrial_registration` SET `visiting_supervisor_contact` = '$lecturers_contact' WHERE `index_number` = '$student_index_number'";
                mysqli_query($conn, $assign_contact_to_student);
            }
        } else {
            $contains_data = "false";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-pink">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EUIAMS</title>

  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <link rel="stylesheet" href="instructions_page.css" />

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


      <a class="menu_items_link" href="instructions_page.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Instructions</li>
      </a>
      <a class="menu_items_link" href="../view_position.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Available Attachment Positions
        </li>
      </a>
      <a class="menu_items_link" href="../Register_Page/register_page.php">
        <li class="menu_items_list">Register</li>
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

  <!-- Main Body Content -->
  <div id="main_content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 1</h4>
            </div>
            <div class="panel-body pbody">
              <span> Once you have logged in, click on <strong style="color:#2B3775">"Register"</strong> if you haven't
                registered yet for the industrial attachment.</span>
              <br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading pheading">
              <h4 class="panel-title ptitle">Step 2</h4>
            </div>
            <div class="panel-body pbody">
              <span>There are two (2) options, choose <strong style="color:#2B3775">INTERNAL REGISTRATION</strong> if
                you are interning in the University or <strong style="color:#2B3775">INDUSTRIAL</strong> if you are
                interning with a company of your choice.</span>
              <br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 3</h4>
            </div>
            <div class="panel-body pbody">
              <span>If you select <strong style="color:#2B3775">INTERNAL REGISTRATION</strong> in Step 2, you will be
                provided with a form to fill in your details. <strong style="color:#2B3775">VALIDATE</strong> your
                details before submitting the form.</span>
              <br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 4</h4>
            </div>
            <div class="panel-body pbody">
              <span>If you select <strong style="color:#2B3775">INDUSTRIAL</strong> in Step 2, you will be provided with
                a form to fill after which you should click on <strong style="color:#2B3775">SUBMIT</strong> to submit
                the form to the Liaison Office.</span>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading pheading">
              <h4 class="panel-title ptitle">Step 5</h4>
            </div>
            <div class="panel-body pbody">
              <span>After you have successfully submitted your registration details, click on <strong
                  style="color:#2B3775">Submit Assumption</strong> if you have not yet submitted your assumption
                form.</span>
              <br><br><br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading pheading">
              <h4 class="panel-title ptitle">Step 6</h4>
            </div>
            <div class="panel-body pbody">
              <span>Once you have clicked on <strong style="color:#2B3775">Submit Assumption</strong> in Step 5, a form
                will be provided for you to fill. After which you must click on <strong
                  style="color:#2B3775">SUBMIT</strong> to send it to the Liaison Office.</span>
              <br><br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 7</h4>
            </div>
            <div class="panel-body pbody">
              <span>You can also click <strong style="color:#2B3775">E-Logbook</strong> to record all activities
                throughout the day. Ensure you click on <strong style="color:#2B3775">SAVE</strong> after you are done
                to avoid losing your data.</span>
              <br><br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 8</h4>
            </div>
            <div class="panel-body pbody">
              <span>Clicking on <strong style="color:#2B3775">Company Supervisor</strong> will open a page where
                officials supervising interns can grade the student. Students can't access this page unless a <strong
                  style="color:#2B3775">Visiting Supervisor</strong> provides the password.</span>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading pheading">
              <h4 class="panel-title ptitle">Step 9</h4>
            </div>
            <div class="panel-body pbody">
              <span>Clicking on the <strong>Visiting Supervisors</strong> will allow you to be graded by the Supervisor
                appointed by the school. This page is not accessible by the student; only the visiting supervisor can
                log in with a password.</span>
              <br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading pheading">
              <h4 class="panel-title ptitle">Step 10</h4>
            </div>
            <div class="panel-body pbody">
              <span>Clicking on <strong>Submit Report</strong> enables you to submit your industrial attachment report
                to the Industrial Liaison Office directly without printing it out.</span>
              <br><br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 11</h4>
            </div>
            <div class="panel-body pbody">
              <span>Your password is one of the few things that secures your account. To change your password, click on
                <strong>Change Password</strong> and fill in your details.</span>
              <br><br>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="panel">
            <div class="panel-heading">
              <h4 class="panel-title ptitle">Step 12</h4>
            </div>
            <div class="panel-body pbody">
              <span>After completing all tasks in the online management system, it is advisable to log out. This will
                prevent unauthorized users from accessing your account.</span>
            </div>
          </div>
        </div>
      </div>


      <br>
      <br>
    </div>
  </div>

  <footer id="footer">
    <div class="container">
      <p class="text-muted">&copy; 2024 EUIAMS. All Rights Reserved.</p>
    </div>
  </footer>

  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>

</html>