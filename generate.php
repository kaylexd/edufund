<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Fetch all registered students
$sql_all_students = "SELECT id, sfname, slname, s_scholar_status, s_account_status, applied_on, s_scholarship_type FROM students";
$result_all_students = $conn->query($sql_all_students);

if (!$result_all_students) {
    die("Query Failed: " . $conn->error);
}

// Fetch Approved students
$sql_approved_students = "SELECT id, slname FROM students WHERE s_scholar_status = 'Approved'";
$result_approved_students = $conn->query($sql_approved_students);

if (!$result_approved_students) {
    die("Query Failed: " . $conn->error);
}

// Fetch Rejected students
$sql_rejected_students = "SELECT id, slname FROM students WHERE s_scholar_status = 'Rejected'";
$result_rejected_students = $conn->query($sql_rejected_students);

if (!$result_rejected_students) {
    die("Query Failed: " . $conn->error);
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Generate Report</h6>
        <div class="mb-3">
            <button id="printButton" class="btn btn-primary">Print</button>
        </div>
    </div>
    <div class="card-body">
        <!-- Filters and Show Entries -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Show Entries -->
            <div class="dataTables_length">
                <label>
                    Show 
                    <select name="dataTable_length" aria-controls="dataTable" class="form-control form-control-sm" style="width: auto; display: inline-block;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </label>
            </div>

                 <!-- Approval Status Filter -->
    <label for="approvalFilter" class="mr-2">Approval Status:</label>
    <select id="approvalFilter" class="form-control form-control-sm mr-3" style="width: auto;">
        <option value="">All</option>
        <option value="Approved">Approved</option>
        <option value="Rejected">Rejected</option>
    </select>

            <!-- Filters -->
            <div class="d-flex align-items-center">
                <label for="scholarshipFilter" class="mr-2">Scholarship Type:</label>
                <select id="scholarshipFilter" class="form-control form-control-sm mr-3" style="width: auto;">
                    <option value="">All</option>
                    <option value="Academic">Academic</option>
                    <option value="Non-Academic">Non-Academic</option>
                    <option value="Unifast">Unifast</option>
                    <option value="Ched">Ched</option>
                </select>

                <label for="dateFilterStart" class="mr-2">Start Date:</label>
                <input type="date" id="dateFilterStart" class="form-control form-control-sm mr-3" style="width: auto;">

                <label for="dateFilterEnd" class="mr-2">End Date:</label>
                <input type="date" id="dateFilterEnd" class="form-control form-control-sm" style="width: auto;">
            </div>
        </div>

       

        <!-- Table Content -->
        <div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Last Name</th>
                <th>Scholarship Type</th>
                <th>Date</th>
                <th>Status</th> <!-- New Column for Approved/Rejected -->
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            // Use the correct variable: $result_all_students
            if ($result_all_students->num_rows > 0) {
                while ($row = $result_all_students->fetch_assoc()) {
                    echo "<tr>";
                    
                    // Last Name
                    echo "<td>" . (!empty($row['slname']) ? htmlspecialchars($row['slname']) : "") . "</td>";

                    // Scholarship Type (conditionally displayed, if it exists)
                    echo "<td class='scholarship-type'>" . (!empty($row['s_scholarship_type']) ? htmlspecialchars($row['s_scholarship_type']) : "N/A") . "</td>";

                    // Date (formatted, if applied_on exists)
                    if (!empty($row['applied_on'])) {
                        $formatted_date = date("Y-m-d", strtotime($row['applied_on']));
                        echo "<td class='applied-date'>" . htmlspecialchars($formatted_date) . "</td>";
                    } else {
                        echo "<td class='applied-date'>N/A</td>";
                    }

                    // Approval Status (Approved/Rejected)
                    $status = !empty($row['s_scholar_status']) ? htmlspecialchars($row['s_scholar_status']) : "N/A";
                    echo "<td class='approval-status'>" . $status . "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const approvalFilter = document.getElementById("approvalFilter");
    const scholarshipFilter = document.getElementById("scholarshipFilter");
    const dateFilterStart = document.getElementById("dateFilterStart");
    const dateFilterEnd = document.getElementById("dateFilterEnd");
    const tableBody = document.getElementById("tableBody");

    function filterTable() {
        const approvalValue = approvalFilter.value.toLowerCase();
        const scholarshipValue = scholarshipFilter.value.toLowerCase();
        const startDate = dateFilterStart.value ? new Date(dateFilterStart.value) : null;
        const endDate = dateFilterEnd.value ? new Date(dateFilterEnd.value) : null;

        Array.from(tableBody.rows).forEach(row => {
            const statusCell = row.querySelector(".approval-status").textContent.toLowerCase();
            const typeCell = row.querySelector(".scholarship-type").textContent.toLowerCase();
            const dateCell = row.querySelector(".applied-date").textContent;
            const rowDate = dateCell ? new Date(dateCell) : null;

            let showRow = true;

            // Filter by Approval Status
            if (approvalValue && !statusCell.includes(approvalValue)) {
                showRow = false;
            }

            // Filter by Scholarship Type
            if (scholarshipValue && !typeCell.includes(scholarshipValue)) {
                showRow = false;
            }

            // Filter by Date Range
            if (startDate && rowDate && rowDate < startDate) {
                showRow = false;
            }
            if (endDate && rowDate && rowDate > endDate) {
                showRow = false;
            }

            row.style.display = showRow ? "" : "none";
        });
    }

    // Attach event listeners
    approvalFilter.addEventListener("change", filterTable);
    scholarshipFilter.addEventListener("change", filterTable);
    dateFilterStart.addEventListener("change", filterTable);
    dateFilterEnd.addEventListener("change", filterTable);

        // Print button functionality
        document.getElementById("printButton").addEventListener("click", function() {
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Generate Report</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Generate Report</h1>');
            printWindow.document.write(document.querySelector('table').outerHTML); // Prints the table
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    });
</script>

<?php
include('includes/scripts.php');
?>

</div>
