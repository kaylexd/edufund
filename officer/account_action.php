<?php
include('../includes/db.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["action"])) {
    switch ($_POST["action"]) {
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

        case 'acad_fetch_single':
            if (isset($_POST["s_id"])) {
                $stmt = $conn->prepare("
                    SELECT students.*, students.simg
                    FROM students 
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
            }
            break;

        case 'edit_acad':
            $studentId = $_POST["acad_hidden_id"];
            
            // Check for duplicate email
            $check_stmt = $conn->prepare("SELECT id FROM students WHERE semail = ? AND id != ?");
            if ($check_stmt) {
                $check_stmt->bind_param("si", $_POST["semail"], $studentId);
                $check_stmt->execute();
                $result = $check_stmt->get_result();

                if ($result->num_rows > 0) {
                    echo json_encode(['error' => 'Email Address Already Exists']);
                } else {
                    // Update the student details
                    $update_stmt = $conn->prepare("
                        UPDATE students 
                        SET sid = ?, sfname = ?, slname = ?, semail = ?, account_status = ?
                        WHERE id = ?
                    ");

                    if ($update_stmt) {
                        $update_stmt->bind_param("sssssi", 
                            $_POST["sid"], 
                            $_POST["sfname"], 
                            $_POST["slname"], 
                            $_POST["semail"],
                            $_POST["account_status"],
                            $studentId
                        );

                        if ($update_stmt->execute()) {
                            echo json_encode(['success' => 'Student Data Updated']);
                        } else {
                            echo json_encode(['error' => 'Error executing student update']);
                        }
                        $update_stmt->close();
                    }
                }
                $check_stmt->close();
            }
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    $conn->close();
}
?>
