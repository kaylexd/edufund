<?php
session_start();
include('includes/db.php');

// Check if token is present in the URL
if (isset($_GET['token'])) {
    $verification_token = $_GET['token'];

    // Prepare statement to verify token
    $stmt = $conn->prepare("SELECT * FROM students WHERE verification_token = ? AND is_verified = 0");
    $stmt->bind_param("s", $verification_token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, get user details
        $user = $result->fetch_assoc();

        // Update user as verified and clear the token
        $update_stmt = $conn->prepare("UPDATE students SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");

        $update_stmt->bind_param("s", $verification_token);
        
        if ($update_stmt->execute()) {
            // Verification successful
            $_SESSION['success'] = "Email verified successfully! You can now log in.";
        } else {
            // Update failed
            $_SESSION['error'] = "Verification failed. Please contact support.";
        }
    } else {
        // Invalid or already verified token
        $_SESSION['error'] = "Invalid or expired verification token.";
    }

    // Redirect to login page
    header("Location: login.php");
    exit();
} else {
    // No token provided
    header("Location: login.php");
    exit();
}
?>