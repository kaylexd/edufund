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
                
                // Start transaction
                $conn->begin_transaction();
                try {
                    // Update students table
                    $update_stmt = $conn->prepare("
                        UPDATE students 
                        SET sid = ?, sfname = ?, slname = ?, semail = ?
                        WHERE id = ?
                    ");
                    $update_stmt->bind_param("ssssi", 
                        $_POST["sid"], 
                        $_POST["sfname"], 
                        $_POST["slname"], 
                        $_POST["semail"],
                        $studentId
                    );
                    $update_stmt->execute();
            
                    // Update officer table for account_status
                    $officer_stmt = $conn->prepare("
                        UPDATE officer 
                        SET account_status = ?
                        WHERE student_id = ?
                    ");
                    $officer_stmt->bind_param("si", 
                        $_POST["account_status"],
                        $studentId
                    );
                    $officer_stmt->execute();
            
                    $conn->commit();
                    echo json_encode(['success' => 'Student Data Updated']);
            
                } catch (Exception $e) {
                    $conn->rollback();
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;
            

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    $conn->close();
}
?>
