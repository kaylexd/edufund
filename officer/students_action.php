<?php
include('../includes/db.php'); // Include database connection

header('Content-Type: application/json'); // Set content type to JSON

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["action"])) {
    switch ($_POST["action"]) {
        

        case 'update_status':
            if (isset($_POST['s_id']) && isset($_POST['status'])) {
                $stmt = $conn->prepare("UPDATE scholarship_applications SET s_account_status = ? WHERE student_id = ?");
                $stmt->bind_param("si", $_POST['status'], $_POST['s_id']);
                
                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
                $stmt->close();
            }
            break;
        

                case 'send_announcement':
                $recipient_emails = explode(', ', $_POST['student_id']); 
                $subject = $_POST['subject'];
                $announcement = $_POST['announcement'];
            
                foreach ($recipient_emails as $semail) { 
                    $stmt = $conn->prepare("SELECT id FROM students WHERE semail = ?");
                    $stmt->bind_param("s", $semail);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
            
                    if ($row) {
                        $student_id = $row['id'];
                        // Insert announcement with student_id
                        $stmt = $conn->prepare("INSERT INTO announcements (student_id, subject, message) VALUES (?, ?, ?)");
                        $stmt->bind_param("iss", $student_id, $subject, $announcement);
                        if (!$stmt->execute()) {
                            error_log("Failed to insert announcement: " . $stmt->error); // Log the error
                            echo json_encode(['success' => false, 'error' => $stmt->error]);
                            exit;
                        }
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Student not found for semail: ' . $semail]);
                        exit;
                    }
                }
            
                echo json_encode(['success' => true]);
                break;
            

            case 'delete':
                if (isset($_POST["id"])) {
                    $id = $_POST["id"];
                    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
                    $stmt->bind_param("i", $id);
            
                    if ($stmt->execute()) {
                        echo json_encode(['success' => "Student deleted successfully"]);
                    } else {
                        echo json_encode(['error' => "Error deleting student: " . $conn->error]);
                    }
                    $stmt->close();
                }
                break;
            

                case 'edit_acad':
                    $studentId = $_POST["acad_hidden_id"];
                    
                    // Start transaction
                    $conn->begin_transaction();
                    try {
                        // Update students table
                        $stmt = $conn->prepare("
                            UPDATE students 
                            SET sid = ?, sfname = ?, smname = ?, slname = ?, sfix = ?, 
                                sdbirth = ?, sgender = ?, sctship = ?, saddress = ?, 
                                semail = ?, scontact = ?, scourse = ?, syear = ?
                            WHERE id = ?
                        ");
                        $stmt->bind_param("sssssssssssssi", 
                            $_POST["sid"], $_POST["sfname"], $_POST["smname"], $_POST["slname"],
                            $_POST["sfix"], $_POST["sdbirth"], $_POST["sgender"], $_POST["sctship"],
                            $_POST["saddress"], $_POST["semail"], $_POST["scontact"], 
                            $_POST["scourse"], $_POST["syear"], $studentId
                        );
                        $stmt->execute();
                
                        // Insert or Update scholarship_applications table for snote
                        $stmt = $conn->prepare("
                        INSERT INTO scholarship_applications (student_id, snote)
                        VALUES (?, ?)
                        ON DUPLICATE KEY UPDATE snote = VALUES(snote)
                        ");
                        $stmt->bind_param("is", $studentId, $_POST["snote"]);
                        $stmt->execute();

                
                        // Update s_family table
                        $stmt = $conn->prepare("
                            UPDATE s_family 
                            SET sffname = ?, sfaddress = ?, sfcontact = ?, sfoccu = ?, sfcompany = ?,
                                smfname = ?, smaddress = ?, smcontact = ?, smoccu = ?, smcompany = ?,
                                sgfname = ?, sgaddress = ?, sgcontact = ?, sgoccu = ?, sgcompany = ?,
                                spcyincome = ?
                            WHERE student_id = ?
                        ");
                        $stmt->bind_param("sssssssssssssssii",
                            $_POST["sffname"], $_POST["sfaddress"], $_POST["sfcontact"], 
                            $_POST["sfoccu"], $_POST["sfcompany"],
                            $_POST["smfname"], $_POST["smaddress"], $_POST["smcontact"], 
                            $_POST["smoccu"], $_POST["smcompany"],
                            $_POST["sgfname"], $_POST["sgaddress"], $_POST["sgcontact"], 
                            $_POST["sgoccu"], $_POST["sgcompany"],
                            $_POST["spcyincome"], $studentId
                        );
                        $stmt->execute();
                
                        // Update applications table
                        $stmt = $conn->prepare("
                            UPDATE applications a
                            JOIN scholarship_applications sa ON a.scholarship_application_id = sa.id
                            SET a.sschool = ?, a.saward = ?, a.sreceive = ?
                            WHERE sa.student_id = ?
                        ");
                        $stmt->bind_param("sssi", 
                            $_POST["sschool"], $_POST["saward"], $_POST["sreceive"], $studentId
                        );
                        $stmt->execute();
                
                        $conn->commit();
                        echo json_encode(['success' => 'Student Data Updated']);
                
                    } catch (Exception $e) {
                        $conn->rollback();
                        echo json_encode(['error' => $e->getMessage()]);
                    }
                    break;

                    case 'edit_nonacad':
                        $studentId = $_POST["acad_hidden_id"];
                        
                        // Start transaction
                        $conn->begin_transaction();
                        try {
                            // Update students table
                            $stmt = $conn->prepare("
                                UPDATE students 
                                SET sid = ?, sfname = ?, smname = ?, slname = ?, sfix = ?, 
                                    sdbirth = ?, sgender = ?, sctship = ?, saddress = ?, 
                                    semail = ?, scontact = ?, scourse = ?, syear = ?
                                WHERE id = ?
                            ");
                            $stmt->bind_param("sssssssssssssi", 
                                $_POST["sid"], $_POST["sfname"], $_POST["smname"], $_POST["slname"],
                                $_POST["sfix"], $_POST["sdbirth"], $_POST["sgender"], $_POST["sctship"],
                                $_POST["saddress"], $_POST["semail"], $_POST["scontact"], 
                                $_POST["scourse"], $_POST["syear"], $studentId
                            );
                            $stmt->execute();
                    
                            // Insert or Update scholarship_applications table for snote
                            $stmt = $conn->prepare("
                            INSERT INTO scholarship_applications (student_id, snote)
                            VALUES (?, ?)
                            ON DUPLICATE KEY UPDATE snote = VALUES(snote)
                            ");
                            $stmt->bind_param("is", $studentId, $_POST["snote"]);
                            $stmt->execute();
    
                    
                            // Update s_family table
                            $stmt = $conn->prepare("
                                UPDATE s_family 
                                SET sffname = ?, sfaddress = ?, sfcontact = ?, sfoccu = ?, sfcompany = ?,
                                    smfname = ?, smaddress = ?, smcontact = ?, smoccu = ?, smcompany = ?,
                                    sgfname = ?, sgaddress = ?, sgcontact = ?, sgoccu = ?, sgcompany = ?,
                                    spcyincome = ?
                                WHERE student_id = ?
                            ");
                            $stmt->bind_param("sssssssssssssssii",
                                $_POST["sffname"], $_POST["sfaddress"], $_POST["sfcontact"], 
                                $_POST["sfoccu"], $_POST["sfcompany"],
                                $_POST["smfname"], $_POST["smaddress"], $_POST["smcontact"], 
                                $_POST["smoccu"], $_POST["smcompany"],
                                $_POST["sgfname"], $_POST["sgaddress"], $_POST["sgcontact"], 
                                $_POST["sgoccu"], $_POST["sgcompany"],
                                $_POST["spcyincome"], $studentId
                            );
                            $stmt->execute();
                    
                            // Update applications table
                            $stmt = $conn->prepare("
                                UPDATE applications a
                                JOIN scholarship_applications sa ON a.scholarship_application_id = sa.id
                                SET a.s_nas = ?, a.s_basic = ?, a.s_skills = ?, a.s_work = ?
                                WHERE sa.student_id = ?
                            ");
                            $stmt->bind_param("sssi", 
                                $_POST["sschool"], $_POST["saward"], $_POST["sreceive"], $studentId
                            );
                            $stmt->execute();
                    
                            $conn->commit();
                            echo json_encode(['success' => 'Student Data Updated']);
                    
                        } catch (Exception $e) {
                            $conn->rollback();
                            echo json_encode(['error' => $e->getMessage()]);
                        }
                        break;
                

            case 'acad_fetch_single':
                if (isset($_POST["s_id"])) {
                    $stmt = $conn->prepare("
                        SELECT s.*, 
                               sa.s_scholarship_type, sa.s_account_status, sa.snote, sa.applied_on,
                               f.sffname, f.sfaddress, f.sfcontact, f.sfoccu, f.sfcompany,
                               f.smfname, f.smaddress, f.smcontact, f.smoccu, f.smcompany,
                               f.sgfname, f.sgaddress, f.sgcontact, f.sgoccu, f.sgcompany,
                               f.spcyincome,
                               a.sschool, a.saward, a.sreceive,
                               a.cert_file_path, a.moral_file_path_acad, a.grades_file_path, 
                               a.grad_file_path, a.coe_file, a.psa_file, 
                               a.moral_file_path_admin, a.form_file, a.medc_file,
                               a.moral_file_path_cultural, a.s_nas, a.s_basic, 
                               a.s_skills, a.s_work, a.grades_file_non_acad,
                               a.moral_file_path_non_acad, a.indigency_file, a.medical_file
                        FROM students s
                        LEFT JOIN scholarship_applications sa ON s.id = sa.student_id
                        LEFT JOIN s_family f ON s.id = f.student_id
                        LEFT JOIN applications a ON sa.id = a.scholarship_application_id
                        WHERE s.id = ?
                    ");
            
            
            
                    $stmt->bind_param("i", $_POST["s_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $data = [];
            
                    if ($row = $result->fetch_assoc()) {
                        foreach ($row as $key => $value) {
                            $data[$key] = $value ?? '';
                        }
                    }
                    
                    echo json_encode($data);
                    $stmt->close();
                }
                break;

                case 'nonacad_fetch_single':
                    if (isset($_POST["s_id"])) {
                        $stmt = $conn->prepare("
                            SELECT s.*, 
                                   sa.s_scholarship_type, sa.s_account_status, sa.snote, sa.applied_on,
                                   f.sffname, f.sfaddress, f.sfcontact, f.sfoccu, f.sfcompany,
                                   f.smfname, f.smaddress, f.smcontact, f.smoccu, f.smcompany,
                                   f.sgfname, f.sgaddress, f.sgcontact, f.sgoccu, f.sgcompany,
                                   f.spcyincome,
                                   a.s_nas, a.s_basic, a.s_skills, a.s_work,
                                   a.cert_file_path, a.moral_file_path_acad, a.grades_file_path, 
                                   a.grad_file_path, a.coe_file, a.psa_file, 
                                   a.moral_file_path_admin, a.form_file, a.medc_file,
                                   a.moral_file_path_cultural, a.s_nas, a.s_basic, 
                                   a.s_skills, a.s_work, a.grades_file_non_acad,
                                   a.moral_file_path_non_acad, a.indigency_file, a.medical_file
                            FROM students s
                            LEFT JOIN scholarship_applications sa ON s.id = sa.student_id
                            LEFT JOIN s_family f ON s.id = f.student_id
                            LEFT JOIN applications a ON sa.id = a.scholarship_application_id
                            WHERE s.id = ?
                        ");
                
                
                
                        $stmt->bind_param("i", $_POST["s_id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $data = [];
                
                        if ($row = $result->fetch_assoc()) {
                            foreach ($row as $key => $value) {
                                $data[$key] = $value ?? '';
                            }
                        }
                        
                        echo json_encode($data);
                        $stmt->close();
                    }
                    break;
            
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method or action not specified.']);
}
?>