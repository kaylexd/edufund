<?php
include('includes/db.php'); // Include database connection

header('Content-Type: application/json'); // Set content type to JSON

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["action"])) {
    switch ($_POST["action"]) {
        

        case 'update_status':
            if (isset($_POST['s_id']) && isset($_POST['status'])) {
                if ($_POST['status'] === 'Approve') {
                    $stmt = $conn->prepare("UPDATE students SET s_scholar_status = 'Approved', is_scholar = 1 WHERE id = ?");
                } else {
                    $stmt = $conn->prepare("UPDATE students SET s_scholar_status = 'Rejected', is_scholar = 0 WHERE id = ?");
                }
                
                $stmt->bind_param("i", $_POST['s_id']);
                
                if ($stmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
                $stmt->close();
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
                            spcyincome = ?, sschool = ?, saward = ?, sreceive = ?, snote = ?
                        WHERE id = ?
                    ");
        
                    if ($update_stmt) {
                        $update_stmt->bind_param("ssssssssssssssssssi", 
                            $_POST["sid"], $_POST["sfname"], $_POST["smname"], $_POST["slname"], $_POST["sfix"], 
                            $_POST["sdbirth"], $_POST["sgender"], $_POST["sctship"], $_POST["saddress"], $_POST["semail"], 
                            $_POST["scontact"], $_POST["scourse"], $_POST["syear"], $_POST["spcyincome"], $_POST["school"], 
                            $_POST["saward"], $_POST["sreceive"], $_POST["snote"],
                            $studentId
                        );
        
                        if ($update_stmt->execute()) {
                            echo json_encode(['success' => 'Student Data Updated']);
                        } else {
                            echo json_encode(['error' => 'Error executing student update: ' . $update_stmt->error]);
                        }
                        $update_stmt->close();
                        
                    }
                }
                $check_stmt->close();
            }
            break;

        case 'acad_fetch_single':
            if (isset($_POST["s_id"])) {
                $stmt = $conn->prepare("
                    SELECT students.*, students.simg,
                           students.applied_on,
                           students.cert_file_path,
                           students.moral_file_path,
                           students.grades_file_path,
                           students.grad_file_path, 
                           family.sgfname, family.sgaddress, family.sgcontact, family.sgoccu, family.sgcompany,
                           family.sffname, family.sfaddress, family.sfcontact, family.sfoccu, family.sfcompany,
                           family.smfname, family.smaddress, family.smcontact, family.smoccu, family.smcompany
                    FROM students 
                    LEFT JOIN family ON students.id = family.student_id 
                    WHERE students.id = ?
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