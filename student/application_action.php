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

    // Family details
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
    $spcyincome = (int)trim($_POST['spcyincome']);

    // Academic application details
    $sschool = trim($_POST['sschool']);
    $saward = trim($_POST['saward']);
    $sreceive = $_POST['sreceive'];

    // Handle file uploads
    $upload_dir = "../img/";
    $uploaded_files = [];

    if ($_FILES) {
        $requirements = [
            'cert_file' => 'cert_file_path',
            'moral_file' => 'moral_file_path_acad',
            'grades_file' => 'grades_file_path',
            'grad_file' => 'grad_file_path'
        ];

        foreach ($requirements as $input_name => $column_name) {
            if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
                $file = $_FILES[$input_name];
                $filename = time() . '_' . $user_id . '_' . basename($file['name']);
                $filepath = $upload_dir . $filename;

                if (move_uploaded_file($file['tmp_name'], $filepath)) {
                    $uploaded_files[$column_name] = $filepath;
                } else {
                    $errors[] = "Failed to upload file: $input_name";
                }
            }
        }
    }

    // If no errors, proceed with database operations
    if (empty($errors)) {
        try {
            // Start transaction
            $conn->begin_transaction();

            // Insert or update student details
            $stmt = $conn->prepare("
                INSERT INTO students (id, sfname, smname, slname, sfix, sdbirth, sgender, sctship, saddress, scontact, semail, scourse, syear)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    sfname = VALUES(sfname), smname = VALUES(smname), slname = VALUES(slname),
                    sfix = VALUES(sfix), sdbirth = VALUES(sdbirth), sgender = VALUES(sgender),
                    sctship = VALUES(sctship), saddress = VALUES(saddress), scontact = VALUES(scontact),
                    semail = VALUES(semail), scourse = VALUES(scourse), syear = VALUES(syear)
            ");
            $stmt->bind_param("issssssssssss", $user_id, $sfname, $smname, $slname, $sfix, $sdbirth, $sgender, $sctship, $saddress, $scontact, $semail, $scourse, $syear);
            $stmt->execute();

            // Insert or update family details
            $stmt = $conn->prepare("
                INSERT INTO s_family (student_id, sffname, sfaddress, sfcontact, sfoccu, sfcompany, smfname, smaddress, smcontact, smoccu, smcompany, sgfname, sgaddress, sgcontact, sgoccu, sgcompany, spcyincome)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    sffname = VALUES(sffname), sfaddress = VALUES(sfaddress), sfcontact = VALUES(sfcontact), sfoccu = VALUES(sfoccu),
                    sfcompany = VALUES(sfcompany), smfname = VALUES(smfname), smaddress = VALUES(smaddress), smcontact = VALUES(smcontact),
                    smoccu = VALUES(smoccu), smcompany = VALUES(smcompany), sgfname = VALUES(sgfname), sgaddress = VALUES(sgaddress),
                    sgcontact = VALUES(sgcontact), sgoccu = VALUES(sgoccu), sgcompany = VALUES(sgcompany), spcyincome = VALUES(spcyincome)
            ");
            $stmt->bind_param("isssssssssssssssi", $user_id, $sffname, $sfaddress, $sfcontact, $sfoccu, $sfcompany, $smfname, $smaddress, $smcontact, $smoccu, $smcompany, $sgfname, $sgaddress, $sgcontact, $sgoccu, $sgcompany, $spcyincome);
            $stmt->execute();

            $stmt = $conn->prepare("
                INSERT INTO admin_status (student_id, s_scholar_status)
                VALUES (?, 'Pending')
                ON DUPLICATE KEY UPDATE s_scholar_status = VALUES(s_scholar_status)
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Insert scholarship application first to get the ID
            $stmt = $conn->prepare("
                INSERT INTO scholarship_applications (student_id, s_scholarship_type, applied_on, s_account_status)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    s_scholarship_type = VALUES(s_scholarship_type), 
                    applied_on = VALUES(applied_on), 
                    s_account_status = VALUES(s_account_status)
            ");
            $stmt->bind_param("isss", $user_id, $s_scholarship_type, $applied_on, $s_account_status);
            $stmt->execute();
            $scholarship_application_id = $stmt->insert_id ?: $conn->query("SELECT id FROM scholarship_applications WHERE student_id = $user_id")->fetch_object()->id;

            // Insert or update academic application details
            $stmt = $conn->prepare("
                INSERT INTO applications (scholarship_application_id, sschool, saward, sreceive)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    sschool = VALUES(sschool), 
                    saward = VALUES(saward), 
                    sreceive = VALUES(sreceive)
            ");
            $stmt->bind_param("isss", $scholarship_application_id, $sschool, $saward, $sreceive);
            $stmt->execute();

            // Update uploaded files in acad_app
            foreach ($uploaded_files as $column_name => $filepath) {
                $stmt = $conn->prepare("UPDATE applications SET `{$column_name}` = ? WHERE scholarship_application_id = ?");
                $stmt->bind_param("si", $filepath, $scholarship_application_id);
                $stmt->execute();
            }

            // Commit transaction
            $conn->commit();

            echo "<script>alert('Form successfully submitted!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";

        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $errors[] = "Database error: " . $e->getMessage();
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>