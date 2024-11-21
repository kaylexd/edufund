<?php
session_start();
include('../includes/db.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $user_id = $_SESSION['user_id'];

    // Form data
    $sfname = trim($_POST['sfname']);
    $smname = trim($_POST['smname']);
    $slname = trim($_POST['slname']);
    $sfix = $_POST['sfix'];
    $sdbirth = $_POST['sdbirth'];
    $sgender = $_POST['sgender'];
    $sctship = trim($_POST['sctship']);
    $saddress = trim($_POST['saddress']);
    $scontact = trim($_POST['scontact']);
    $semail = trim($_POST['semail']);
    $scourse = trim($_POST['scourse']);
    $syear = trim($_POST['syear']);
    $s_scholarship_type = 'Academic';
    $applied_on = date('Y-m-d');
    $s_account_status = 'Pending';
    $sffname = trim($_POST['sffname']);
    $sfaddress = trim($_POST['sfaddress']);
    $sfcontact = trim($_POST['sfcontact']);
    $sfoccu = trim($_POST['sfoccu']);
    $sfcompany = trim($_POST['sfcompany']);
    $smfname = trim($_POST['smfname']);
    $smaddress = trim($_POST['smaddress']);
    $smcontact = trim($_POST['smcontact']);
    $smoccu = trim($_POST['smoccu']);
    $smcompany = trim($_POST['smcompany']);
    $sgfname = trim($_POST['sgfname']);
    $sgaddress = trim($_POST['sgaddress']);
    $sgcontact = trim($_POST['sgcontact']);
    $sgoccu = trim($_POST['sgoccu']);
    $sgcompany = trim($_POST['sgcompany']);
    $spcyincome = trim($_POST['spcyincome']); 
    $sschool = trim($_POST['sschool']);       
    $saward = trim($_POST['saward']);         
    $sreceive = $_POST['sreceive'];           

    $stmt = $conn->prepare("SELECT id FROM students WHERE slname = ? AND sdbirth = ? AND is_scholar = 1");
    $stmt->bind_param("ss", $slname, $sdbirth);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('You have already applied for a scholarship. If you have any concerns, please contact the Admin.');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    }

    // If no errors, proceed with updating or inserting data
    if (empty($errors)) {
        // Check if the user already has an entry in the students table
        $stmt = $conn->prepare("SELECT id FROM students WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($_FILES) {
            $upload_dir = "../img/";
            $requirements = [
                'cert_file' => 'cert_file_path',
                'moral_file' => 'moral_file_path',
                'grades_file' => 'grades_file_path',
                'grad_file' => 'grad_file_path'
            ];
        
            foreach ($requirements as $input_name => $column_name) {
                if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
                    $file = $_FILES[$input_name];
                    $filename = time() . '_' . $user_id . '_' . basename($file['name']);
                    $filepath = $upload_dir . $filename;
        
                    if (move_uploaded_file($file['tmp_name'], $filepath)) {
                        $query = "UPDATE students SET `{$column_name}` = ? WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("si", $filepath, $user_id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        }
        

    if ($result->num_rows > 0) {
        // Update student details
        $stmt = $conn->prepare("UPDATE students SET sfname = ?, smname = ?, slname = ?, sfix = ?, sdbirth = ?, sgender = ?, sctship = ?, saddress = ?, scontact = ?, semail = ?, scourse = ?, syear = ?, spcyincome = ?, sschool = ?, saward = ?, sreceive = ?, s_scholarship_type = ?, applied_on = ?, s_account_status = ? WHERE id = ?");
        $stmt->bind_param("sssssssssssssssssssi", $sfname, $smname, $slname, $sfix, $sdbirth, $sgender, $sctship, $saddress, $scontact, $semail, $scourse, $syear, $spcyincome, $sschool, $saward, $sreceive, $s_scholarship_type, $applied_on, $s_account_status, $user_id);

        if ($stmt->execute()) {
            // Check if family details exist for this user
            $familyCheckStmt = $conn->prepare("SELECT f_id FROM family WHERE student_id = ?");
            if (!$familyCheckStmt) {
                die("Prepare failed: " . $conn->error);
            }
            $familyCheckStmt->bind_param("i", $user_id);
            $familyCheckStmt->execute();
            $familyResult = $familyCheckStmt->get_result();


            if ($familyResult->num_rows > 0) {
                // Update family details if they already exist
                $familyStmt = $conn->prepare("UPDATE family SET sffname = ?, sfaddress = ?, sfcontact = ?, sfoccu = ?, sfcompany = ?, smfname = ?, smaddress = ?, smcontact = ?, smoccu = ?, smcompany = ?, sgfname = ?, sgaddress = ?, sgcontact = ?, sgoccu = ?, sgcompany = ? WHERE student_id = ?");
                $familyStmt->bind_param("sssssssssssssssi", $sffname, $sfaddress, $sfcontact, $sfoccu, $sfcompany, $smfname, $smaddress, $smcontact, $smoccu, $smcompany, $sgfname, $sgaddress, $sgcontact, $sgoccu, $sgcompany, $user_id);
            } else {
                // Insert family details if they don't exist
                $familyStmt = $conn->prepare("INSERT INTO family (student_id, sffname, sfaddress, sfcontact, sfoccu, sfcompany, smfname, smaddress, smcontact, smoccu, smcompany, sgfname, sgaddress, sgcontact, sgoccu, sgcompany) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $familyStmt->bind_param("isssssssssssssss", $user_id, $sffname, $sfaddress, $sfcontact, $sfoccu, $sfcompany, $smfname, $smaddress, $smcontact, $smoccu, $smcompany, $sgfname, $sgaddress, $sgcontact, $sgoccu, $sgcompany);
            }

            if ($familyStmt->execute()) {
                echo "<script>alert('Form successfully submitted!');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "Error updating family details: " . $familyStmt->error;
            }
            $familyStmt->close();
            $familyCheckStmt->close();
        } else {
            echo "Error updating student details: " . $stmt->error;
        }
    } else {
        // Insert new student details if they don't exist
        $stmt = $conn->prepare("INSERT INTO students (id, sfname, smname, slname, sfix, sdbirth, sgender, sctship, saddress, scontact, semail, scourse, syear, spcyincome, sschool, saward, sreceive, s_scholarship_type, s_account_status, applied_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssssssssssssssss", $user_id, $sfname, $smname, $slname, $sfix, $sdbirth, $sgender, $sctship, $saddress, $scontact, $semail, $scourse, $syear, $spcyincome, $sschool, $saward, $sreceive, $s_scholarship_type, $s_account_status, $applied_on);

        if ($stmt->execute()) {
            // Insert family details
            $familyStmt = $conn->prepare("INSERT INTO family (student_id, sffname, sfaddress, sfcontact, sfoccu, sfcompany, smfname, smaddress, smcontact, smoccu, smcompany, sgfname, sgaddress, sgcontact, sgoccu, sgcompany) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $familyStmt->bind_param("isssssssssssssss", $user_id, $sffname, $sfaddress, $sfcontact, $sfoccu, $sfcompany, $smfname, $smaddress, $smcontact, $smoccu, $smcompany, $sgfname, $sgaddress, $sgcontact, $sgoccu, $sgcompany);

            if ($familyStmt->execute()) {
                echo "<script>alert('Form successfully submitted!');</script>";
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "Error inserting family details: " . $familyStmt->error;
            }
            $familyStmt->close();
            } else {
                echo "Error inserting student details: " . $stmt->error;
            }
        }
        $stmt->close();
        $conn->close();
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}


?>