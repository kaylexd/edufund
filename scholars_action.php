<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/db.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["action"])) {
    switch ($_POST["action"]) {
        
        case 'send_announcement_all':
            $query = "INSERT INTO announcements (student_id, subject, message) 
                      SELECT id, ?, ? FROM students";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $_POST['subject'], $_POST['announcement']);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }
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
                        $stmt = $conn->prepare("
                        UPDATE admin_status
                        SET s_scholar_status = ?
                        WHERE student_id = ?
                    ");
                    $stmt->bind_param("si", 
                        $_POST["s_scholar_status"], 
                        $studentId
                    );
                    $stmt->execute();
                
                        $conn->commit();
                        echo json_encode(['success' => 'Student Data Updated']);
                
                    } catch (Exception $e) {
                        $conn->rollback();
                        echo json_encode(['error' => $e->getMessage()]);
                    }
                    break;

                    case 'add_acad':
                        // Start transaction
                        $conn->begin_transaction();
                        try {
                            // Insert into students table
                            $stmt = $conn->prepare("
                                INSERT INTO students (sid, sfname, smname, slname, sfix, 
                                    sdbirth, sgender, sctship, saddress, semail, 
                                    scontact, scourse, syear)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ");
                            $stmt->bind_param("sssssssssssss",
                                $_POST["sid"], $_POST["sfname"], $_POST["smname"], $_POST["slname"],
                                $_POST["sfix"], $_POST["sdbirth"], $_POST["sgender"], $_POST["sctship"],
                                $_POST["saddress"], $_POST["semail"], $_POST["scontact"], 
                                $_POST["scourse"], $_POST["syear"]
                            );
                            $stmt->execute();
                    
                            // Get the last inserted student ID
                            $studentId = $conn->insert_id;
                    
                            // Insert into s_family table
                            $stmt = $conn->prepare("
                                INSERT INTO s_family (student_id, sffname, sfaddress, sfcontact, sfoccu, 
                                    sfcompany, smfname, smaddress, smcontact, smoccu, 
                                    smcompany, sgfname, sgaddress, sgcontact, sgoccu, 
                                    sgcompany, spcyincome)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ");
                            $stmt->bind_param("isssssssssssssssi",
                                $studentId,
                                $_POST["sffname"], $_POST["sfaddress"], $_POST["sfcontact"], 
                                $_POST["sfoccu"], $_POST["sfcompany"],
                                $_POST["smfname"], $_POST["smaddress"], $_POST["smcontact"], 
                                $_POST["smoccu"], $_POST["smcompany"],
                                $_POST["sgfname"], $_POST["sgaddress"], $_POST["sgcontact"], 
                                $_POST["sgoccu"], $_POST["sgcompany"],
                                $_POST["spcyincome"]
                            );
                            $stmt->execute();
                    
                            // Insert into scholarship_applications table
                            $stmt = $conn->prepare("
                                INSERT INTO scholarship_applications (student_id, s_scholarship_type, s_account_status)
                                VALUES (?, 'Academic', 'Pending')
                            ");
                            $stmt->bind_param("i", $studentId);
                            $stmt->execute();
                    
                            $scholarshipApplicationId = $conn->insert_id;
                    
                            // Insert into applications table
                            $stmt = $conn->prepare("
                                INSERT INTO applications (scholarship_application_id, sschool, saward, sreceive)
                                VALUES (?, ?, ?, ?)
                            ");
                            $stmt->bind_param("isss",
                                $scholarshipApplicationId,
                                $_POST["sschool"], $_POST["saward"], $_POST["sreceive"]
                            );
                            $stmt->execute();
                            
                            // Insert into officer table
                            $stmt = $conn->prepare("
                            INSERT INTO officer (student_id, account_status)
                            VALUES (?, 'Active')
                            ");
                            $stmt->bind_param("i", $studentId);
                            $stmt->execute();

                            // Insert into admin_status table
                            $stmt = $conn->prepare("
                                INSERT INTO admin_status (student_id, is_scholar, s_scholar_status)
                                VALUES (?, 1, 'Approved')
                            ");
                            $stmt->bind_param("i", $studentId);
                            $stmt->execute();
                    
                            $conn->commit();
                            echo json_encode(['success' => 'Student Data Added']);
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
                               a.moral_file_path_non_acad, a.indigency_file, a.medical_file,
                               ast.s_scholar_status
                        FROM students s
                        LEFT JOIN scholarship_applications sa ON s.id = sa.student_id
                        LEFT JOIN s_family f ON s.id = f.student_id
                        LEFT JOIN applications a ON sa.id = a.scholarship_application_id
                        LEFT JOIN admin_status ast ON s.id = ast.student_id
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
            } else {
                echo json_encode(['error' => 'Student ID not provided for academic fetch.']);
            }
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method or action not specified.']);
}
?>