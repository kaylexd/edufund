<?php
session_start();
include('includes/db.php'); // Include your database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Function to generate verification token
function generateVerificationToken() {
    return bin2hex(random_bytes(32)); // Generates a secure random token
}

// Function to send verification email
function sendVerificationEmail($email, $token, $firstname, $lastname) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'xskaven6@gmail.com';
        $mail->Password   = 'shidqrwdcpcjzyhq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('xskaven6@gmail.com', 'Scholarship System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification for Your Account';

        // Verification link (adjust the URL to your actual domain)
        $verification_link = "https://localhost/scholarship/verify.php?token=" . $token;

        $mail->Body = "
            <div style='font-family: Arial, sans-serif;'>
                <h2>Email Verification</h2>
                <p>Hello {$firstname} {$lastname},</p>
                <p>Thank you for registering with our Scholarship System. 
                Please verify your email by clicking the link below:</p>
                <a href='{$verification_link}'>Verify Email</a>
                <p>If you did not create an account, please ignore this email.</p>
            </div>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error or handle it as needed
        return false;
    }
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $studentid = $_POST['studentid'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing the password

    // Initialize error array
    $errors = [];

    // Validate student ID format
    if (!preg_match('/^SCC-\d{2}-\d{6,11}$/', $studentid)) {
        $errors['studentid_format'] = "Student ID must be in the format SCC-00-000000.";
    } else {
        // Check if student ID already exists
        $studentIDCheckQuery = "SELECT * FROM students WHERE sid = ?";
        $stmt = $conn->prepare($studentIDCheckQuery);
        $stmt->bind_param("s", $studentid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['studentid'] = "This student ID is already registered.";
        }
        $stmt->close();
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_format'] = "Invalid email format.";
    } else {
        // Check if email already exists
        $emailCheckQuery = "SELECT * FROM students WHERE semail = ?";
        $stmt = $conn->prepare($emailCheckQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['email'] = "This email is already registered.";
        }
        $stmt->close();
    }

    // File upload logic for "Study Load" image
    if ($_FILES["studyload"]["error"] == UPLOAD_ERR_NO_FILE) {
        $errors['studyload'] = "Study Load image is required.";
    } else {
        $fileName = $_FILES["studyload"]["name"];
        $fileSize = $_FILES["studyload"]["size"];
        $tmpName = $_FILES["studyload"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtension)) {
            $errors['studyload'] = "Invalid image extension. Allowed: jpg, jpeg, png.";
        } else if ($fileSize > 1000000) {
            $errors['studyload'] = "Image size is too large. Max size is 1MB.";
        } else {
            // Generate a unique file name and save the file
            $newImageName = uniqid() . '.' . $imageExtension;
            if (!move_uploaded_file($tmpName, 'img/' . $newImageName)) {
                $errors['studyload'] = "Error saving the file.";
            }
        }
    }

    // Check for any errors
    if (!empty($errors)) {
        // Handle errors (e.g., store in session and redirect back)
        $_SESSION['error'] = implode(", ", $errors);
        header("Location: register.php");
        exit;
    }

    // Prepare the image path for binding
    $imagePath = 'img/' . $newImageName;

    // Generate verification token
    $verification_token = generateVerificationToken();

    // Insert data into the database
    $sql = "INSERT INTO students (sid, slname, sfname, semail, spass, simg, verification_token, is_verified) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $studentid, $lastname, $firstname, $email, $password, $imagePath, $verification_token);

    if ($stmt->execute()) {
        $student_id = $stmt->insert_id;
        
        // Insert into officer table with default status
        $officer_sql = "INSERT INTO officer (student_id, account_status) VALUES (?, 'Inactive')";
        $officer_stmt = $conn->prepare($officer_sql);
        $officer_stmt->bind_param("i", $student_id);
        
        

        if ($officer_stmt->execute()) {
        // Try to send verification email
        try {
            $emailSent = sendVerificationEmail($email, $verification_token, $firstname, $lastname);
            
            if ($emailSent) {
                // Store success message in session
                $_SESSION['success'] = "Registration successful! Please check your email to verify your account.";
            } else {
                // If email fails, but registration is successful
                $_SESSION['success'] = "Registration successful, but there was an issue sending the verification email. Please contact support.";
            }
            
            header("Location: register.php");
            exit;
        } catch (Exception $e) {
            // Handle email sending error
            $_SESSION['error'] = "Registration completed, but verification email failed: " . $e->getMessage();
            header("Location: register.php");
            exit;
        }
    } else {
        // Registration failed
        $_SESSION['error'] = "Registration failed: " . $stmt->error;
        header("Location: register.php");
        exit;
    }

    $stmt->close();
}
}
$conn->close();
?>