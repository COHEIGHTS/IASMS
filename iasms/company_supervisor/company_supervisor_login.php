<?php
include '../database_connection/database_connection.php';

$student_fname = $_COOKIE["student_first_name"];
$student_lname = $_COOKIE["student_last_name"];

if (isset($_POST["btn_login"])) {
    if ($_POST["txtcompany_supervisor_password"] != "") {
        $supervisors_password = $_POST["txtcompany_supervisor_password"];

        // Fetch supervisor details from the database by username
        $supervisor_login_details = "SELECT * FROM supervisors_login WHERE status = 'Company' AND username = ?";
        $stmt = $conn->prepare($supervisor_login_details);
        $stmt->bind_param("s", $_POST['username']); // Assuming you're sending a username too
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if supervisor exists
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Use password_verify to compare the entered password with the stored hashed password
            if (password_verify($supervisors_password, $row['password'])) {
                // Successful login, redirect to company supervisor grade page
                header("Location: company_supervisor_grade.php");
                exit();
            } else {
                echo "<script>alert('Invalid credentials or you are not a Company Supervisor.');</script>";
            }
        } else {
            echo "<script>alert('Supervisor not found.');</script>";
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
  <title>EUIAMS</title>

  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-select.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <link rel="stylesheet" href="company_supervisor.css" />

  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>

</head>

<body>

  <div id="top-navigation">
    <div id="student_name"><span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp; </span><span
        style="font-family:serif"><?php echo $student_fname . " " . $student_lname; ?></span></div>
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
        <li class="menu_items_list">Register</li>
      </a>
      <a class="menu_items_link" href="../student_assumption/student_assumption.php">
        <li class="menu_items_list">Submit Assumption</li>
      </a>
      <a class="menu_items_link" href="../e-logbook/elogbook.php">
        <li class="menu_items_list">E-Logbook</li>
      </a>
      <a class="menu_items_link" href="company_supervisor_login.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Company Supervisor</li>
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
        <form method="post" action="">
          <div class="panel-heading phead">
            <h2 class="panel-title ptitle">Login - Company Supervisor</h2>
          </div>
          <div class="panel-body pbody">
            <div class="panel">
              <div class="panel-body pbody_login_holder">
                <br>
                <div style="text-align:center;font-size:1.2em"><strong>PASSWORD</strong></div>
                <hr>
                <input type="text" class="form-control form-control-adjusted" id="username" name="username"
                  placeholder="Enter Username" required /><br>
                <input type="password" class="form-control form-control-adjusted" id="txtcompany_supervisor_password"
                  name="txtcompany_supervisor_password" placeholder="Enter Password" /><br>
                <div id="btn_login_holder">
                  <input type="submit" class="btn btn-primary" value="Login" id="btn_supervisor_login"
                    name="btn_login" />
                </div>

              </div>
              </panel>
            </div>
          </div>
        </form>
      </div>
    </div>
</body>

</html>