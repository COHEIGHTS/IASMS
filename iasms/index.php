<?php
include 'database_connection/database_connection.php';
require 'C:\Users\LE\Downloads\Industrial Attachment Management System (1)\Industrial Attachment Management System\vendor\autoload.php'; // Adjust this path as per your project structure for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start(); // Start the session
if (!isset($_SESSION["wrong_password"])) {
    $_SESSION["wrong_password"] = ""; // Initialize the session variable
}

// Function to send account activation email using PHPMailer
function sendActivationEmail($email, $firstName, $activationLink) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'coheights254@gmail.com';
        $mail->Password = 'zzkkkhbhpascoyqf';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('no-reply@yourdomain.com', 'Egerton University ICT Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Account Activation';
        $mail->Body = "Hello $firstName,<br><br>Thank you for registering with  Industrial Attachment Management System. Please click the link below to activate your account:<br><br><a href='$activationLink'>$activationLink</a><br><br>Best regards,<br>Egerton University Team";

        $mail->send();
        showAlert('Activation email sent. Please check your email to activate your account.', 'green');
        return true;
    } catch (Exception $e) {
        showAlert('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo, 'red');
        return false;
    }
}

// Function to show styled alert messages
function showAlert($message, $color) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var msg = document.createElement('div');
                msg.style.backgroundColor = '$color';
                msg.style.color = 'white';
                msg.style.padding = '10px';
                msg.style.marginTop = '10px';
                msg.style.borderRadius = '5px';
                msg.style.position = 'fixed';
                msg.style.top = '10px';
                msg.style.left = '50%';
                msg.style.transform = 'translateX(-50%)';
                msg.style.zIndex = '1000';
                msg.textContent = '$message';
                document.body.prepend(msg);
                setTimeout(() => msg.remove(), 5000);
            });
          </script>";
}

// Handle Sign In process
if (isset($_POST["btn_signin"])) {
    $login_index_number = $_POST["txtusername"];
    $login_password = $_POST["txtpassword"];

    $check_user_existence = "SELECT * FROM registered_students WHERE index_number='$login_index_number' AND is_active=1 LIMIT 1";
    $run_query = mysqli_query($conn, $check_user_existence);
    $user_exist = mysqli_num_rows($run_query);

    if ($user_exist == 1) {
        $get_detail = mysqli_fetch_assoc($run_query);
        $stored_password = $get_detail["password"];

        if (password_verify($login_password, $stored_password)) {
            $user_first_name = $get_detail["first_name"];
            $user_last_name = $get_detail["last_name"];
            setcookie("student_first_name", $user_first_name, time() + (86400 * 30), "/");
            setcookie("student_last_name", $user_last_name, time() + (86400 * 30), "/");
            setcookie("student_index_number", $login_index_number, time() + (86400 * 30), "/");

            header("Location: instructions_page/instructions_page.php");
            exit;
        } else {
            $_SESSION["wrong_password"] = "Wrong Username or Password";
        }
    } else {
        $_SESSION["wrong_password"] = "Wrong Username or Password or Account not activated.";
    }
}

// Handle Sign Up process
if (isset($_POST["btn_signup"])) {
    $reg_first_name = isset($_POST["txt_signup_firstname"]) ? $_POST["txt_signup_firstname"] : '';
    $reg_last_name = isset($_POST["txt_signup_lastname"]) ? $_POST["txt_signup_lastname"] : '';
    $reg_index_number = isset($_POST["txt_signup_indexnumber"]) ? $_POST["txt_signup_indexnumber"] : '';
    $reg_password = isset($_POST["txt_signup_password"]) ? $_POST["txt_signup_password"] : '';
    $reg_email = isset($_POST["txt_signup_email"]) ? $_POST["txt_signup_email"] : '';

    $password_valid = strlen($reg_password) >= 6 &&
                      preg_match('/[a-z]/', $reg_password) &&
                      preg_match('/[A-Z]/', $reg_password) &&
                      preg_match('/[^a-zA-Z\d]/', $reg_password);

    if ($reg_first_name != "" && $reg_last_name != "" && $reg_index_number != "" && $reg_password != "" && $reg_email != "") {
        if ($password_valid) {
            $activation_token = bin2hex(random_bytes(16));
            $hashed_password = password_hash($reg_password, PASSWORD_DEFAULT);
            $insert_user = "INSERT INTO registered_students (first_name, last_name, index_number, email, password, is_active, activation_token) VALUES ('$reg_first_name', '$reg_last_name', '$reg_index_number', '$reg_email', '$hashed_password', 0, '$activation_token')";
            if (mysqli_query($conn, $insert_user)) {
                $activation_link = "http://localhost:3000/activate.php?token=$activation_token";
                $emailStatus = sendActivationEmail($reg_email, $reg_first_name, $activation_link);
                exit;
            } else {
                showAlert('Failed to register. Please try again later.', 'red');
            }
        } else {
            $message = "Password must be at least 6 characters long and contain at least one lowercase letter, one uppercase letter, and one special character.";
            showAlert($message, 'red');
        }
    } else {
        $fill_spaces_message = "Provide Details For All Spaces";
        showAlert($fill_spaces_message, 'red');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Industrial Attachment Management System - Login/Signup</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', Arial, sans-serif;
  }

  body {
    background: linear-gradient(135deg, #006605, #008a39);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow-x: hidden;
  }

  .login-wrap {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    overflow: hidden;
    padding: 20px;
  }

  .login-html {
    position: relative;
  }

  #text_holder {
    text-align: center;
    padding: 20px 0;
  }

  #text_holder h2 {
    font-size: 24px;
    font-weight: 600;
    color: #333;
  }

  #text_holder span {
    color: #f39c12;
  }

  .tab {
    width: 50%;
    text-align: center;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    background: #f5f5f5;
    color: #333;
    display: inline-block;
    transition: background 0.3s, color 0.3s;
  }

  .sign-in,
  .sign-up {
    display: none;
  }

  .sign-in:checked+.tab,
  .sign-up:checked+.tab {
    background: #f39c12;
    color: #fff;
  }

  .login-form {
    padding: 20px;
  }

  .sign-in-htm,
  .sign-up-htm {
    display: none;
  }

  .sign-in:checked~.login-form .sign-in-htm,
  .sign-up:checked~.login-form .sign-up-htm {
    display: block;
  }

  .group {
    margin-bottom: 20px;
  }

  .label {
    display: block;
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
  }

  .input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s;
  }

  .input:focus {
    border-color: #f39c12;
  }

  .password-container {
    position: relative;
  }

  .eye-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
    font-size: 18px;
  }

  .eye-icon:hover {
    color: #f39c12;
  }

  .button {
    width: 100%;
    padding: 12px;
    background: #f39c12;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
  }

  .button:hover {
    background: #e08b0e;
  }

  .check {
    margin-right: 5px;
  }

  .check+label {
    font-size: 14px;
    color: #666;
  }

  .hr {
    height: 1px;
    background: #ddd;
    margin: 20px 0;
  }

  .error_message_holder {
    text-align: center;
    color: #ff4444;
    font-size: 14px;
  }

  .group a {
    color: #26e2f7;
    text-decoration: none;
    font-size: 14px;
  }

  .group a:hover {
    text-decoration: underline;
  }

  @media (max-width: 480px) {
    .login-wrap {
      margin: 20px;
    }

    .tab {
      font-size: 16px;
    }

    .input,
    .button {
      font-size: 14px;
    }
  }
  </style>
</head>

<body>
  <div class="login-wrap">
    <div class="login-html">
      <div id="text_holder">
        <h2><span>INDUSTRIAL ATTACHMENT<br>MANAGEMENT SYSTEM</span></h2>
      </div>
      <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
      <label for="tab-1" class="tab">Sign In</label>
      <input id="tab-2" type="radio" name="tab" class="sign-up">
      <label for="tab-2" class="tab">Sign Up</label>
      <div class="login-form">
        <!-- Sign In Form -->
        <form method="post" action="">
          <div class="sign-in-htm">
            <div class="group">
              <label for="user" class="label">Registration Number</label>
              <input id="user" type="text" class="input" name="txtusername" required>
            </div>
            <div class="group">
              <label for="pass" class="label">Password</label>
              <div class="password-container">
                <input id="pass" type="password" class="input" name="txtpassword" required>
                <span class="eye-icon" onclick="togglePassword('pass')"><i class="fa fa-eye"></i></span>
              </div>
            </div>
            <div class="group">
              <input id="check" type="checkbox" class="check" checked>
              <label for="check">Keep me Signed in</label>
            </div>
            <div class="group">
              <input type="submit" class="button" value="Sign In" name="btn_signin" id="btn_signin">
            </div>
            <div class="group" style="text-align: center">
              <a href="admin/index.php">Administrator</a>
            </div>
            <div class="group" style="text-align: center">
              <a href="reset_request.html">Forgot Password?</a>
            </div>
            <div class="group" style="text-align: center">
              <a href="../contact_us.php">Contact Us</a>
            </div>
            <div class="hr"></div>
            <div class="error_message_holder">
              <span><?php echo isset($_SESSION["wrong_password"]) ? $_SESSION["wrong_password"] : ""; ?></span>
            </div>
          </div>
        </form>
        <!-- Sign Up Form -->
        <form method="post" action="">
          <div class="sign-up-htm">
            <div class="group">
              <label for="firstname" class="label">First Name</label>
              <input id="firstname" type="text" class="input" name="txt_signup_firstname" required>
            </div>
            <div class="group">
              <label for="lastname" class="label">Last Name</label>
              <input id="lastname" type="text" class="input" name="txt_signup_lastname" required>
            </div>
            <div class="group">
              <label for="index_number" class="label">Registration Number</label>
              <input id="index_number" type="text" class="input" name="txt_signup_indexnumber" required>
            </div>
            <div class="group">
              <label for="email" class="label">Email</label>
              <input id="email" type="email" class="input" name="txt_signup_email" required>
            </div>
            <div class="group">
              <label for="signup_pass" class="label">Password</label>
              <div class="password-container">
                <input id="signup_pass" type="password" class="input" name="txt_signup_password" required>
                <span class="eye-icon" onclick="togglePassword('signup_pass')"><i class="fa fa-eye"></i></span>
              </div>
            </div>
            <div class="group">
              <input type="submit" class="button" value="Sign Up" name="btn_signup" id="btn_signup">
            </div>
            <div class="hr"></div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  function togglePassword(id) {
    const input = document.getElementById(id);
    const icon = input.nextElementSibling.querySelector('i');
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = "password";
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
  </script>
</body>

</html>