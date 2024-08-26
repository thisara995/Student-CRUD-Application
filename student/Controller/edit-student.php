<?php
session_start();
require '../connection.php';

if (isset($_POST['update'])) { 
    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $status = $_POST['status'];

    // Use prepared statements to prevent SQL injection
    $query = "UPDATE students SET name = ?, email = ?, address = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $name, $email, $address, $status, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Student data updated successfully !";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['message_error'] = "Student data not updated !";
        header("Location: ../index.php");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
