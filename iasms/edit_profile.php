<?php
session_start();
include 'database_connection/database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "⚠️ SESSION NOT SET. Please log in again.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the logged-in user's details
$sql = "SELECT first_name, last_name, index_number, Email FROM registered_students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found!";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $index_number = trim($_POST['index_number']);
    $email = trim($_POST['email']);

    // Update user details in the database
    $update_sql = "UPDATE registered_students SET first_name=?, last_name=?, index_number=?, Email=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $first_name, $last_name, $index_number, $email, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "❌ Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 20px;
  }

  form {
    width: 50%;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
  }

  label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
  }

  input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  button {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    margin-top: 15px;
    cursor: pointer;
  }

  button:hover {
    background-color: #45a049;
  }

  .back {
    display: block;
    margin-top: 10px;
    text-decoration: none;
    color: #007bff;
  }

  .back:hover {
    text-decoration: underline;
  }
  </style>
</head>

<body>

  <h2>Edit Your Profile</h2>

  <form method="POST">
    <label>First Name:</label>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

    <label>Last Name:</label>
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

    <label>Index Number:</label>
    <input type="text" name="index_number" value="<?php echo htmlspecialchars($user['index_number']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

    <button type="submit">Update Profile</button>
  </form>

  <a class="back" href="dashboard.php">← Back to Dashboard</a>

</body>

</html>