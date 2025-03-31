<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\Users\LE\Desktop\EUIAMS\Industrial Attachment Management System (1)\Industrial Attachment Management System\vendor\autoload.php'; // Include PHPMailer autoload file
include 'database_connection/database_connection.php';

if (isset($_POST['btn_reset_request'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']); // Sanitize input
    $check_user_existence = "SELECT * FROM registered_students WHERE email='$email' LIMIT 1";
    $run_query = mysqli_query($conn, $check_user_existence);
    $user_exist = mysqli_num_rows($run_query);

    if ($user_exist == 1) {
        $token = bin2hex(random_bytes(32));
        date_default_timezone_set('Africa/Nairobi'); // Set timezone
        $created_at = date("Y-m-d H:i:s");
        $expires_at = date("Y-m-d H:i:s", strtotime($created_at . ' +5 minutes')); // Token expiration time

        // Check if a reset token already exists for this email
        $check_token_query = "SELECT reset_token_hash FROM registered_students WHERE email='$email'";
        $token_result = mysqli_query($conn, $check_token_query);
        $existing_token = mysqli_fetch_assoc($token_result)['reset_token_hash'];

        if ($existing_token) {
            // If a token exists, update it (no duplicate issue since we're not inserting a new row)
            $update_query = "UPDATE registered_students SET 
                             reset_token_hash='$token', 
                             reset_token_created_at='$created_at', 
                             reset_token_expires_at='$expires_at' 
                             WHERE email='$email'";
        } else {
            // If no token exists, this query will still work (though typically this case won't occur with your current logic)
            $update_query = "UPDATE registered_students SET 
                             reset_token_hash='$token', 
                             reset_token_created_at='$created_at', 
                             reset_token_expires_at='$expires_at' 
                             WHERE email='$email'";
        }

        if (mysqli_query($conn, $update_query)) {
            $reset_link = "http://localhost:3000/new_password.php?token=$token";

            $mail = new PHPMailer(true);
            try {
                // Server settings for sending email
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'coheights254@gmail.com'; // Your Gmail address
                $mail->Password = 'zzkkkhbhpascoyqf'; // Your Gmail app-specific password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('coheights254@gmail.com', 'Egerton University ICT Team');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "Hello,<br><br>We received a request to reset your password. Click the link below to reset your password:<br><br><a href=\"$reset_link\">$reset_link</a><br><br>If you did not request a password reset, please ignore this email.<br><br>Best regards,<br>Egerton University Team";

                $mail->send();
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var msg = document.createElement('div');
                            msg.classList.add('alert', 'alert-success');
                            msg.textContent = 'Password reset link sent to your email.';
                            document.body.prepend(msg);
                            setTimeout(function() {
                                window.location.href = 'index.php';
                            }, 3000);
                        });
                      </script>";
            } catch (Exception $e) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var msg = document.createElement('div');
                            msg.classList.add('alert', 'alert-danger');
                            msg.textContent = 'Failed to send reset link. Mailer Error: " . addslashes($mail->ErrorInfo) . "';
                            document.body.prepend(msg);
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var msg = document.createElement('div');
                        msg.classList.add('alert', 'alert-danger');
                        msg.textContent = 'Failed to process reset request: " . mysqli_error($conn) . "';
                        document.body.prepend(msg);
                    });
                  </script>";
        }
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var msg = document.createElement('div');
                    msg.classList.add('alert', 'alert-danger');
                    msg.textContent = 'Email not found.';
                    document.body.prepend(msg);
                });
              </script>";
    }
}
?>

<!-- Style for the alerts -->
<style>
.alert {
  width: 100%;
  max-width: 500px;
  padding: 15px;
  text-align: center;
  margin: 20px auto;
  border-radius: 5px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  font-size: 16px;
  transition: opacity 0.5s ease-in-out;
  position: fixed;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
}

.alert-success {
  background-color: #4CAF50;
  color: white;
}

.alert-danger {
  background-color: #f44336;
  color: white;
}

/* Slide-in animation for alert messages */
.alert {
  opacity: 0;
  transform: translate(-50%, -20px);
  animation: slideIn 0.5s forwards;
}

@keyframes slideIn {
  100% {
    opacity: 1;
    transform: translate(-50%, 0);
  }
}
</style>