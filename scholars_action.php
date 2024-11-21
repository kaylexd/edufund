<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/db.php');

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Student deleted successfully";
    } else {
        echo "Error deleting student: " . $conn->error;
    }
    $stmt->close();
}

// Main action handler
if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        
        case 'acad_fetch_single':
            $studentId = $_POST["s_id"];
            $data = fetchStudentData($conn, $studentId);
            echo json_encode($data);
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
            
            
            
                
            case 'edit_acad':
                $error = '';
                $success = '';
                $studentId = $_POST["acad_hidden_id"];
                $data = [];
            
                // Check for duplicate email
                $check_stmt = $conn->prepare("SELECT id FROM students WHERE semail = ? AND id != ?");
                if ($check_stmt) {
                    $check_stmt->bind_param("si", $_POST["semail"], $studentId);
                    $check_stmt->execute();
                    $result = $check_stmt->get_result();
            
                    if ($result->num_rows > 0) {
                        $error = 'Email Address Already Exists';
                    } else {
                        // Update the student details
                        $update_stmt = $conn->prepare("
                            UPDATE students 
                            SET sid = ?, sfname = ?, smname = ?, slname = ?, sfix = ?, sdbirth = ?, sgender = ?, 
                                sctship = ?, saddress = ?, semail = ?, scontact = ?, scourse = ?, syear = ?, 
                                spcyincome = ?, sschool = ?, saward = ?, sreceive = ?, snote = ?, 
                                s_scholar_status = ?
                            WHERE id = ?
                        ");
            
                        if ($update_stmt) {
                            $update_stmt->bind_param("sssssssssssssssssssi", 
                                $_POST["sid"], $_POST["sfname"], $_POST["smname"], $_POST["slname"], $_POST["sfix"], 
                                $_POST["sdbirth"], $_POST["sgender"], $_POST["sctship"], $_POST["saddress"], $_POST["semail"], 
                                $_POST["scontact"], $_POST["scourse"], $_POST["syear"], $_POST["spcyincome"], $_POST["sschool"], 
                                $_POST["saward"], $_POST["sreceive"], $_POST["snote"], $_POST["s_scholar_status"], 
                                $studentId
                            );
            
                            if ($update_stmt->execute()) {
                                $success = $update_stmt->affected_rows > 0 ? 'Student Data Updated' : 'No changes were made to student data.';
                            } else {
                                $error = 'Error executing student update: ' . $update_stmt->error;
                            }
                            $update_stmt->close();
                        } else {
                            $error = 'Error preparing student update statement: ' . $conn->error;
                        }
            
                        // Update family details if there are no student errors
                        if (empty($error)) {
                            $family_stmt = $conn->prepare("
                                UPDATE family 
                                SET sgfname = ?, sgaddress = ?, sgcontact = ?, sgoccu = ?, sgcompany = ?, 
                                    sffname = ?, sfaddress = ?, sfcontact = ?, sfoccu = ?, sfcompany = ?, 
                                    smfname = ?, smaddress = ?, smcontact = ?, smoccu = ?, smcompany = ?
                                WHERE student_id = ?
                            ");
            
                            if ($family_stmt) {
                                $family_stmt->bind_param("sssssssssssssssi", 
                                    $_POST["sgfname"], $_POST["sgaddress"], $_POST["sgcontact"], $_POST["sgoccu"], $_POST["sgcompany"],
                                    $_POST["sffname"], $_POST["sfaddress"], $_POST["sfcontact"], $_POST["sfoccu"], $_POST["sfcompany"],
                                    $_POST["smfname"], $_POST["smaddress"], $_POST["smcontact"], $_POST["smoccu"], $_POST["smcompany"],
                                    $studentId
                                );
            
                                if ($family_stmt->execute()) {
                                    $success .= ($family_stmt->affected_rows > 0 ? ' Family Data Updated.' : ' No changes made to family data.');
                                } else {
                                    $error = 'Error executing family update: ' . $family_stmt->error;
                                }
                                $family_stmt->close();
                            } else {
                                $error = 'Error preparing family update statement: ' . $conn->error;
                            }
                        }
                    }
                    $check_stmt->close();
                } else {
                    $error = 'Error preparing email check statement: ' . $conn->error;
                }
            
                // Send JSON response including success and error messages
                echo json_encode(['error' => $error, 'success' => $success, 'data' => $data]);
                break;
            

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    $conn->close();
}

// Helper function to fetch student and family data
function fetchStudentData($conn, $studentId) {
    $stmt = $conn->prepare("
        SELECT students.*, 
               family.sgfname, family.sgaddress, family.sgcontact, family.sgoccu, family.sgcompany,
               family.sffname, family.sfaddress, family.sfcontact, family.sfoccu, family.sfcompany,
               family.smfname, family.smaddress, family.smcontact, family.smoccu, family.smcompany
        FROM students 
        LEFT JOIN family ON students.id = family.student_id 
        WHERE students.id = ?
    ");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];

    if ($row = $result->fetch_assoc()) {
        // Populate student details
        foreach ($row as $key => $value) {
            $data[$key] = $value ?? ''; // Assign empty string for NULL values
        }
    } else {
        // Handle case where student ID does not exist
        $data['error'] = 'No data found for the provided student ID.';
    }

    $stmt->close();
    return $data;
    
}
