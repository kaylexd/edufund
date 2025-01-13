<?php
session_start();
include('includes/db.php');

// Clear previous session data
session_unset();

// Initialize error array
$errors = [];

// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the form fields are filled
if (empty($username) || empty($password)) {
    $errors[] = "Email and password are required.";
}

// Prepare and execute the query for the admin table
if (empty($errors)) {
    $stmt = $conn->prepare('SELECT id, password FROM administrator WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Check if the user is admin or officer based on the username
            if ($username === 'admin') { // Assuming 'admin' is the username for the admin
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_type'] = 'admin';
                $_SESSION['username'] = $username;
                header("Location: index.php"); // Admin dashboard
                exit;
            } else {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_type'] = 'officer';
                $_SESSION['username'] = $username;
                header("Location: officer/index.php"); // Officer dashboard
                exit;
            }
        } else {
            $errors[] = "Invalid username or password.";
        }
    } else {
        // If no admin found, check the student table
        $stmt->close();
        $stmt = $conn->prepare('
            SELECT 
                s.id,
                s.semail, 
                s.spass,
                s.is_verified,
                s.sfname,
                s.slname,
                o.account_status
            FROM students s
            LEFT JOIN officer o ON s.id = o.student_id
            WHERE s.semail = ?
        ');

        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($student_id, $semail, $hashedPassword, $is_verified, $sfname, $slname, $account_status);
            $stmt->fetch();
        
            // Check email verification first
            if ($is_verified == 0) {
                $errors[] = "Please verify your email before logging in. Check your inbox for the verification email.";
            } 
            // Then check account status
            elseif ($account_status === 'Inactive') {
                $errors[] = "Your account is pending. Please wait for Approval.";
            } else {
                // Account is active and verified, verify password
                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user_id'] = $student_id;
                    $_SESSION['user_type'] = 'student';
                    $_SESSION['username'] = $username;
                    $_SESSION['user_name'] = $sfname . ' ' . $slname;
                    header("Location: student/index.php");
                    exit;
                } else {
                    $errors[] = "Invalid email or password.";
                }
            }
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
        // Close the statement
        $stmt->close();
}

// Close the connection
$conn->close();

// If there are errors, store them in the session and redirect
if (!empty($errors)) {
    $_SESSION['error'] = implode(", ", $errors);
    header("Location: login.php");
    exit;
}
?>