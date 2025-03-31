<?php
// Include the database connection
include 'database_connection/database_connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $supervisor_id = $_GET['id'];

    // Use prepared statement to prevent SQL injection
    $sql_delete = "DELETE FROM supervisors_login WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $supervisor_id);

    if ($stmt->execute()) {
        header("Location: view_supervisor.php?msg=deleted");
        exit();
    } else {
        header("Location: view_supervisor.php?msg=error");
        exit();
    }
} else {
    header("Location: view_supervisor.php?msg=invalid");
    exit();
}
?>