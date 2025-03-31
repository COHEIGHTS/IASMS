<?php
include '../../database_connection/database_connection.php';

if (isset($_POST["btn_submit"])) {
    // Get user inputs from the form
    $username = trim($_POST["txt_username"]);
    $user_current_password = trim($_POST["txt_current_password"]);
    $user_new_password = trim($_POST["txt_new_password"]);
    $user_password_confirm = trim($_POST["txt_confirm_password"]);

    // Check if all fields are filled
    if (empty($username) || empty($user_current_password) || empty($user_new_password) || empty($user_password_confirm)) {
        echo "<script>alert('All fields are required.');</script>";
    } else {
        // Select the current hashed password from the 'system_admin' table for the given username
        $my_query_command = "SELECT password FROM `system_admin` WHERE username = ?";
        $stmt = $conn->prepare($my_query_command);
        
        if ($stmt === false) {
            echo "<script>alert('Prepare failed: " . $conn->error . "');</script>";
            exit();
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $fetch_row = $result->fetch_assoc();

        // Check if the user exists
        if ($fetch_row) {
            $stored_hash = $fetch_row['password'];

            // Debugging: Output the stored hash and verification result to console
            echo "<script>
                console.log('Stored Hash: " . addslashes($stored_hash) . "');
                console.log('Entered Password: " . addslashes($user_current_password) . "');
                console.log('Verification Result: " . (password_verify($user_current_password, $stored_hash) ? 'true' : 'false') . "');
            </script>";

            // Verify the current password
            if (password_verify($user_current_password, $stored_hash)) {
                // Check if new password matches the confirm password
                if ($user_new_password === $user_password_confirm) {
                    // Hash the new password
                    $new_hashed_password = password_hash($user_new_password, PASSWORD_DEFAULT);

                    // Update the password in the 'system_admin' table
                    $update_command = "UPDATE `system_admin` SET password = ? WHERE username = ?";
                    $update_stmt = $conn->prepare($update_command);
                    
                    if ($update_stmt === false) {
                        echo "<script>alert('Update prepare failed: " . $conn->error . "');</script>";
                        exit();
                    }

                    $update_stmt->bind_param("ss", $new_hashed_password, $username);
                    $execute_update_query = $update_stmt->execute();

                    // Check if the update query was successful
                    if ($execute_update_query) {
                        echo "<script>alert('Password has been updated successfully.');</script>";
                    } else {
                        echo "<script>alert('Error updating password: " . $update_stmt->error . "');</script>";
                    }

                    $update_stmt->close();
                } else {
                    echo "<script>alert('New password and confirm password do not match.');</script>";
                }
            } else {
                echo "<script>alert('Current password is incorrect.');</script>";
            }
        } else {
            echo "<script>alert('No user found with this username.');</script>";
        }

        $stmt->close();
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

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="change_password.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
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
      <a class="menu_items_link" href="../company_score/company_supervisor_score.php">
        <li class="menu_items_list">Company Supervisor Score</li>
      </a>
      <a class="menu_items_link" href="../../admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="../../logbook_report.php">
        <li class="menu_items_list">Logbook Report</li>
      </a>
      <a class="menu_items_link" href="change_password.php">
        <li style="background-color:orange;padding-left:16px" class="menu_items_list">Change Password</li>
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
        <div class="panel-heading industrial_phead">
          <h2 class="panel-title industrial_ptitle">Change Password</h2>
        </div>
        <div class="panel-body industrial_pbody">
          <div class="panel">
            <div class="panel-body">
              <form method="post" action="change_password.php">
                <div class="form-group">
                  <label for="txt_username">Username</label>
                  <input type="text" class="form-control form-control-adjusted" id="txt_username"
                    placeholder="Enter your username" name="txt_username" required>
                </div>
                <div class="form-group">
                  <label for="txt_current_password">Current Password</label>
                  <input type="password" class="form-control form-control-adjusted" id="txt_current_password"
                    placeholder="Enter current password" name="txt_current_password" required>
                </div>
                <div class="form-group">
                  <label for="txt_new_password">New Password</label>
                  <input type="password" class="form-control form-control-adjusted" id="txt_new_password"
                    placeholder="Enter new password" name="txt_new_password" required>
                </div>
                <div class="form-group">
                  <label for="txt_confirm_password">Confirm New Password</label>
                  <input type="password" class="form-control form-control-adjusted" id="txt_confirm_password"
                    placeholder="Confirm new password" name="txt_confirm_password" required>
                </div>
                <div id="btn_submit_holder">
                  <input type="submit" class="btn btn-primary" value="Submit" name="btn_submit" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>