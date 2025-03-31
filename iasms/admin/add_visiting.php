<?php
// Include the database connection from the provided code
include '../../database_connection/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and insert data into the supervisors_login table
    $query = "INSERT INTO supervisors_login (username, password, status) 
              VALUES ('$username', '$hashed_password', '$status')";

    // Check if insertion is successful
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('New supervisor added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-pink">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Supervisor</title>

  <link rel="stylesheet" href="../../css/bootstrap-theme.min.css" />
  <link rel="stylesheet" href="../../css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../css/main_page_style.css" />
  <link rel="stylesheet" href="view_registered_students.css" />

  <script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="../../js/bootstrap.min.js"></script>
</head>

<body>

  <div id="top-navigation">
    <div id="student_name">
      <span style="color:rgb(255, 198, 0);font-size:1.1em"><em>Welcome,</em>&nbsp;</span>
      <span style="font-family:serif"><?php echo "Admin" ?></span>
    </div>
  </div>

  <div id="left_side_bar">
    <ul id="menu_list">
      <a class="menu_items_link" href="view_registered_students.php">
        <li class="menu_items_list">Registered Students</li>
      </a>
      <a class="menu_items_link" href="add_supervisor.php">
        <li class="menu_items_list" style="background-color:orange;padding-left:16px">Add Supervisor</li>
      </a>
      <!-- Add more links as necessary -->
    </ul>
  </div>

  <div id="main_content">
    <div class="container-fluid">
      <div class="panel">
        <div class="panel-heading phead">
          <h2 class="panel-title ptitle">Add New Supervisor</h2>
        </div>
        <div class="panel-body pbody">
          <form method="post" action="">
            <!-- Username Field -->
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <!-- Password Field -->
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- Status Field (Dropdown) -->
            <div class="form-group">
              <label for="status">Status:</label>
              <select class="form-control" id="status" name="status" required>
                <option value="Visiting">Visiting</option>
                <option value="Company">Company</option>
              </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

</html>