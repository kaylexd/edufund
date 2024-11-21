<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Flag to track if password change is requested
$password_change_requested = !empty($current_password) && !empty($new_password) && !empty($confirm_password);

// Only proceed if current password is correct for a password change
if ($password_change_requested) {
    $stmt = $conn->prepare("SELECT s_pass FROM students WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify current password
    if (!$user || !password_verify($current_password, $user['s_pass'])) {
        $_SESSION['modal_msg'] = "Current password is incorrect.";
        $_SESSION['show_modal'] = true;
header("Location: index.php");
exit();
    }

    // Check if new password matches confirm password
    if ($new_password !== $confirm_password) {
        $_SESSION['modal_msg'] = "New password does not match.";
        $_SESSION['show_modal'] = true;
header("Location: index.php");
exit();
    }

    // Hash new password for update
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
}

// Prepare to update only changed fields
$update_query = "UPDATE students SET sfname = ?, smname = ?, slname = ?, semail = ?";
$params = [$firstname, $middlename, $lastname, $email];
$types = "ssss";

if ($password_change_requested) {
    $update_query .= ", s_pass = ?";
    $params[] = $hashed_password;
    $types .= "s";
}

$update_query .= " WHERE id = ?";
$params[] = $user_id;
$types .= "i";

$stmt = $conn->prepare($update_query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    $_SESSION['modal_msg'] = "Profile updated successfully!";
    $_SESSION['modal_success'] = true;
} else {
    $_SESSION['modal_msg'] = "Error updating profile.";
}

header("Location: index.php");
exit();
?>
