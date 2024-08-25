<?php
session_start();
require '../connection.php';

// Check if the form is submitted

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    // Check if the email is valid
    if (!$email) {
        echo '<div class="alert alert-danger">Invalid email address.</div>';
        exit;
    }

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO students (name, email, address, status) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ssss", $name, $email, $address, $status);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Student Added Successfully";
            header("Location:../index.php");
             exit();

        }
         else {
            $_SESSION['message'] = "Student Not Added";
            header("Location:../index.php");
            exit();
        }

        // Close statement
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Error preparing statement: ' . $conn->error . '</div>';
    }

    // Close connection
    $conn->close();
} else {
    echo '<div class="alert alert-danger">Invalid request method.</div>';
}
?>