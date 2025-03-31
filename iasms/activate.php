<?php
include 'database_connection/database_connection.php';

session_start();

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
                msg.textContent = '$message';
                document.body.prepend(msg);
            });
          </script>";
}

if (isset($_GET['token'])) {
    $activation_token = $_GET['token'];

    // Check if activation token exists in the database
    $check_token_query = "SELECT * FROM registered_students WHERE activation_token='$activation_token' LIMIT 1";
    $result = mysqli_query($conn, $check_token_query);

    if (mysqli_num_rows($result) > 0) {
        // Activate the user account
        $activate_user_query = "UPDATE registered_students SET is_active=1, activation_token=NULL WHERE activation_token='$activation_token'";
        if (mysqli_query($conn, $activate_user_query)) {
            showAlert('Your account has been successfully activated. You can now sign in.', 'green');
            exit;
        } else {
            showAlert('Failed to activate your account. Please try again later.', 'red');
        }
    } else {
        showAlert('Invalid activation token.', 'red');
    }
} else {
    showAlert('Activation token not found.', 'red');
}

// Redirect to login page
echo "<script>window.location.replace('index.php');</script>";
?>
