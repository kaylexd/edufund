<?php
include('includes/db.php');

if ($_POST['action'] === 'update_scholarship') {
    $scholarship_id = $_POST['scholarship_id'];
    $status = $_POST['status'];
    $type = $_POST['type'];

    $sql = "UPDATE scholarships SET status = ?, type = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $status, $type, $scholarship_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
