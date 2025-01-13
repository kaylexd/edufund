<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

$sql = "SELECT s.id, s.sfname, s.slname, s.sid, s.semail, o.account_status, sa.s_scholarship_type 
        FROM students s
        LEFT JOIN officer o ON s.id = o.student_id
        LEFT JOIN admin_status a ON s.id = a.student_id
        LEFT JOIN scholarship_applications sa ON s.id = sa.student_id
        WHERE (sa.s_scholarship_type IS NULL) 
        AND (a.is_scholar = 0 OR a.is_scholar IS NULL)
        AND o.account_status = 'Active'";


$result = $conn->query($sql);


if (!$result) {
    die("Query Failed: " . $conn->error);  // Show a more detailed error message if the query fails
}
?>                    

<div class="container-fluid">
<!-- DataTables Example -->
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex justify-content-between align-items-center">
<h6 class="m-0 font-weight-bold text-bg-gray">Students</h6>
    <div>
	<div class="btn-group">
</div>

        <button type="button" class="btn btn-primary btn-sm email_button">
            <i class="fas fa-envelope"></i>
        </button>
		<button type="button" class="btn btn-success btn-sm announcement_button">
            <i class="fas fa-bullhorn"></i>
        </button>
    </div>
</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
            <th>Student ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Account Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['sid']) . "</td>";
            echo "<td>" . htmlspecialchars($row['slname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['sfname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['semail']) . "</td>";
            echo "<td>" . htmlspecialchars($row['account_status']) . "</td>";
            echo "<td>
                <div class='d-flex'>
                    <button type='button' class='btn btn-info btn-sm view_button mr-1' data-id='" . $row['id'] . "'>
                        <i class='fa-regular fa-eye'></i>
                    </button>
                    <button type='button' class='btn btn-success btn-sm edit_button mr-1' data-id='" . $row['id'] . "'>
                        <i class='fa-solid fa-pen-to-square'></i>
                    </button>
                    <button type='button' class='btn btn-danger btn-sm delete_button' data-id='" . $row['id'] . "'>
                        <i class='fa-regular fa-circle-xmark'></i>
                    </button>
                </div>
            </td>";
            echo "</tr>";
        }
    }
    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
            

		<!-- Announcement Modal -->
		<div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">Send Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="announcementForm">
                    <div class="form-group">
                        <label>Message:</label>
                        <div class="announcement-text-wrapper" style="max-height: 200px; overflow-y: auto;">
                            <textarea class="form-control" id="announcement_text" rows="4" style="resize: vertical; min-height: 100px; max-height: 100%;" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="send_announcement">Send</button>
            </div>
        </div>
    </div>
</div>


					<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="emailForm">
                    <div class="form-group">
                        <label>To:</label>
                        <input type="text" class="form-control" id="email_recipients" readonly>
                    </div>
                    <div class="form-group">
                        <label>Subject:</label>
                        <input type="text" class="form-control" id="email_subject" required>
                    </div>
                    <div class="form-group">
                        <label>Message:</label>
                        <div class="email-text-wrapper" style="max-height: 200px; overflow-y: auto;">
                            <textarea class="form-control" id="email_message" rows="4" style="resize: vertical; min-height: 100px; max-height: 100%;" required></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="send_email">Send</button>
            </div>
        </div>
    </div>
</div>


				
                <script>
					$(document).ready(function() {
    $('#acad_form').parsley(); // Initialize Parsley
    console.log("Parsley initialized for acad_form");
});

                $(document).ready(function() {
                    $('#dataTable').DataTable();  // Initialize DataTables
                });

                $(document).ready(function() {
                    // Select all checkbox
                    $('#select_all').click(function() {
                        $('.select_row').prop('checked', this.checked);
                    });

                    $('.select_row').click(function() {
                        if (!$(this).is(':checked')) {
                            $('#select_all').prop('checked', false);
                        }
                    });
                });

				$('.dropdown-toggle').dropdown();
				

				// Announcement button click handler
$(document).on('click', '.announcement_button', function() {
    $('#announcementModal').modal('show');
});

$('#send_announcement').click(function() {
    var subject = $('#announcement_subject').val();
    var announcement = $('#announcement_text').val();
    
    $.ajax({
        url: 'scholars_action.php',
        method: 'POST',
        data: {
            action: 'send_announcement_all',
            subject: subject,
            announcement: announcement
        },
        success: function(response) {
            $('#announcementModal').modal('hide');
            alert('Announcement sent successfully to all students!');
            $('#announcement_subject').val('');
            $('#announcement_text').val('');
        },
        error: function() {
            alert('Failed to send announcement');
        }
    });
});





				// Email button click handler
$(document).on('click', '.email_button', function() {
    $.ajax({
        url: 'student_action.php',
        method: 'GET',
        success: function(response) {
            $('#email_recipients').val(response);
            $('#emailModal').modal('show');
        }
    });
});

$('#send_email').click(function() {
    var recipients = $('#email_recipients').val();
    var subject = $('#email_subject').val();
    var message = $('#email_message').val();
    
    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...').prop('disabled', true);
    
    $.ajax({
        url: 'send.php',
        method: 'POST',
        data: {
            recipients: recipients,
            subject: subject,
            message: message
        },
        success: function(response) {
            $('#emailModal').modal('hide');
            alert('Email sent successfully to all students!');
            $('#email_subject').val('');
            $('#email_message').val('');
        },
        complete: function() {
            $('#send_email').html('Send').prop('disabled', false);
        }
    });
});



                </script>

<?php
include('includes/scripts.php');
?>