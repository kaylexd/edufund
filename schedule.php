<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Fetch scholarships
$sql_scholarships = "SELECT id, scholarship_name, status FROM scholarship_status";
$result_scholarships = $conn->query($sql_scholarships);

if (!$result_scholarships) {
    die("Query Failed: " . $conn->error);
}

// Fetch scholarships for dropdown
$dropdown_scholarships = [];
while ($row = $result_scholarships->fetch_assoc()) {
    $dropdown_scholarships[] = $row;
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-bg-gray">Scholarship Management</h6>
            <!-- Manage Slots Button -->
            <button type="button" class="btn btn-primary btn-sm manage_slots_button">
                <i class="fas fa-cog"></i> Manage Slots
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="scholarshipTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Scholarship</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($dropdown_scholarships as $row) {
                            echo "<tr data-id='" . htmlspecialchars($row['id']) . "'>";
                            echo "<td>" . htmlspecialchars($row['scholarship_name']) . "</td>";
                            echo "<td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Manage Scholarships Modal -->
    <div class="modal fade" id="manageSlotsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Scholarship</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="slotsForm">
                        <input type="hidden" id="scholarship_id" name="scholarship_id">
                        <div class="form-group">
    <label>Scholarship Name</label>
    <select class="form-control" id="scholarship_name" name="scholarship_name" required>
        <!-- Populate the dropdown options dynamically -->
        <?php foreach ($dropdown_scholarships as $option) : ?>
            <option value="<?= htmlspecialchars($option['id']) ?>">
                <?= htmlspecialchars($option['scholarship_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="scholarship_status" name="scholarship_status" required>
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveSlots">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).on('click', '.manage_slots_button', function () {
    const firstRow = $('#scholarshipTable tbody tr:first'); // Get the first row (or any row you want to edit)
    const scholarshipId = firstRow.data('id'); // Get scholarship ID
    const scholarshipStatus = firstRow.find('td:nth-child(2)').text().trim().toLowerCase(); // Get status

    // Populate the dropdown and set the selected value
    $('#scholarship_name').val(scholarshipId); // Set the dropdown value for the selected scholarship
    $('#scholarship_status').val(scholarshipStatus); // Set the status dropdown value
    $('#manageSlotsModal').modal('show'); // Open the modal
});

$('#saveSlots').click(function () {
    const scholarshipId = $('#scholarship_name').val(); // Get selected scholarship ID
    const scholarshipStatus = $('#scholarship_status').val(); // Get selected status

    // Send AJAX request to update the scholarship
    $.ajax({
        url: 'schedule_action.php',
        method: 'POST',
        data: {
            action: 'update_scholarship',
            scholarship_id: scholarshipId,
            status: scholarshipStatus
        },
        success: function (response) {
            try {
                const res = JSON.parse(response);
                if (res.success) {
                    alert('Scholarship updated successfully!');
                    $('#manageSlotsModal').modal('hide'); // Close the modal
                    location.reload(); // Reload the table to reflect changes
                } else {
                    alert('Update failed: ' + res.error);
                }
            } catch (error) {
                console.error('Error parsing response:', error);
                alert('An unexpected error occurred.');
            }
        },
        error: function () {
            alert('Error in AJAX request.');
        }
    });
});

</script>

<?php
include('includes/scripts.php');
?>
