<?php
require_once 'database_connection/database_connection.php';
require_once 'C:/Users/LE/Downloads/Industrial Attachment Management System (1)/Industrial Attachment Management System/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactManager {
    private $mail;
    private $conn;
    
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->mail = new PHPMailer(true);
        $this->configureMail();
    }
    
    private function configureMail() {
        try {
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'coheights254@gmail.com'; // System email
            $this->mail->Password = 'zzkkkhbhpascoyqf';
            $this->mail->SMTPSecure = 'tls';
            $this->mail->Port = 587;
            $this->mail->isHTML(true);
        } catch (Exception $e) {
            error_log("Mail configuration failed: " . $e->getMessage());
        }
    }
    
    public function sendContactEmail($name, $email, $message) {
        try {
            // Set the "From" as the system email
            $this->mail->setFrom('coheights254@gmail.com', 'Industrial Attachment System');
            // Set the "Reply-To" as the user's email
            $this->mail->addReplyTo($email, $name);
            // Send to admin email
            $this->mail->addAddress('collinsheights@gmail.com');
            
            $this->mail->Subject = 'New Contact Form Submission';
            $this->mail->Body = $this->createEmailBody($name, $email, $message);
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }
    
    private function createEmailBody($name, $email, $message) {
        return "<div style='font-family: Arial, sans-serif; padding: 20px;'>
            <h2 style='color: #333;'>New Contact Message</h2>
            <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Message:</strong></p>
            <p style='background: #f8f8f8; padding: 15px; border-radius: 5px;'>" 
            . nl2br(htmlspecialchars($message)) . "</p>
        </div>";
    }
    
    public function saveContact($name, $email, $message) {
        $name = mysqli_real_escape_string($this->conn, trim($name));
        $email = mysqli_real_escape_string($this->conn, trim($email));
        $message = mysqli_real_escape_string($this->conn, trim($message));
        
        $query = "INSERT INTO contact_us (name, email, message, created_at) 
                 VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $name, $email, $message);
        return $stmt->execute();
    }
}

$contactManager = new ContactManager($conn);
$messageStatus = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["btn_contact"])) {
    $name = filter_input(INPUT_POST, 'contact_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'contact_email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'contact_message', FILTER_SANITIZE_STRING);
    
    if (empty($name) || empty($email) || empty($message)) {
        $messageStatus = "<div class='alert error'>Please fill all required fields.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messageStatus = "<div class='alert error'>Invalid email format.</div>";
    } else {
        try {
            if ($contactManager->saveContact($name, $email, $message) && 
                $contactManager->sendContactEmail($name, $email, $message)) {
                $messageStatus = "<div class='alert success'>Message sent successfully!</div>";
            } else {
                $messageStatus = "<div class='alert error'>Failed to process your request.</div>";
            }
        } catch (Exception $e) {
            $messageStatus = "<div class='alert error'>An error occurred. Please try again later.</div>";
            error_log("Contact form error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | Industrial Attachment System</title>
  <style>
  :root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --success-color: #2ecc71;
    --error-color: #e74c3c;
    --background-color: #ecf0f1;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: var(--background-color);
    line-height: 1.6;
  }

  .container {
    max-width: 500px;
    margin: 40px auto;
    padding: 30px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  h2 {
    color: var(--primary-color);
    margin-bottom: 25px;
    text-align: center;
    font-weight: 600;
  }

  .form-group {
    margin-bottom: 20px;
  }

  label {
    display: block;
    margin-bottom: 8px;
    color: var(--primary-color);
    font-weight: 500;
  }

  input,
  textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }

  input:focus,
  textarea:focus {
    outline: none;
    border-color: var(--secondary-color);
  }

  textarea {
    min-height: 120px;
    resize: vertical;
  }

  button {
    width: 100%;
    padding: 12px;
    background: var(--secondary-color);
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  button:hover {
    background: #2980b9;
  }

  .alert {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 5px;
    text-align: center;
    font-weight: 500;
  }

  .success {
    background: var(--success-color);
    color: white;
  }

  .error {
    background: var(--error-color);
    color: white;
  }

  .back-link {
    display: block;
    text-align: center;
    color: var(--secondary-color);
    text-decoration: none;
    margin-top: 20px;
    font-weight: 500;
  }

  .back-link:hover {
    color: #2980b9;
    text-decoration: underline;
  }
  </style>
</head>

<body>
  <div class="container">
    <h2>Contact Us</h2>

    <?php if (!empty($messageStatus)) echo $messageStatus; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="contact_name">Full Name</label>
        <input type="text" id="contact_name" name="contact_name" required>
      </div>

      <div class="form-group">
        <label for="contact_email">Email Address</label>
        <input type="email" id="contact_email" name="contact_email" required>
      </div>

      <div class="form-group">
        <label for="contact_message">Your Message</label>
        <textarea id="contact_message" name="contact_message" required></textarea>
      </div>

      <button type="submit" name="btn_contact">Send Message</button>
    </form>

    <a href="index.php" class="back-link">← Return to Home</a>
  </div>

  <script>
  document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.getElementById('contact_email').value;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
      e.preventDefault();
      alert('Please enter a valid email address.');
      document.getElementById('contact_email').focus();
    }
  });
  </script>
</body>

</html>