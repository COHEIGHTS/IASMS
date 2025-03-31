<?php
include '../database_connection/database_connection.php';

$btn_update_status = "";
$btn_save_status = "";

$student_fname = $_COOKIE["student_first_name"] ?? '';
$student_lname = $_COOKIE["student_last_name"] ?? '';
$student_full_name = $student_fname . " " . $student_lname;
$student_index_number = $_COOKIE["student_index_number"] ?? '';

// Initialize holders for form data
$monday_job_assigned_holder = '';
$monday_skill_acquired_holder = '';
$tuesday_job_assigned_holder = '';
$tuesday_skill_acquired_holder = '';
$wednesday_job_assigned_holder = '';
$wednesday_skill_acquired_holder = '';
$thursday_job_assigned_holder = '';
$thursday_skill_acquired_holder = '';
$friday_job_assigned_holder = '';
$friday_skill_acquired_holder = '';

// Check if data exists for this student
$stmt = $conn->prepare("SELECT * FROM week9_table WHERE index_number = ?");
$stmt->bind_param("s", $student_index_number);
$stmt->execute();
$result = $stmt->get_result();

$is_existing_data = ($result->num_rows === 1);
$btn_update_status = $is_existing_data ? '' : 'disabled'; // '' means enabled, 'disabled' means disabled
$btn_save_status = $is_existing_data ? 'disabled' : '';

if ($is_existing_data) {
    $get_data = $result->fetch_assoc();
    $monday_job_assigned_holder = htmlspecialchars($get_data["monday_job_assigned"] ?? '');
    $monday_skill_acquired_holder = htmlspecialchars($get_data["monday_special_skill_acquired"] ?? '');
    $tuesday_job_assigned_holder = htmlspecialchars($get_data["tuesday_job_assigned"] ?? '');
    $tuesday_skill_acquired_holder = htmlspecialchars($get_data["tuesday_special_skill_acquired"] ?? '');
    $wednesday_job_assigned_holder = htmlspecialchars($get_data["wednesday_job_assigned"] ?? '');
    $wednesday_skill_acquired_holder = htmlspecialchars($get_data["wednesday_special_skill_acquired"] ?? '');
    $thursday_job_assigned_holder = htmlspecialchars($get_data["thursday_job_assigned"] ?? '');
    $thursday_skill_acquired_holder = htmlspecialchars($get_data["thursday_special_skill_acquired"] ?? '');
    $friday_job_assigned_holder = htmlspecialchars($get_data["friday_job_assigned"] ?? '');
    $friday_skill_acquired_holder = htmlspecialchars($get_data["friday_special_skill_acquired"] ?? '');
}

// Handle form submission
if (isset($_POST["btn_save"]) || isset($_POST["btn_update"])) {
    $monday_job_assigned = filter_input(INPUT_POST, "job_assigned_1", FILTER_SANITIZE_STRING) ?? '';
    $monday_skill_acquired = filter_input(INPUT_POST, "skill_acquired_1", FILTER_SANITIZE_STRING) ?? '';
    $tuesday_job_assigned = filter_input(INPUT_POST, "job_assigned_2", FILTER_SANITIZE_STRING) ?? '';
    $tuesday_skill_acquired = filter_input(INPUT_POST, "skill_acquired_2", FILTER_SANITIZE_STRING) ?? '';
    $wednesday_job_assigned = filter_input(INPUT_POST, "job_assigned_3", FILTER_SANITIZE_STRING) ?? '';
    $wednesday_skill_acquired = filter_input(INPUT_POST, "skill_acquired_3", FILTER_SANITIZE_STRING) ?? '';
    $thursday_job_assigned = filter_input(INPUT_POST, "job_assigned_4", FILTER_SANITIZE_STRING) ?? '';
    $thursday_skill_acquired = filter_input(INPUT_POST, "skill_acquired_4", FILTER_SANITIZE_STRING) ?? '';
    $friday_job_assigned = filter_input(INPUT_POST, "job_assigned_5", FILTER_SANITIZE_STRING) ?? '';
    $friday_skill_acquired = filter_input(INPUT_POST, "skill_acquired_5", FILTER_SANITIZE_STRING) ?? '';

    // Check if all fields are filled
    if (!empty($monday_job_assigned) && !empty($monday_skill_acquired) &&
        !empty($tuesday_job_assigned) && !empty($tuesday_skill_acquired) &&
        !empty($wednesday_job_assigned) && !empty($wednesday_skill_acquired) &&
        !empty($thursday_job_assigned) && !empty($thursday_skill_acquired) &&
        !empty($friday_job_assigned) && !empty($friday_skill_acquired)) {
        
        if (isset($_POST["btn_save"]) && !$is_existing_data) {
            // Insert new data
            $stmt = $conn->prepare("INSERT INTO week9_table (username, index_number, monday_job_assigned, monday_special_skill_acquired, tuesday_job_assigned, tuesday_special_skill_acquired, wednesday_job_assigned, wednesday_special_skill_acquired, thursday_job_assigned, thursday_special_skill_acquired, friday_job_assigned, friday_special_skill_acquired, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssssssssss", $student_full_name, $student_index_number, $monday_job_assigned, $monday_skill_acquired, $tuesday_job_assigned, $tuesday_skill_acquired, $wednesday_job_assigned, $wednesday_skill_acquired, $thursday_job_assigned, $thursday_skill_acquired, $friday_job_assigned, $friday_skill_acquired);

            if ($stmt->execute()) {
                echo "<script>alert('Data saved successfully.');</script>";
                $btn_save_status = 'disabled';
                $btn_update_status = '';
                // Update holders with submitted data
                $monday_job_assigned_holder = htmlspecialchars($monday_job_assigned);
                $monday_skill_acquired_holder = htmlspecialchars($monday_skill_acquired);
                $tuesday_job_assigned_holder = htmlspecialchars($tuesday_job_assigned);
                $tuesday_skill_acquired_holder = htmlspecialchars($tuesday_skill_acquired);
                $wednesday_job_assigned_holder = htmlspecialchars($wednesday_job_assigned);
                $wednesday_skill_acquired_holder = htmlspecialchars($wednesday_skill_acquired);
                $thursday_job_assigned_holder = htmlspecialchars($thursday_job_assigned);
                $thursday_skill_acquired_holder = htmlspecialchars($thursday_skill_acquired);
                $friday_job_assigned_holder = htmlspecialchars($friday_job_assigned);
                $friday_skill_acquired_holder = htmlspecialchars($friday_skill_acquired);
            } else {
                echo "<script>alert('Error saving data: " . addslashes($conn->error) . "');</script>";
            }
        } elseif (isset($_POST["btn_update"]) && $is_existing_data) {
            // Update existing data
            $stmt = $conn->prepare("UPDATE week9_table SET monday_job_assigned = ?, monday_special_skill_acquired = ?, tuesday_job_assigned = ?, tuesday_special_skill_acquired = ?, wednesday_job_assigned = ?, wednesday_special_skill_acquired = ?, thursday_job_assigned = ?, thursday_special_skill_acquired = ?, friday_job_assigned = ?, friday_special_skill_acquired = ? WHERE index_number = ?");
            $stmt->bind_param("sssssssssss", $monday_job_assigned, $monday_skill_acquired, $tuesday_job_assigned, $tuesday_skill_acquired, $wednesday_job_assigned, $wednesday_skill_acquired, $thursday_job_assigned, $thursday_skill_acquired, $friday_job_assigned, $friday_skill_acquired, $student_index_number);

            if ($stmt->execute()) {
                echo "<script>alert('Data updated successfully.');</script>";
                // Update holders with submitted data
                $monday_job_assigned_holder = htmlspecialchars($monday_job_assigned);
                $monday_skill_acquired_holder = htmlspecialchars($monday_skill_acquired);
                $tuesday_job_assigned_holder = htmlspecialchars($tuesday_job_assigned);
                $tuesday_skill_acquired_holder = htmlspecialchars($tuesday_skill_acquired);
                $wednesday_job_assigned_holder = htmlspecialchars($wednesday_job_assigned);
                $wednesday_skill_acquired_holder = htmlspecialchars($wednesday_skill_acquired);
                $thursday_job_assigned_holder = htmlspecialchars($thursday_job_assigned);
                $thursday_skill_acquired_holder = htmlspecialchars($thursday_skill_acquired);
                $friday_job_assigned_holder = htmlspecialchars($friday_job_assigned);
                $friday_skill_acquired_holder = htmlspecialchars($friday_skill_acquired);
            } else {
                echo "<script>alert('Error updating data: " . addslashes($conn->error) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('You need to fill all spaces.');</script>";
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
  <link rel="stylesheet" href="elogbook.css" />

  <script src="../js/jquery-3.1.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</head>

<body>

  <div id="top-navigation">
    <div id="student_name"><span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>  </span><span
        style="font-family:serif"><?php echo htmlspecialchars($student_fname . " " . $student_lname); ?></span></div>
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
      <a class="menu_items_link" href="elogbook.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">E-Logbook</li>
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
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle"> E-LogBook-Week 9</h2>
        </div>
        <div class="panel-body pbody">
          <div id="navigation_holder">
            <ul class="pager">
              <li class="previous"><a href="elogbook_week8.php">← Previous</a></li>
              <li class="next"><a href="elogbook_week10.php">Next →</a></li>
            </ul>
          </div>
          <div id="week_holder">
            <span style="font-size:1.3em;font-weight:bold;"></span>
          </div>
          <hr>
          <form method="post" action="">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style='text-align:center'>Day</th>
                  <th style='text-align:center'>Job Assigned To Student</th>
                  <th style='text-align:center'>Special Skill Acquired</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style='padding:20px;text-align:center'>Monday</td>
                  <td><textarea name='job_assigned_1'
                      class='form-control adjusted_text_area'><?php echo $monday_job_assigned_holder; ?></textarea></td>
                  <td><textarea name='skill_acquired_1'
                      class='form-control adjusted_text_area'><?php echo $monday_skill_acquired_holder; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td style='padding:20px;text-align:center'>Tuesday</td>
                  <td><textarea name='job_assigned_2'
                      class='form-control adjusted_text_area'><?php echo $tuesday_job_assigned_holder; ?></textarea>
                  </td>
                  <td><textarea name='skill_acquired_2'
                      class='form-control adjusted_text_area'><?php echo $tuesday_skill_acquired_holder; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td style='padding:20px;text-align:center'>Wednesday</td>
                  <td><textarea name='job_assigned_3'
                      class='form-control adjusted_text_area'><?php echo $wednesday_job_assigned_holder; ?></textarea>
                  </td>
                  <td><textarea name='skill_acquired_3'
                      class='form-control adjusted_text_area'><?php echo $wednesday_skill_acquired_holder; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td style='padding:20px;text-align:center'>Thursday</td>
                  <td><textarea name='job_assigned_4'
                      class='form-control adjusted_text_area'><?php echo $thursday_job_assigned_holder; ?></textarea>
                  </td>
                  <td><textarea name='skill_acquired_4'
                      class='form-control adjusted_text_area'><?php echo $thursday_skill_acquired_holder; ?></textarea>
                  </td>
                </tr>
                <tr>
                  <td style='padding:20px;text-align:center'>Friday</td>
                  <td><textarea name='job_assigned_5'
                      class='form-control adjusted_text_area'><?php echo $friday_job_assigned_holder; ?></textarea></td>
                  <td><textarea name='skill_acquired_5'
                      class='form-control adjusted_text_area'><?php echo $friday_skill_acquired_holder; ?></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
            <div id="buttons_holder">
              <input type="submit" value="Update" class="btn btn-primary" name="btn_update"
                <?php echo $btn_update_status; ?>>
              <input type="submit" value="Save" class="btn btn-primary" name="btn_save" <?php echo $btn_save_status; ?>>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>