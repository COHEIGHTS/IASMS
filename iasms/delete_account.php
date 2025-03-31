<?php
session_start();
include 'database_connection/database_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Access denied. Please log in.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Delete the user's account
$sql = "DELETE FROM registered_students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    session_destroy(); // Logout after account deletion
    echo "Account deleted successfully!";
    header("Location: login.php"); // Redirect to login page
    exit();
} else {
    echo "Error deleting account: " . $conn->error;
}

$conn->close();
?>