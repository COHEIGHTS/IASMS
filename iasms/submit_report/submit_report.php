<?php
include '../database_connection/database_connection.php';

$student_fname = $_COOKIE["student_first_name"];
$student_lname = $_COOKIE["student_last_name"];
$index_number_holder = $_COOKIE["student_index_number"];
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
  <link rel="stylesheet" href="submit_report.css" />

  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/jquery.form.min.js"></script>

</head>

<body>

  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
      <span style="font-family:serif"><?php echo $student_fname . " " . $student_lname; ?></span>
    </div>
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
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Submit Assumption</li>
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
        <div class="panel-heading industrial_phead">
          <h2 class="panel-title industrial_ptitle">Submit Report</h2>
        </div>
        <div class="panel-body industrial_pbody">
          <form method="POST" enctype="multipart/form-data" id="form" action="upload.php">
            <h1 style="text-align: center">Upload Report</h1>
            <input type="file" name="file[]" id="fileInput" multiple required>
            <input type="submit" value="Upload" id="sub-but">
            <h4 style="text-align: center"><strong style="color: #E13F41">Please Ensure That your report is in PDF
                format with your Registration number as its name before uploading it</strong></h4>
            <h4 style="text-align: center">Any work not in PDF format will be discarded</h4>

            <progress id="prog" max="100" value="0" style="display: none"></progress>
            <div id="amount_reached"></div>
          </form>
        </div>
      </div>
    </div>

    <script>
    $(document).ready(function() {
      $("#form").on('submit', function(e) {
        e.preventDefault();

        var valid = true;
        var files = $("#fileInput")[0].files;

        if (files.length === 0) {
          alert("No files selected.");
          return;
        }

        for (var i = 0; i < files.length; i++) {
          if (files[i].type !== 'application/pdf') {
            alert("Only PDF files are allowed.");
            valid = false;
            return false;
          }
        }

        if (!valid) {
          return;
        }

        $(this).ajaxSubmit({
          url: 'upload.php',
          beforeSend: function() {
            $("#prog").show();
            $("#prog").attr('value', '0');
          },
          uploadProgress: function(event, position, total, percentComplete) {
            $("#prog").attr('value', percentComplete);
            $('#sub-but').val(percentComplete + '%');
          },
          success: function(response) {
            $('#sub-but').val('Files Uploaded successfully!!');
            setTimeout(function() {
              $('#sub-but').val('Upload');
            }, 1000);
          },
          error: function(xhr, status, error) {
            alert("Upload failed. Please try again.");
          }
        });
      });
    });
    </script>

</body>

</html>