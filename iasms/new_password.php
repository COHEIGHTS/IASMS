<?php
// Include necessary files
require_once 'C:\Users\LE\Desktop\EUIAMS\Industrial Attachment Management System (1)\Industrial Attachment Management System\vendor\autoload.php'; // PHPMailer autoload
require_once 'database_connection/database_connection.php'; // Database connection script

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$password = "";
$password_confirm = "";
$errors = array();

// Validate and process form submission
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and is valid
    $check_token_query = "SELECT * FROM registered_students WHERE reset_token_hash='$token' AND reset_token_expires_at > NOW()";
    $result = mysqli_query($conn, $check_token_query);

    if (mysqli_num_rows($result) == 1) {
        // Token is valid, allow password reset
        if (isset($_POST['btn_reset'])) {
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);

            // Password validation
            if (strlen($password) < 6) {
                $errors[] = "Password must be at least 6 characters long.";
            }
            if (!preg_match("#[0-9]+#", $password)) {
                $errors[] = "Password must include at least one number.";
            }
            if (!preg_match("#[A-Z]+#", $password)) {
                $errors[] = "Password must include at least one uppercase letter.";
            }
            if (!preg_match("#[a-z]+#", $password)) {
                $errors[] = "Password must include at least one lowercase letter.";
            }
            if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
  $errors[] = "Password must include at least one special character.";
  }
  if ($password !== $password_confirm) {
  $errors[] = "Passwords do not match.";
  }

  // If no errors, proceed to update password
  if (empty($errors)) {
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // Update password and clear reset token
  $update_query = "UPDATE registered_students SET password='$password_hash', reset_token_hash=NULL,
  reset_token_expires_at=NULL WHERE reset_token_hash='$token'";
  if (mysqli_query($conn, $update_query)) {
  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
    var msg = document.createElement('div');
    msg.classList.add('alert', 'alert-success');
    msg.textContent = 'Password reset successfully. Please login with your new password.';
    document.body.prepend(msg);
    setTimeout(function() {
      window.location.href = 'index.php';
    }, 3000);
  });
  </script>";
  exit();
  } else {
  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
    var msg = document.createElement('div');
    msg.classList.add('alert', 'alert-danger');
    msg.textContent = 'Failed to update password. Please try again later.';
    document.body.prepend(msg);
    setTimeout(function() {
      window.location.href = 'index.php';
    }, 3000);
  });
  </script>";
  exit();
  }
  }
  }
  } else {
  // Invalid or expired token
  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
    var msg = document.createElement('div');
    msg.classList.add('alert', 'alert-danger');
    msg.textContent = 'Invalid or expired reset token.';
    document.body.prepend(msg);
    setTimeout(function() {
      window.location.href = 'index.php';
    }, 3000);
  });
  </script>";
  exit();
  }
  } else {
  // Token not provided
  echo "<script>
  document.addEventListener('DOMContentLoaded', function() {
    var msg = document.createElement('div');
    msg.classList.add('alert', 'alert-danger');
    msg.textContent = 'Token not provided.';
    document.body.prepend(msg);
    setTimeout(function() {
      window.location.href = 'index.php';
    }, 3000);
  });
  </script>";
  exit();
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Industrial Attachment Management System</title>
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
      padding: 20px;
    }

    .reset-container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 450px;
      padding: 40px;
      text-align: center;
    }

    .reset-container h2 {
      font-size: 28px;
      font-weight: 600;
      color: #333;
      margin-bottom: 20px;
    }

    .reset-container form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-group {
      position: relative;
      text-align: left;
    }

    .form-group label {
      font-size: 14px;
      font-weight: 500;
      color: #666;
      margin-bottom: 8px;
      display: block;
    }

    .form-group input[type="password"] {
      width: 100%;
      padding: 12px 40px 12px 12px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
      outline: none;
      transition: border-color 0.3s;
      background: #f9f9f9;
    }

    .form-group input:focus {
      border-color: #f39c12;
    }

    .password-toggle {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #999;
      font-size: 18px;
    }

    .toggle-password:hover {
      color: #f39c12;
    }

    .error {
      background: #ffe6e6;
      color: #d32f2f;
      padding: 10px;
      border-radius: 5px;
      font-size: 14px;
      margin-bottom: 15px;
    }

    .error p {
      margin: 5px 0;
    }

    button[type="submit"] {
      background: #f39c12;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s;
    }

    button[type="submit"]:hover {
      background: #e08b0e;
    }

    .alert {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      padding: 15px;
      border-radius: 5px;
      font-size: 16px;
      z-index: 1000;
      width: 90%;
      max-width: 500px;
      animation: slideIn 0.5s ease-in-out;
    }

    .alert-success {
      background: #4CAF50;
      color: #fff;
    }

    .alert-danger {
      background: #f44336;
      color: #fff;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translate(-50%, -20px);
      }

      to {
        opacity: 1;
        transform: translate(-50%, 0);
      }
    }

    @media (max-width: 480px) {
      .reset-container {
        padding: 20px;
      }

      .reset-container h2 {
        font-size: 24px;
      }

      .form-group input[type="password"],
      button[type="submit"] {
        font-size: 14px;
      }
    }
    </style>
  </head>

  <body>
    <div class="reset-container">
      <h2>Reset Your Password</h2>
      <form method="POST" action="">
        <div class="form-group">
          <label for="password">New Password</label>
          <div class="password-toggle">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword('password')"><i class="fa fa-eye"></i></span>
          </div>
        </div>
        <div class="form-group">
          <label for="password_confirm">Confirm New Password</label>
          <div class="password-toggle">
            <input type="password" id="password_confirm" name="password_confirm" required>
            <span class="toggle-password" onclick="togglePassword('password_confirm')"><i class="fa fa-eye"></i></span>
          </div>
        </div>
        <?php if (!empty($errors)): ?>
        <div class="error">
          <?php foreach ($errors as $error): ?>
          <p><?php echo $error; ?></p>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <button type="submit" name="btn_reset">Reset Password</button>
      </form>
    </div>

    <script>
    function togglePassword(inputId) {
      const input = document.getElementById(inputId);
      const icon = input.nextElementSibling.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
    </script>
  </body>

  </html>