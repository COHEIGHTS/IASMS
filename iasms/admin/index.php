<?php
include '../database_connection/database_connection.php';

// Check if database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["btn_login"])) {
    $username = trim($_POST["admin_username"]);
    $entered_password = trim($_POST["admin_password"]);
    
    if (empty($username) || empty($entered_password)) {
        echo "<script>alert('Please enter both username and password');</script>";
    } else {
        $sql = "SELECT * FROM system_admin WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo "<script>alert('Prepare failed: " . $conn->error . "');</script>";
        } else {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                
                $stored_hash = $admin['password'];
                $verify_result = password_verify($entered_password, $stored_hash);
                
                if ($verify_result) {
                    header("Location: view_registered_students/view_registered_students.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid username or password.');</script>";
                }
            } else {
                echo "<script>alert('Username not found in database.');</script>";
            }
            $stmt->close();
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
  <link rel="stylesheet" href="index.css" />

  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>

  <style>
  #password-strength {
    margin-top: 5px;
    font-size: 0.9em;
  }

  .weak {
    color: red;
  }

  .medium {
    color: orange;
  }

  .strong {
    color: green;
  }
  </style>
</head>

<body>
  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em> </span>
      <span style="font-family:serif">Admin</span>
    </div>
  </div>

  <div id="main_content">
    <div class="container-fluid">
      <div class="panel panel-adjusted">
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle">Login - Administrator</h2>
        </div>
        <form method="post" action="">
          <div class="panel-body pbody">
            <div class="panel">
              <div class="panel-body pbody_login_holder">
                <br>
                <div style="text-align:center;font-size:1.2em"><strong>ADMIN LOGIN</strong></div>
                <hr>
                <div style="margin-bottom: 15px">
                  <input type="text" class="form-control form-control-adjusted" id="admin_username"
                    name="admin_username" placeholder="Enter Username" required />
                </div>
                <div style="margin-bottom: 15px">
                  <input type="password" class="form-control form-control-adjusted" id="admin_password"
                    name="admin_password" placeholder="Enter Password" required />
                  <div id="password-strength"></div>
                </div>
                <div id="btn_login_holder" style="float: right">
                  <input type="submit" class="btn btn-primary" value="Login" id="btn_visiting_login" name="btn_login" />
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div style="margin-left: 35%">
      <span><a href="../index.php"><u>Go Back To Main Login</u></a></span>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    $('#admin_password').on('input', function() {
      let password = $(this).val();
      let strength = checkPasswordStrength(password);
      let strengthText = '';
      let strengthClass = '';

      if (password.length === 0) {
        strengthText = '';
      } else if (strength < 2) {
        strengthText = 'Weak';
        strengthClass = 'weak';
      } else if (strength < 4) {
        strengthText = 'Medium';
        strengthClass = 'medium';
      } else {
        strengthText = 'Strong';
        strengthClass = 'strong';
      }

      $('#password-strength').text('Password Strength: ' + strengthText).removeClass('weak medium strong')
        .addClass(strengthClass);
    });

    function checkPasswordStrength(password) {
      let strength = 0;
      if (password.length >= 8) strength++;
      if (/[A-Z]/.test(password)) strength++;
      if (/[0-9]/.test(password)) strength++;
      if (/[^A-Za-z0-9]/.test(password)) strength++;
      return strength;
    }
  });
  </script>
</body>

</html>