<?php
include('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update_scholarship') {
    $scholarship_id = $_POST['scholarship_id'];
    $status = $_POST['status'];

    // Update the database
    $sql = "UPDATE scholarship_status SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $scholarship_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
