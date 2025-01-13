<?php
include('../includes/db.php');


$sql = "SELECT s.id, s.sfname, s.slname, s.sid, s.semail, o.account_status 
        FROM students s
        LEFT JOIN officer o ON s.id = o.student_id
        LEFT JOIN admin_status a ON s.id = a.student_id
        WHERE (a.is_scholar = 0 OR a.is_scholar IS NULL)";



$result = $conn->query($sql);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>   

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Officer</title>

  <!-- Custom fonts -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../vendor/fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Parsley.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- Custom scripts -->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../js/demo/datatables-demo.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


  
   <!-- Sidebar -->
   <ul class="navbar-nav bg-gray-700 sidebar sidebar-dark accordion" id="accordionSidebar">



<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div class="sidebar-brand-icon">
  <img src="../img/logo.png" alt="logo">
  </div>
  <div class="sidebar-brand-text mx-3">SCC</div>
</a>


<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="index.php">
  <i class="fa-solid fa-house"></i>
    <span>Dashboard</span></a>
</li>


<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="students.php">
  <i class="fa-solid fa-address-card"></i>
    <span>Applicants</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="account.php">
  <i class="fa-solid fa-users"></i>
    <span>Students</span></a>
</li>

<!-- Heading 
<div class="sidebar-heading">
  Interface
</div>
  -->


</ul>
<!-- End of Sidebar -->
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-dark navbar-crimson topbar mb-4 static-top shadow">

          

          

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

          
            
            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-white small">
                  
               Officer
                  
                </span>
                <img class="img-profile rounded-circle" src="../img/undraw_profile_1.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        
 
  
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <form action="../home.php" method="POST"> 
          
            <button type="submit" name="logout_btn" class="btn btn-primary">Logout</button>

          </form>


        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-gray">Students Management</h6>
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
                <!-- Add Acad Modal -->
	<div id="acadModal" class="modal fade">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<form method="post" id="acad_form">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="acadmodal_title">Add Academic Scholar</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<span id="form_message"></span>
						<div class="form-group">
							<div class="card">
							<div class="card-header" style="font-weight: bold; font-size: 18px;">Student ID Details</div>
								<div class="card-body">
								<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
									<label>Student ID NO.<span class="text-danger"></span></label>
									<input type="text" name="sid" id="sid" class="form-control" readonly />
									<span id="error_sid" class="text-danger"></span>
								</div>
								</div>
							</div>
						</div>
						<div class="form-group">
                        <div class="card">
                            <div class="card-header" style="font-weight: bold; font-size: 18px;">Personal Details</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <label>First Name<span class="text-danger"></span></label>
                                            <input type="text" name="sfname" id="sfname" class="form-control" readonly/>
                                            <span id="error_sfname" class="text-danger"></span>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <label>Last Name<span class="text-danger"></span></label>
                                            <input type="text" name="slname" id="slname" class="form-control" readonly/>
                                            <span id="error_slname" class="text-danger"></span>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-5">
                                            <label>Email Address<span class="text-danger"></span></label>
                                            <input type="text" name="semail" id="semail" class="form-control" readonly/>
                                            <span id="error_semail" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

						<div class="form-group">
							<div class="card">
                            <div class="card-header" style="font-weight: bold; font-size: 18px;">Student Status</div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <label for="account_status">Account Status</label>
                                        <select class="form-control" id="account_status" name="account_status" required>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="acad_hidden_id" id="acad_hidden_id" />
						<input type="hidden" name="action" id="acad_action" value="add_acad" />
						<input type="submit" name="submit" id="acad_submit_button" class="btn btn-success" value="Add" />
						<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>




                <!-- View Acad Modal -->
<div id="viewacadModal" class="modal fade">
		<div class="modal-dialog modal-dialog-scrollable custom-modal">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title">View Student Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" id="acad_details">
                <div class="form-group">
        <input type="file" class="form-control-file" name="cert_file" id="certFile" accept="image/*">
        <div class="mt-2">
            <a href="#" class="preview-link" onclick="window.open(document.getElementById('certPreview').src, '_blank'); return false;" style="display: none;">View Full Image</a>
            <img id="certPreview" class="img-fluid mt-2" style="max-height: 200px; display: none;">
        </div>
    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


            </table>
        </div>
    </div>
</div>
</div>


  </div>
  <!-- End of Main Content -->

  <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
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




        $(document).on('click', '.edit_button', function() {
    console.log('Edit button clicked!');

    var s_id = $(this).data('id');
    console.log('Selected Student ID:', s_id);

    // Reset form and validation
    $('#acad_form')[0].reset();
    $('#acad_form').parsley().reset();
    $('#form_message').html('');

    // AJAX request to fetch single student details
    $.ajax({
        url: "account_action.php",
        method: "POST",
        data: { s_id: s_id, action: 'acad_fetch_single' },
        dataType: 'JSON',
        success: function(data) {
            console.log('Data received from server:', data);

            // Set form fields with data from server
            $('#sid').val(data.sid);
            $('#sfname').val(data.sfname);
            $('#slname').val(data.slname);
            $('#semail').val(data.semail);

            // Set modal and hidden field values
            $('#acadModal').modal('show');
            $('#acadmodal_title').text('Edit Academic Scholar Info');
            $('#acad_hidden_id').val(s_id);
            $('#acad_action').val('edit_acad');
            $('#acad_submit_button').val('Edit');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            console.log('Response Text:', xhr.responseText);
            $('#form_message').html('Error fetching data. Please try again.');
        }
    });
});

// Handle form submission
$(document).ready(function() {
    // Initialize DataTable with a variable reference
    var dataTable = $('#dataTable').DataTable();

    // In your form submission success callback
    $('#acad_form').on('submit', function(event) {
    event.preventDefault();

    if ($('#acad_form').parsley().isValid()) {
        $('#acad_submit_button').val('Processing...').attr('disabled', true);

        $.ajax({
            url: "account_action.php",
            method: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#acad_submit_button').attr('disabled', false).val('Edit');
                if (response.error) {
                    $('#form_message').html(response.error);
                } else {
                    $('#acadModal').modal('hide');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                $('#form_message').html('An error occurred. Please try again.');
                $('#acad_submit_button').attr('disabled', false).val('Edit');
                console.log('Response Text:', xhr.responseText);
            }
        });
    }
});



});

         // Delete Action
         $(document).on('click', '.delete_button', function() {
    var id = $(this).data('id');
    if (confirm("Are you sure you want to delete this student?")) {
        $.ajax({
            url: 'students_action.php',
            type: 'POST',
            data: { id: id, action: 'delete' }, // Change this line
            success: function(response) {
                alert('Student deleted successfully.');
                location.reload();
            },
            error: function() {
                alert('Failed to delete student. Please try again.');
            }
        });
    }
});



    $('input[type="file"]').change(function(e) {
    let file = e.target.files[0];
    let reader = new FileReader();
    let modal = $(this).closest('.modal');
    let previewImg = modal.find('img');
    let previewLink = modal.find('.preview-link');
    
    reader.onload = function(e) {
        previewImg.attr('src', e.target.result).show();
        previewLink.show();
    }
    
    if (file) {
        reader.readAsDataURL(file);
    }
});


      // View Function
$(document).on('click', '.view_button', function() {
    var s_id = $(this).data('id');
    $.ajax({
        url: "account_action.php",
        method: "POST",
        data: { s_id: s_id, action: 'acad_fetch_single' },
        dataType: 'JSON',
        success: function(data) {
            // Check if data is not null
            if (data) {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';
                 // Student ID Details
                 html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Student ID Details</th><td width="60%"></td></tr>';

                html += '<tr><th width="40%" >Student ID No.</th><td width="60%">' + data.sid + '</td></tr>';
                // Personal Details
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Personal Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >First Name</th><td width="60%">' + data.sfname + '</td></tr>';
                
                html += '<tr><th width="40%" >Last Name</th><td width="60%">' + data.slname + '</td></tr>';
                
                html += '<tr><th width="40%" >Email Address</th><td width="60%">' + data.semail + '</td></tr>';
                
                
                // Study Load Image 
                html += '<tr><th width="40%" class="text-left" style="font-size:20px">Study Load</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%">Study Load Image</th><td width="60%"><a href="../' + data.simg + '" target="_blank">View Study Load</a></td></tr>';



                // Populate the modal with the generated HTML
                $('#acad_details').html(html);
                // Show the modal
                $('#viewacadModal').modal('show');

            } else {
                alert("No data found for this student.");
            }
        },
        error: function(xhr, status, error) {
            alert("An error occurred: " + xhr.responseText);
        }
    });
});

    });

</script>

</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

</body>

</html>