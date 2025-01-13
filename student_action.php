<?php
include('includes/db.php');

$query = "SELECT semail FROM students";
$result = $conn->query($query);
$emails = array();

while($row = $result->fetch_assoc()) {
    $emails[] = $row['semail'];
}

echo implode(', ', $emails);
?>
