<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Fetch scholarships
$sql_scholarships = "SELECT id, scholarship_name, status, type FROM scholarships";
$result_scholarships = $conn->query($sql_scholarships);

if (!$result_scholarships) {
    die("Query Failed: " . $conn->error);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Scholarship Management</h6>
        <button type="button" class="btn btn-warning btn-sm manage_slots_button">
            <i class="fas fa-cog"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Scholarship</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_scholarships->num_rows > 0) {
                        while ($row = $result_scholarships->fetch_assoc()) {
                            echo "<tr>";
                            // Scholarship Name
                            echo "<td>" . htmlspecialchars($row['scholarship_name']) . "</td>";

                            // Open/Closed Status
                            echo "<td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data available</td></tr>";
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
                <h5 class="modal-title">Manage Scholarship</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="slotsForm">
                    <input type="hidden" id="scholarship_id" name="scholarship_id">
                    <div class="form-group">
                        <label>Scholarship Name</label>
                        <input type="text" class="form-control" id="scholarship_name" name="scholarship_name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="scholarship_status" name="scholarship_status" required>
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="scholarship_type" name="scholarship_type" required>
                            <option value="Academic">Academic</option>
                            <option value="Non-Academic">Non-Academic</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSlots">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Edit Scholarship Modal
    $('.manage_slots_button').click(function() {
        const row = $(this).closest('tr');
        const scholarshipId = row.data('id');
        const scholarshipName = row.find('td:nth-child(1)').text();
        const scholarshipStatus = row.find('td:nth-child(2)').text().toLowerCase();

        $('#scholarship_id').val(scholarshipId);
        $('#scholarship_name').val(scholarshipName);
        $('#scholarship_status').val(scholarshipStatus);
        $('#manageSlotsModal').modal('show');
    });

    // Save Scholarship Changes
    $('#saveSlots').click(function() {
        const scholarshipId = $('#scholarship_id').val();
        const scholarshipStatus = $('#scholarship_status').val();
        const scholarshipType = $('#scholarship_type').val();

        $.ajax({
            url: 'schedule_action.php',
            method: 'POST',
            data: {
                action: 'update_scholarship',
                scholarship_id: scholarshipId,
                status: scholarshipStatus,
                type: scholarshipType
            },
            success: function(response) {
                alert('Scholarship updated successfully');
                $('#manageSlotsModal').modal('hide');
                location.reload();
            }
        });
    });
</script>

<?php
include('includes/scripts.php');
?>
