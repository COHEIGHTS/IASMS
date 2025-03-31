<?php
// Include database connection
include 'database_connection/database_connection.php';

// Initialize variables for feedback
$message = "";

// Handle form submission
if (isset($_POST['btn_add_admin'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validation
    if (empty($username) || empty($password)) {
        $message = "<p style='color: red;'>Please fill in all fields.</p>";
    } elseif (stripos($username, 'admin') === false) {
        $message = "<p style='color: red;'>Username must contain 'admin'.</p>";
    } else {
        // Check password strength (server-side fallback)
        $strength_check = checkPasswordStrength($password);
        if ($strength_check['is_strong']) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the insert query
            $sql = "INSERT INTO system_admin (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $message = "<p style='color: green;'>Admin added successfully!</p>";
            } else {
                $message = "<p style='color: red;'>Error adding admin: " . $conn->error . "</p>";
            }

            $stmt->close();
        } else {
            $message = "<p style='color: red;'>Password must be strong: at least 8 characters, with uppercase, lowercase, numbers, and special characters.</p>";
        }
    }
}

// Function to check password strength (server-side)
function checkPasswordStrength($password) {
    return [
        'length' => strlen($password) >= 8,
        'uppercase' => preg_match('/[A-Z]/', $password),
        'lowercase' => preg_match('/[a-z]/', $password),
        'number' => preg_match('/[0-9]/', $password),
        'special' => preg_match('/[^A-Za-z0-9]/', $password),
        'is_strong' => (strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && 
                        preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password) && 
                        preg_match('/[^A-Za-z0-9]/', $password))
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add System Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/bootstrap-select.css" />
  <link rel="stylesheet" href="../css/main_page_style.css" />
  <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>

  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: #f4f7fa;
    min-height: 100vh;
  }

  #top-navigation {
    width: 100%;
    height: 60px;
    background-color: green;
    /* Dark blue for top nav */
    color: white;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0 20px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
  }

  #student_name {
    font-size: 1.1em;
  }

  #left_side_bar {
    width: 250px;
    background-color: green;
    /* Slightly lighter blue for sidebar */
    height: calc(100vh - 60px);
    /* Adjusted to fit below top nav */
    position: fixed;
    top: 0px;
    /* Starts below top nav */
    left: 0;
    overflow-y: auto;
    /* Enable scrolling */
    color: white;
  }

  #menu_list {
    list-style-type: none;
    padding: 15px 0;
  }

  .menu_items_list {
    padding: 12px 20px;
    font-size: 1em;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .menu_items_list:hover {
    background-color: #3e5c76;
  }

  .menu_items_link {
    text-decoration: none;
    color: white;
    display: block;
  }

  #main_content {
    margin-left: 250px;
    margin-top: 60px;
    padding: 30px;
    min-height: calc(100vh - 60px);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    /* Align at top to ensure visibility */
  }

  .form-container {
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    transition: transform 0.3s ease;
  }

  .form-container:hover {
    transform: translateY(-5px);
  }

  .form-container h2 {
    color: orange;
    font-weight: 600;
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 25px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-weight: 500;
    color: #34495e;
    margin-bottom: 8px;
    font-size: 1rem;
  }

  .form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #dcdcdc;
    border-radius: 5px;
    font-size: 1rem;
    color: #333;
    background: #f9f9f9;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .form-group input:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
    outline: none;
    background: white;
  }

  .password-strength {
    margin-top: 10px;
    font-size: 0.9em;
    color: #555;
  }

  .strength-item {
    display: flex;
    align-items: center;
    margin: 6px 0;
  }

  .checkmark {
    color: #27ae60;
    margin-right: 8px;
    display: none;
  }

  .cross {
    color: #e74c3c;
    margin-right: 8px;
    display: none;
  }

  .strength-item.valid .checkmark {
    display: inline;
  }

  .strength-item.invalid .cross {
    display: inline;
  }

  .form-group button {
    width: 100%;
    padding: 12px;
    background: #27ae60;
    /* Solid green color */
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
  }

  .form-group button:disabled {
    background: #bdc3c7;
    cursor: not-allowed;
  }

  .form-group button:not(:disabled):hover {
    background: #219653;
    /* Darker green on hover */
    transform: translateY(-2px);
  }

  .message {
    text-align: center;
    margin-top: 20px;
    font-size: 0.95rem;
  }

  @media (max-width: 768px) {
    #left_side_bar {
      width: 200px;
    }

    #main_content {
      margin-left: 200px;
    }
  }

  @media (max-width: 576px) {
    #left_side_bar {
      width: 100%;
      height: auto;
      position: static;
      top: 0;
    }

    #main_content {
      margin-left: 0;
      margin-top: 0;
      padding: 20px;
    }

    .form-container {
      max-width: 100%;
    }
  }
  </style>
</head>

<body>
  <!-- Top Navigation -->
  <div id="top-navigation">
    <div id="student_name">
      <span style="color: #f1c40f; font-size: 1.1em;"><em>Welcome,</em> </span>
      <span style="font-family: serif;">Admin</span>
    </div>
  </div>

  <!-- Left Sidebar -->
  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="admin/view_registered_students/view_registered_students.php">
        <li class="menu_items_list">Registered Students</li>
      </a>
      <a class="menu_items_link" href="../../add_position.php">
        <li class="menu_items_list">Add Attachment Positions</li>
      </a>
      <a class="menu_items_link" href="admin/students_assumptions/students_assumptions.php">
        <li class="menu_items_list">Student Assumptions</li>
      </a>
      <a class="menu_items_link" href="admin/student_stat/student_stat.php">
        <li class="menu_items_list">Student Statistics</li>
      </a>
      <a class="menu_items_link" href="../../add_supervisor.php">
        <li class="menu_items_list">Add Supervisor</li>
      </a>
      <a class="menu_items_link" href="admin/visiting_score/visiting_supervisors_score.php">
        <li class="menu_items_list">Visiting Supervisors Score</li>
      </a>
      <a class="menu_items_link" href="admin/company_score/company_supervisor_score.php">
        <li class="menu_items_list">Company Supervisor Score</li>
      </a>
      <a class="menu_items_link" href="../../admin_reports.php">
        <li class="menu_items_list">Submitted Report</li>
      </a>
      <a class="menu_items_link" href="../../logbook_report.php">
        <li class="menu_items_list">Logbook Report</li>
      </a>
      <a class="menu_items_link" href="admin/change_password/change_password.php">
        <li class="menu_items_list">Change Password</li>
      </a>
      <a class="menu_items_link" href="../../add_admin.php">
        <li class="menu_items_list">Add Admin</li>
      </a>
      <a class="menu_items_link" href="../../index.php">
        <li class="menu_items_list">Logout</li>
      </a>
    </ul>
  </div>

  <!-- Main Content -->
  <div id="main_content">
    <div class="form-container">
      <h2>Add System Admin</h2>
      <form method="post" action="" id="adminForm">
        <div class="form-group">
          <label for="username">Username (must include 'admin')</label>
          <input id="username" type="text" name="username" placeholder="e.g., admin123" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="Enter strong password" required>
          <div class="password-strength">
            <div class="strength-item" id="length"><span class="checkmark">✔</span><span class="cross">✖</span> At least
              8 characters</div>
            <div class="strength-item" id="uppercase"><span class="checkmark">✔</span><span class="cross">✖</span>
              Uppercase letter</div>
            <div class="strength-item" id="lowercase"><span class="checkmark">✔</span><span class="cross">✖</span>
              Lowercase letter</div>
            <div class="strength-item" id="number"><span class="checkmark">✔</span><span class="cross">✖</span> Number
            </div>
            <div class="strength-item" id="special"><span class="checkmark">✔</span><span class="cross">✖</span> Special
              character</div>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" name="btn_add_admin" id="submitBtn" disabled>Add Admin</button>
        </div>
      </form>
      <div class="message">
        <?php echo $message; ?>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    const passwordInput = $('#password');
    const submitBtn = $('#submitBtn');

    passwordInput.on('input', function() {
      const password = $(this).val();

      // Check each criterion
      const lengthValid = password.length >= 8;
      const uppercaseValid = /[A-Z]/.test(password);
      const lowercaseValid = /[a-z]/.test(password);
      const numberValid = /[0-9]/.test(password);
      const specialValid = /[^A-Za-z0-9]/.test(password);

      // Update UI for each criterion
      updateStrengthItem('#length', lengthValid);
      updateStrengthItem('#uppercase', uppercaseValid);
      updateStrengthItem('#lowercase', lowercaseValid);
      updateStrengthItem('#number', numberValid);
      updateStrengthItem('#special', specialValid);

      // Enable submit button only if all criteria are met
      const isStrong = lengthValid && uppercaseValid && lowercaseValid && numberValid && specialValid;
      submitBtn.prop('disabled', !isStrong);
    });

    function updateStrengthItem(selector, isValid) {
      const item = $(selector);
      item.removeClass('valid invalid');
      item.addClass(isValid ? 'valid' : 'invalid');
    }
  });
  </script>
</body>

</html>