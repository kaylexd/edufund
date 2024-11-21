<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Get filter parameters from the URL
$scholarshipFilter = isset($_GET['scholarship']) ? $_GET['scholarship'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Build SQL query based on the filters
$sql = "SELECT id, sid, sfname, applied_on, slname, s_scholar_status, s_account_status, s_scholarship_type  
        FROM students 
        WHERE is_scholar = 1 AND s_account_status = 'Valid'";

if ($scholarshipFilter) {
    $sql .= " AND s_scholarship_type LIKE '%" . $conn->real_escape_string($scholarshipFilter) . "%'";
}

if ($startDate && $endDate) {
    $sql .= " AND applied_on BETWEEN '$startDate' AND '$endDate'";
} elseif ($startDate) {
    $sql .= " AND applied_on >= '$startDate'";
} elseif ($endDate) {
    $sql .= " AND applied_on <= '$endDate'";
}

$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Print Report</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Last Name</th>
                            <th>Scholarship Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                // Last Name
                                echo "<td>" . (!empty($row['slname']) ? htmlspecialchars($row['slname']) : "") . "</td>";

                                // Scholarship Type
                                echo "<td>" . (!empty($row['s_scholarship_type']) ? htmlspecialchars($row['s_scholarship_type']) : "") . "</td>";

                                // Date (formatted)
                                if (!empty($row['applied_on'])) {
                                    $formatted_date = date("Y-m-d", strtotime($row['applied_on'])); // Standardized format for filtering
                                    echo "<td>" . htmlspecialchars($formatted_date) . "</td>";
                                } else {
                                    echo "<td></td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Automatically trigger print once page is fully loaded
        window.print();
    });
</script>

<?php
include('includes/scripts.php');
?>

</div>
