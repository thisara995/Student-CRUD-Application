<?php
session_start();
require_once "../connection.php";

if (isset($_POST['deletedata'])) {
    $student_id = $_POST['student_id'];

    $query = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Student record deleted successfully!";
        header("Location: ../index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to delete student record!";
        header("Location: ../index.php");
        exit(0);
    }
    
    $stmt->close();
    $conn->close();
}
?>
