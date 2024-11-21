<?php
include('../includes/db.php');


$sql = "SELECT id, sfname, semail, slname, sid, scourse, syear, sfix, sdbirth, sgender, sctship, saddress, scontact, simg, s_scholar_status, s_account_status, s_scholarship_type
        FROM students 
        WHERE is_scholar = 0 AND account_status = 'Active'";


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
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">



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
  <i class="fa-solid fa-users"></i>
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
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          

          

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

          
            
            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  
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
<div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Application Management</h6>
        <button type="button" class="btn btn-success btn-sm announcement_button">
            <i class="fas fa-bullhorn"></i>
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="select_all" id="select_all" /></th>
                        <th>Student ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Email</th>
                        <th>Scholarship Type</th>
                        <th>Application Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='select_row' class='select_row' /></td>";
                        echo "<td>" . (!empty($row['sid']) ? htmlspecialchars($row['sid']) : "") . "</td>";
                        echo "<td>" . (!empty($row['slname']) ? htmlspecialchars($row['slname']) : "") . "</td>";
                        echo "<td>" . (!empty($row['sfname']) ? htmlspecialchars($row['sfname']) : "") . "</td>";
                        echo "<td>" . (!empty($row['semail']) ? htmlspecialchars($row['semail']) : "") . "</td>";
                        echo "<td>" . (!empty($row['s_scholarship_type']) ? htmlspecialchars($row['s_scholarship_type']) : "") . "</td>";
                        echo "<td class='text-center'>";
                        if (!empty($row['s_account_status'])) {
                            $status = $row['s_account_status'];
                            if ($status === 'Valid') {
                                echo "<span class='badge badge-success d-inline-block w-75' style='font-size: 14px; padding: 8px 12px;'>Valid</span>";
                            } else if ($status === 'Invalid') {
                                echo "<span class='badge badge-danger d-inline-block w-75' style='font-size: 14px; padding: 8px 12px;'>Invalid</span>";
                            } else {
                                echo "<span class='badge badge-primary d-inline-block w-75' style='font-size: 14px; padding: 8px 12px;'>Pending</span>";
                            }
                        } 
                        echo "</td>";
                        
                        
                        echo "<td>
                            <div class='d-flex'>
                                <button type='button' class='btn btn-info btn-sm view_button mr-1' data-id='" . $row['id'] . "'>
                                    <i class='fa-regular fa-eye'></i>
                                </button>
                
                                 <!-- Edit Button with Icon -->
                         <button type='button' class='btn btn-success btn-sm edit_button mr-1' data-id='" . $row['id']  . "'>
                             <i class='fa-solid fa-pen-to-square'></i>
                         </button>
                                <button type='button' class='btn btn-danger btn-sm delete_button' data-id='" . $row['id'] . "'>
                                    <i class='fa-regular fa-circle-xmark'></i>
                                </button>
                            </div>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No data available</td></tr>";
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
									<label>Student ID NO.<span class="text-danger">*</span></label>
									<input type="text" name="sid" id="sid" class="form-control" required />
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
									<label>First Name<span class="text-danger">*</span></label>
									<input type="text" name="sfname" id="sfname" class="form-control" required/>
									<span id="error_sfname" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3">
									<label>Middle Name<span class="text-danger">*</span></label>
									<input type="text" name="smname" id="smname" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_smname" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3">
									<label>Last Name<span class="text-danger">*</span></label>
									<input type="text" name="slname" id="slname" class="form-control" required/>
									<span id="error_slname" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3">
									<label>Select Suffix<span class="text-danger">*</span></label>
									<select name="sfix" id="sfix" class="form-control" required>
									<option value="">-Select-</option>
									<option value="N/A">N/A</option>
									<option value="Jr.">Jr.</option>
									<option value="Sr.">Sr.</option>
									</select>
									<span id="error_sfix" class="text-danger"></span>
								</div>
								<div class="col-xs-10 col-sm-12 col-md-4">
									<label>Date of Birth<span class="text-danger">*</span></label>
									<input type="date" name="sdbirth" id="sdbirth" autocomplete="off" class="form-control" required />
									<span id="error_sdbirth" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Select Gender<span class="text-danger">*</span></label>
									<select name="sgender" id="sgender" class="form-control" required>
									<option value="">Select Gender</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									</select>
									<span id="error_sgender" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Citizenship<span class="text-danger">*</span></label>
									<input type="text" name="sctship" id="sctship" class="form-control" required/>
									<span id="error_sctship" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Address<span class="text-danger">*</span></label>
									<textarea type="text" name="saddress" id="saddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
									<span id="error_saddress" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-5">
									<label>Email Address<span class="text-danger">*</span></label>
									<input type="text" name="semail" id="semail" class="form-control" readonly/>
									<span id="error_semail" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-5 offset-md-2">
									<label>Contact Number<span class="text-danger">*</span></label>
									<input type="text" name="scontact" id="scontact" class="form-control" required/>
									<span id="error_scontact" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-5">
									<label>Student Course<span class="text-danger">*</span></label>
									<select name="scourse" id="scourse" class="form-control" required>
                                            <option value="">-Select-</option>
                                            <option value="BSIT">BSIT</option>
                                            <option value="BSBA">BSBA</option>
                                            <option value="BEED">BEED</option>
                                            <option value="BSED">BSED</option>
                                            <option value="BSCRIM">BSCRIM</option>
                                            <option value="BSHM">BSHM</option>
                                            <option value="BSTM">BSTM</option>
                                        </select>
                                    </div>
								<div class="col-xs-12 col-sm-12 col-md-5 offset-md-2">
									<label>Student Year Level<span class="text-danger">*</span></label>
									<select name="syear" id="syear" class="form-control" required>
                                            <option value="">-Select-</option>
                                            <option value="1st Year">1st Year</option>
                                            <option value="2nd Year">2nd Year</option>
                                            <option value="3rd Year">3rd Year</option>
                                            <option value="4th Year">4th Year</option>
                                        </select>
								</div>
								</div>
							</div> 
						</div>
						</div>
						</div>
						<div class="form-group">
						<div class="card">
						<div class="card-header" style="font-weight: bold; font-size: 18px;">Family Details</div>
						<div class="card-body">
							<div class="form-group">
							<h5 class="sub-title" style="font-weight: bold; font-size: 16px;">Guardian Details</h5>
								<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Full Name<span class="text-danger">*</span></label>
									<input type="text" name="sgfname" id="sgfname" class="form-control" required/>
									<span id="error_sgfname" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Address<span class="text-danger">*</span></label>
									<textarea type="text" name="sgaddress" id="sgaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
									<span id="error_sgaddress" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Contact Number<span class="text-danger">*</span></label>
									<input type="text" name="sgcontact" id="sgcontact" class="form-control" required/>
									<span id="error_sgcontact" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Occupation<span class="text-danger">*</span></label>
									<input type="text" name="sgoccu" id="sgoccu" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_sgoccu" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Company<span class="text-danger">*</span></label>
									<input type="text" name="sgcompany" id="sgcompany" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_sgcompany" class="text-danger"></span>
								</div>
								</div>
							</div>
							<div class="form-group">
							<h5 class="sub-title" style="font-weight: bold; font-size: 16px;">Father Details</h5>
								<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Full Name<span class="text-danger">*</span></label>
									<input type="text" name="sffname" id="sffname" class="form-control" required/>
									<span id="error_sffname" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Address<span class="text-danger">*</span></label>
									<textarea type="text" name="sfaddress" id="sfaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
									<span id="error_sfaddress" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Contact Number<span class="text-danger">*</span></label>
									<input type="text" name="sfcontact" id="sfcontact" class="form-control" required/>
									<span id="error_sfcontact" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Occupation<span class="text-danger">*</span></label>
									<input type="text" name="sfoccu" id="sfoccu" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_sfoccu" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Company<span class="text-danger">*</span></label>
									<input type="text" name="sfcompany" id="sfcompany" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_sfcompany" class="text-danger"></span>
								</div>
							</div>
							</div>
							<div class="form-group">
							<h5 class="sub-title" style="font-weight: bold; font-size: 16px;">Mother Details</h5>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Full Name<span class="text-danger">*</span></label>
									<input type="text" name="smfname" id="smfname" class="form-control" required/>
									<span id="error_smfname" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label>Address<span class="text-danger">*</span></label>
									<textarea type="text" name="smaddress" id="smaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
									<span id="error_smaddress" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Contact Number<span class="text-danger">*</span></label>
									<input type="text" name="smcontact" id="smcontact" class="form-control" required/>
									<span id="error_smcontact" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Occupation<span class="text-danger">*</span></label>
									<input type="text" name="smoccu" id="smoccu" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_smoccu" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-4">
									<label>Company<span class="text-danger">*</span></label>
									<input type="text" name="smcompany" id="smcompany" class="form-control" placeholder="Put N/A if none" required/>
									<span id="error_smcompany" class="text-danger"></span>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-5">
									<label>Parents Combine Yearly Income<span class="text-danger">*</span></label>
									<input type="text" name="spcyincome" id="spcyincome" class="form-control" required/>
									<span id="error_spcyincome" class="text-danger"></span>
								</div>
							</div>
							</div>
						</div>
						</div>
						</div>
						<div class="form-group">
							<div class="card">
							<div class="card-header" style="font-weight: bold; font-size: 18px;">Achievement Details</div>
								<div class="card-body">
								<div class="form-group">
								<label>Name of School/Institution/Company<span class="text-danger">*</span></label>
								<input type="text" name="school" id="sschool" class="form-control" required/>
								<span id="error_school" class="text-danger"></span>
								</div>
								<div class="form-group">
								<label>Award Received<span class="text-danger">*</span></label>
								<textarea name="saward" id="saward" class="form-control" required></textarea>
								<span id="error_saward" class="text-danger" required></span>
								</div>
								<div class="form-group">
								<label>Date Received<span class="text-danger">*</span></label>
									<input type="date" name="sreceive" id="sreceive" class="form-control" autocomplete="off" required>
									<span id="error_sreceive" class="text-danger"></span>
								</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="card">
							<div class="card-header" style="font-weight: bold; font-size: 18px;">Scholar Remarks</div>
								<div class="card-body">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<label>Remarks:</label>
										<textarea type="text" name="snote" id="snote" placeholder="Put N/A if None" class="form-control" required data-parsley-trigger="keyup"></textarea>
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
                     <button type="button" class="btn btn-success" id="updateStatus">Update Status</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<!-- View Non-Acad Modal -->
	<div id="viewnonacadModal" class="modal fade">
		<div class="modal-dialog modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title">View Student Details</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" id="nonacad_details">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
<!-- View UNIFAST Modal -->
	<div id="viewunifastModal" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">View Student Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="unifast_details">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- View CHED Modal -->
	<div id="viewchedModal" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">View Student Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="ched_details">
                    
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
                        <label>To:</label>
                        <input type="text" class="form-control" id="student_id">
                    </div>
                    <div class="form-group">
                        <label>Subject:</label>
                        <input type="text" class="form-control" id="announcement_subject" required>
                    </div>
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


        $(document).on('click', '#updateStatus', function() {
    var studentId = $('#acad_hidden_id').val();
    var newStatus = $('#validation_status').val();
    
    $.ajax({
        url: "students_action.php",
        method: "POST",
        data: {
            action: 'update_status',
            s_id: studentId,
            status: newStatus
        },
        success: function(response) {
            if(response.success) {
                $('#viewacadModal').modal('hide');
                location.reload();
            } else {
                alert('Failed to update status');
            }
        }
    });
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
        url: "students_action.php",
        method: "POST",
        data: { s_id: s_id, action: 'acad_fetch_single' },
        dataType: 'JSON',
        success: function(data) {
            console.log('Data received from server:', data);

            // Set form fields with data from server
            $('#sid').val(data.sid);
            $('#sfname').val(data.sfname);
            $('#smname').val(data.smname);
            $('#slname').val(data.slname);
            $('#sfix').val(data.sfix);
            $('#sdbirth').val(data.sdbirth);
            $('#sgender').val(data.sgender);
            $('#sctship').val(data.sctship);
            $('#saddress').val(data.saddress);
            $('#semail').val(data.semail);
            $('#scontact').val(data.scontact);
            $('#scourse').val(data.scourse);
            $('#syear').val(data.syear);
            $('#sgfname').val(data.sgfname);
            $('#sgaddress').val(data.sgaddress);
            $('#sgcontact').val(data.sgcontact);
            $('#sgoccu').val(data.sgoccu);
            $('#sgcompany').val(data.sgcompany);
            $('#sffname').val(data.sffname);
            $('#sfaddress').val(data.sfaddress);
            $('#sfcontact').val(data.sfcontact);
            $('#sfoccu').val(data.sfoccu);
            $('#sfcompany').val(data.sfcompany);
            $('#smfname').val(data.smfname);
            $('#smaddress').val(data.smaddress);
            $('#smcontact').val(data.smcontact);
            $('#smoccu').val(data.smoccu);
            $('#smcompany').val(data.smcompany);
            $('#spcyincome').val(data.spcyincome);
            $('#sschool').val(data.sschool);
            $('#saward').val(data.saward);
            $('#sreceive').val(data.sreceive);
            $('#snote').val(data.snote);

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

            // Announcement button click handler
				$(document).on('click', '.announcement_button', function() {
					var selected = [];
					var selectedEmails = [];
					
					$('.select_row:checked').each(function() {
						selected.push($(this).val());
						selectedEmails.push($(this).closest('tr').find('td:eq(6)').text());
					});

					if (selected.length === 0) {
						alert('Please select at least one scholar.');
						return;
					}

					$('#student_id').val(selectedEmails.join(', '));
					$('#announcementModal').modal('show');
				});
				$('#send_announcement').click(function() {
					var student_id = $('#student_id').val();
					var subject = $('#announcement_subject').val();
					var announcement = $('#announcement_text').val();
					
					$.ajax({
						url: 'students_action.php',
						method: 'POST',
						data: {
							action: 'send_announcement',
							student_id: student_id,
							subject: subject,
							announcement: announcement
						},
						success: function(response) {
							$('#announcementModal').modal('hide');
							alert('Announcement sent successfully!');
							$('#announcement_subject').val('');
							$('#announcement_text').val('');
						},
						error: function() {
							alert('Failed to send announcement');
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
            url: "students_action.php",
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
        url: "students_action.php",
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
                html += '<tr><th width="40%" >Middle Name</th><td width="60%">' + data.smname + '</td></tr>';
                html += '<tr><th width="40%" >Last Name</th><td width="60%">' + data.slname + '</td></tr>';
                html += '<tr><th width="40%" >Suffix</th><td width="60%">' + data.sfix + '</td></tr>';
                html += '<tr><th width="40%" >Date of Birth</th><td width="60%">' + data.sdbirth + '</td></tr>';
                html += '<tr><th width="40%" >Citizenship</th><td width="60%">' + data.sctship + '</td></tr>';
                html += '<tr><th width="40%" >Address</th><td width="60%">' + data.saddress + '</td></tr>';
                html += '<tr><th width="40%" >Email Address</th><td width="60%">' + data.semail + '</td></tr>';
                html += '<tr><th width="40%" >Contact Number</th><td width="60%">' + data.scontact + '</td></tr>';
                html += '<tr><th width="40%" >Gender</th><td width="60%">' + data.sgender + '</td></tr>';
                html += '<tr><th width="40%" >Current Course</th><td width="60%">' + data.scourse + '</td></tr>';
                html += '<tr><th width="40%" >Current Year Level</th><td width="60%">' + data.syear + '</td></tr>';
                // Family Details
                // Guardian Details
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Family Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" class="text-left" style="font-size:18px; font-weight: bold">Guardian Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >First Name</th><td width="60%">' + data.sgfname + '</td></tr>';
                html += '<tr><th width="40%" >Address</th><td width="60%">' + data.sgaddress + '</td></tr>';
                html += '<tr><th width="40%" >Contact Number</th><td width="60%">' + data.sgcontact + '</td></tr>';
                html += '<tr><th width="40%" >Occupation/Position</th><td width="60%">' + data.sgoccu + '</td></tr>';
                html += '<tr><th width="40%" >Company</th><td width="60%">' + data.sgcompany + '</td></tr>';
                // Father Details
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Father Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >First Name</th><td width="60%">' + data.sffname + '</td></tr>';
                html += '<tr><th width="40%" >Address</th><td width="60%">' + data.sfaddress + '</td></tr>';
                html += '<tr><th width="40%" >Contact Number</th><td width="60%">' + data.sfcontact + '</td></tr>';
                html += '<tr><th width="40%" >Occupation/Position</th><td width="60%">' + data.sfoccu + '</td></tr>';
                html += '<tr><th width="40%" >Company</th><td width="60%">' + data.sfcompany + '</td></tr>';
                // Mother Details
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Mother Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >First Name</th><td width="60%">' + data.smfname + '</td></tr>';
                html += '<tr><th width="40%" >Address</th><td width="60%">' + data.smaddress + '</td></tr>';
                html += '<tr><th width="40%" >Contact Number</th><td width="60%">' + data.smcontact + '</td></tr>';
                html += '<tr><th width="40%" >Occupation/Position</th><td width="60%">' + data.smoccu + '</td></tr>';
                html += '<tr><th width="40%" >Company</th><td width="60%">' + data.smcompany + '</td></tr>';
                // Achievement Details
				html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Achievement Details</th><td width="60%"></td></tr>';
				html += '<tr><th width="40%" >Name Of School/Institution/Company</th><td width="60%">'+data.sschool+'</td></tr>';
				html += '<tr><th width="40%" >Award Received</th><td width="60%">'+data.saward+'</td></tr>';
				html += '<tr><th width="40%" >Date Received</th><td width="60%">'+data.sreceive+'</td></tr>';
				 
                // Scholarship Details
               html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Scholarship Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >Scholarship Type</th><td width="60%">' + data.s_scholarship_type + '</td></tr>';
               // html += '<tr><th width="40%" >Scholarship Status</th><td width="60%">' + data.is_scholar + '</td></tr>';
                html += '<tr><th width="40%" >Date Applied</th><td width="60%">' + data.applied_on + '</td></tr>';
                // Study Load Image 
               html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Study Load</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%">Study Load Image</th><td width="60%"><a href="../' + data.simg + '" target="_blank">View Study Load</a></td></tr>';
                

                // Requirements Section
                html += '<tr><th width="40%">Certificate of Honor</th><td width="60%">' + (data.cert_file_path ? '<a href="' + data.cert_file_path + '" target="_blank">View Certificate</a>' : 'No file uploaded') + '</td></tr>';
                html += '<tr><th width="40%">Good Moral</th><td width="60%">' + (data.moral_file_path ? '<a href="' + data.moral_file_path + '" target="_blank">View Good Moral</a>' : 'No file uploaded') + '</td></tr>';
                html += '<tr><th width="40%">Grade 12 Grades</th><td width="60%">' + (data.grades_file_path ? '<a href="' + data.grades_file_path + '" target="_blank">View Grades</a>' : 'No file uploaded') + '</td></tr>';
                html += '<tr><th width="40%">Graduation Program</th><td width="60%">' + (data.grad_file_path ? '<a href="' + data.grad_file_path + '" target="_blank">View Program</a>' : 'No file uploaded') + '</td></tr>';
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Scholar Remarks</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >Remarks:</th><td width="60%">' + data.snote + '</td></tr>';
                // Add this inside the view modal's table, before the closing table tag
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Validation Status</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%">Current Status</th><td width="60%">';
                html += '<select class="form-control" id="validation_status" name="validation_status">';
                html += '<option value="Valid" ' + (data.s_account_status == 'Valid' ? 'selected' : '') + '>Valid</option>';
                html += '<option value="Invalid" ' + (data.s_account_status == 'Invalid' ? 'selected' : '') + '>Invalid</option>';
                html += '<option value="Pending" ' + (data.s_account_status == 'Pending' ? 'selected' : '') + '>Pending</option>';
                html += '</select></td></tr>';


                // Populate the modal with the generated HTML
                $('#acad_details').html(html);
                // Show the modal
                $('#viewacadModal').modal('show');
                // In the view button click handler
                $('#acad_hidden_id').val(s_id);


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