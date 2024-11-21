<?php
session_start();
include('../includes/db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// If a POST request is made to mark notifications as read
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mark_read') {
    $sql_update = "UPDATE announcements SET is_read = 1 WHERE student_id = ? AND is_read = 0";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $user_id);

    if ($stmt_update->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to mark notifications as read']);
    }

    $stmt_update->close();
    exit();
}

// Count unread notifications
$sql_count = "SELECT COUNT(*) as count FROM announcements WHERE student_id = ? AND is_read = 0";
$stmt_count = $conn->prepare($sql_count);
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$count_result = $stmt_count->get_result();
$count = $count_result->fetch_assoc()['count'];

// Fetch all notifications (read and unread)
$sql_notifications = "SELECT id, subject, message, created_at, is_read FROM announcements WHERE student_id = ? ORDER BY created_at DESC LIMIT 5";
$stmt_notifications = $conn->prepare($sql_notifications);
$stmt_notifications->bind_param("i", $user_id);
$stmt_notifications->execute();
$notifications_result = $stmt_notifications->get_result();

$notifications = '';
while ($row = $notifications_result->fetch_assoc()) {
    $read_class = $row['is_read'] ? 'text-gray-500' : 'font-weight-bold'; // Different styling for read vs unread
    $notifications .= "<div class='dropdown-item'>";
    $notifications .= "<div class='$read_class'>" . htmlspecialchars($row['subject']) . "</div>";
    $notifications .= htmlspecialchars($row['message']);
    $notifications .= "<div class='small text-gray-500'>" . $row['created_at'] . "</div>";
    $notifications .= "</div>";
}

// Output as JSON for AJAX
echo json_encode([
    'count' => $count,
    'notifications' => $notifications,
]);
?>
