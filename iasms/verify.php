<?php
include 'database_connection/database_connection.php';

if (isset($_GET['token'])) {
    $verification_token = $_GET['token'];
    $query = "SELECT * FROM registered_students WHERE verification_token='$verification_token' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $update_query = "UPDATE registered_students SET verified=1 WHERE verification_token='$verification_token'";
        if (mysqli_query($conn, $update_query)) {
            echo "Email verified successfully. You can now log in.";
        } else {
            echo "Verification failed. Please try again.";
        }
    } else {
        echo "Invalid verification token.";
    }
} else {
    echo "No verification token provided.";
}
?>
