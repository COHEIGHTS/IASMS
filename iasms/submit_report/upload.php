<?php
include '../database_connection/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['file']['name'])) {
    // Ensure student is logged in and session is active
    if (isset($_COOKIE["student_index_number"])) {
        $index_number = $_COOKIE["student_index_number"];
        $folder = 'uploads/'; // Folder where files will be uploaded
        $threshold = count($_FILES['file']['name']);

        // Loop through uploaded files
        for ($i = 0; $i < $threshold; $i++) {
            $filename = $_FILES['file']['name'][$i];
            $path = $folder . $filename;

            // Check for invalid file extensions
            if (strpos($filename, '.php') !== false || strpos($filename, '.exe') !== false) {
                echo "Choose another file!";
            } else {
                // Move the uploaded file to the designated folder
                if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $path)) {
                    // Insert file path and student index number into the database
                    $stmt = $conn->prepare("INSERT INTO reports (student_index, file_path) VALUES (?, ?)");
                    $stmt->bind_param("ss", $index_number, $path);

                    if ($stmt->execute()) {
                        echo "File $i uploaded successfully and recorded in the database! <br>";
                    } else {
                        echo "Error inserting file path into the database: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "File $i upload failed! :/ <br>";
                }
            }
        }
    } else {
        echo "Student not logged in.";
    }
}
?>