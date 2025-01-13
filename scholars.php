<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');

// Query for scholars only
$sql = "SELECT s.id, s.sid, s.sfname, s.smname, s.slname, s.scourse, s.syear, s.scontact, s.semail,
        a.s_scholar_status, a.is_scholar, sa.s_scholarship_type
        FROM students s
        INNER JOIN admin_status a ON s.id = a.student_id
        LEFT JOIN scholarship_applications sa ON s.id = sa.student_id 
        WHERE a.is_scholar = 1";
$result = $conn->query($sql);


if (!$result) {
    die("Query Failed: " . $conn->error);  // Show a more detailed error message if the query fails
}
?>                    

<div class="container-fluid">
<!-- DataTables Example -->
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex justify-content-between align-items-center">
<h6 class="m-0 font-weight-bold text-bg-gray">Scholars</h6>
    <div>
	<div class="btn-group">
    <!-- Main Button -->
    <button type="button" class="btn btn-primary btn-sm add_button dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-plus"></i>
    </button>
    <!-- Dropdown Menu -->
    <div class="dropdown-menu">
        <button class="dropdown-item" type="button" name="add_acad" id="add_acad">Academic</button>
        <button class="dropdown-item" type="button" name="add_nonacad" id="add_nonacad">Non-Academic</button>
    </div>
</div>

        <button type="button" class="btn btn-primary btn-sm email_button">
            <i class="fas fa-envelope"></i>
        </button>
    </div>
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
                        <th>Current Course</th>
                        <th>Contact No.</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Scholarship Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='select_row' class='select_row' value='" . $row['id'] . "' /></td>";
                        echo "<td>" . htmlspecialchars($row['sid']) . "</td>";
						echo "<td>" . htmlspecialchars($row['slname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sfname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['scourse']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['scontact']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['semail']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['s_scholar_status']) . "</td>";
                        echo "<td>" . (!empty($row['s_scholarship_type']) ? htmlspecialchars($row['s_scholarship_type']) : "") . "</td>";
                        


                         // Action column with Edit, Delete, and Add buttons
                         echo "<td>
                         <div class='d-flex'>
                         <!-- View Button with Icon -->
                         <button type='button' class='btn btn-info btn-sm view_button mr-1' data-id='" . $row['id']  . "'>
                             <i class='fa-regular fa-eye'></i>
                         </button>
 
                         <!-- Edit Button with Icon -->
                         <button type='button' class='btn btn-success btn-sm edit_button mr-1' data-id='" . $row['id']  . "'>
                             <i class='fa-solid fa-pen-to-square'></i>
                         </button>
 
                         <!-- Delete Button with Icon -->
                         <button type='button' class='btn btn-danger btn-sm delete_button' data-id='" . $row['id'] . "'>
                             <i class='fa-regular fa-circle-xmark'></i>
                         </button>
                     </div>
 
 
                     </td>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No data available</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
            </div>
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
									<label>Email Address<span class="text-danger"></span></label>
									<input type="text" name="semail" id="semail" class="form-control" required/>
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
								<input type="text" name="sschool" id="sschool" class="form-control" required/>
								<span id="error_sschool" class="text-danger"></span>
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
							<div class="card-header" style="font-weight: bold; font-size: 18px;">Scholarship Details</div>
								<div class="card-body">
									<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
										<label>Scholarship Status<span class="text-danger">*</span></label>
										<select name="s_scholar_status" id="s_scholar_status" class="form-control" required>
										<option value="">-Select-</option>
										<option value="Pending">Pending</option>
										<option value="Approved">Approved</option>
										<option value="Rejected">Rejected</option>
										</select>
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
<!-- Add Non-Acad Modal -->
	<div id="nonacadModal" class="modal fade">
			<div class="modal-dialog modal-lg modal-dialog-scrollable">
				<form method="post" id="nonacad_form">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="nonacadmodal-title" id="nonacadmodal-title">Add Non-Academic Scholar</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
							<span id="nonacadform_message"></span>
							<div class="form-group">
								<div class="card">
									<div class="card-header" style="font-weight: bold; font-size: 18px;">Student ID Details</div>
									<div class="card-body">
										<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
											<label>Student ID NO.<span class="text-danger">*</span></label>
											<input type="text" name="sns_id" id="sns_id" class="form-control" required/>
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
													<input type="text" name="snfname" id="snfname" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-3">
													<label>Middle Name<span class="text-danger">*</span></label>
													<input type="text" name="snmname" id="snmname" class="form-control" placeholder="Put N/A if none" required/>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-3">
													<label>Last Name<span class="text-danger">*</span></label>
													<input type="text" name="snlname" id="snlname" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-3">
													<label>Select Suffix<span class="text-danger">*</span></label>
													<select name="snnext" id="snnext" class="form-control" required>
													<option value="">-Select-</option>
													<option value="N/A">N/A</option>
													<option value="Jr.">Jr.</option>
													<option value="Sr.">Sr.</option>
													</select>
												</div>
												<div class="col-xs-10 col-sm-12 col-md-4">
													<label>Date of Birth<span class="text-danger">*</span></label>
													<input type="date" name="sndbirth" id="sndbirth" autocomplete="off" class="form-control" required>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Select Gender<span class="text-danger">*</span></label>
													<select name="sngender" id="sngender" class="form-control" required>
													<option value="">Select Gender</option>
													<option value="Male">Male</option>
													<option value="Female">Female</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Citizenship<span class="text-danger">*</span></label>
													<input type="text" name="snctship" id="snctship" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Address<span class="text-danger">*</span></label>
													<textarea type="text" name="snaddress" id="snaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-5">
													<label>Email Address<span class="text-danger">*</span></label>
													<input type="text" name="snemail" id="snemail" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-5 offset-md-2">
													<label>Contact Number<span class="text-danger">*</span></label>
													<input type="text" name="sncontact" id="sncontact" class="form-control" required/>
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
											<h4 class="sub-title" style="font-weight: bold; font-size: 16px;">Guardian Details</h4>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Full Name<span class="text-danger">*</span></label>
													<input type="text" name="sngfname" id="sngfname" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Address<span class="text-danger">*</span></label>
													<textarea type="text" name="sngaddress" id="sngaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Contact Number<span class="text-danger">*</span></label>
													<input type="text" name="sngcontact" id="sngcontact" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Occupation<span class="text-danger">*</span></label>
													<input type="text" name="sngoccu" id="sngoccu" class="form-control" placeholder="Put N/A if none" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Company<span class="text-danger">*</span></label>
													<input type="text" name="sngcompany" id="sngcompany" class="form-control" placeholder="Put N/A if none" required/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<h4 class="sub-title" style="font-weight: bold; font-size: 16px;">Father Details</h4>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Full Name<span class="text-danger">*</span></label>
													<input type="text" name="snffname" id="snffname" class="form-control" required/>
													<span id="error_sffname" class="text-danger"></span>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Address<span class="text-danger">*</span></label>
													<textarea type="text" name="snfaddress" id="snfaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Contact Number<span class="text-danger">*</span></label>
													<input type="text" name="snfcontact" id="snfcontact" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Occupation<span class="text-danger">*</span></label>
													<input type="text" name="snfoccu" id="snfoccu" class="form-control" placeholder="Put N/A if none" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Company<span class="text-danger">*</span></label>
													<input type="text" name="snfcompany" id="snfcompany" class="form-control" placeholder="Put N/A if none" required/>
												</div>
											</div>
										</div>
										<div class="form-group">
											<h4 class="sub-title" style="font-weight: bold; font-size: 16px;">Mother Details</h4>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Full Name<span class="text-danger">*</span></label>
													<input type="text" name="snmfname" id="snmfname" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Address<span class="text-danger">*</span></label>
													<textarea type="text" name="snmaddress" id="snmaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Contact Number<span class="text-danger">*</span></label>
													<input type="text" name="snmcontact" id="snmcontact" class="form-control" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Occupation<span class="text-danger">*</span></label>
													<input type="text" name="snmoccu" id="snmoccu" class="form-control" placeholder="Put N/A if none" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Company<span class="text-danger">*</span></label>
													<input type="text" name="snmcompany" id="snmcompany" class="form-control" placeholder="Put N/A if none" required/>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
													<label>Parents Combine Yearly Income<span class="text-danger">*</span></label>
													<input type="text" name="snpcyincome" id="snpcyincome" class="form-control" required/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="card">
								<div class="card-header" style="font-weight: bold; font-size: 18px;">Application Details</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Reasons/Special Circumstances for Applying NAS<span class="text-danger">*</span></label>
													<textarea type="text" name="snrappnas" id="snrappnas" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Basic Office Skills<span class="text-danger">*</span></label>
													<textarea type="text" name="snbos" id="snbos" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Special Skills<span class="text-danger">*</span></label>
													<textarea type="text" name="snsskills" id="snsskills" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Type of Work Interested In<span class="text-danger">*</span></label>
													<textarea type="text" name="sntwinterest" id="sntwinterest" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="card">
								<div class="card-header" style="font-weight: bold; font-size: 18px;">Education Details</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Previous School Attended<span class="text-danger">*</span></label>
													<textarea type="text" name="snpschname" id="snpschname" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>School Address<span class="text-danger">*</span></label>
													<textarea type="text" name="snpsaddress" id="snpsaddress" class="form-control" required data-parsley-trigger="keyup"></textarea>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12">
													<label>Year/Grade Level<span class="text-danger">*</span></label>
													<input type="text" name="snpsyrlvl" id="snpsyrlvl" class="form-control" required/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="card">
								<div class="card-header" style="font-weight: bold; font-size: 18px;">Requirements Details</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Date Recv. Report Card<span class="text-danger">*</span></label>
													<input type="date" name="sndsprc" id="sndsprc" autocomplete="off" class="form-control" />
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Date Recv. Good Moral<span class="text-danger">*</span></label>
													<input type="date" name="sndspgm" id="sndspgm" autocomplete="off" class="form-control" />
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Date Recv. 2x2 ID Picture<span class="text-danger">*</span></label>
													<input type="date" name="sndstbytpic" id="sndstbytpic" autocomplete="off" class="form-control" />
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Select Report Card Status<span class="text-danger">*</span></label>
													<select name="sndsprcstat" id="sndsprcstat" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Received">Received</option>
													<option value="Not-Received">Not-Received</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Select Good Moral Status<span class="text-danger">*</span></label>
													<select name="sndspgmstat" id="sndspgmstat" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Received">Received</option>
													<option value="Not-Received">Not-Received</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Select 2x2 ID Pic. Status<span class="text-danger">*</span></label>
													<select name="sndstbytpicstat" id="sndstbytpicstat" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Received">Received</option>
													<option value="Not-Received">Not-Received</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Date Recv. Brgy. Indigency<span class="text-danger">*</span></label>
													<input type="date" name="sndsbrgyin" id="sndsbrgyin" autocomplete="off" class="form-control" />
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
													<label>Date Recv. Enrollment Form<span class="text-danger">*</span></label>
													<input type="date" name="sndscef" id="sndscef" autocomplete="off" class="form-control" />
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4">
													<label>Select Brgy. Indigency Status<span class="text-danger">*</span></label>
													<select name="sndsbrgyinstat" id="sndsbrgyinstat" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Received">Received</option>
													<option value="Not-Received">Not-Received</option>
													</select>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
													<label>Select ENRL Form Status<span class="text-danger">*</span></label>
													<select name="sndscefstat" id="sndscefstat" class="form-control" required>
													<option value="">-Select-</option>
													<option value="Received">Received</option>
													<option value="Not-Received">Not-Received</option>
													</select>
												</div>
											</div>
										</div> 
									</div>
								</div>
							</div>
							<div class="form-group">
							<div class="card">
								<div class="card-header" style="font-weight: bold; font-size: 18px;">Scholars Note</div>
									<div class="card-body">
										<div class="col-xs-12 col-sm-12 col-md-12">
											<label>Note:</label>
											<textarea type="text" name="sn_scholarship_note" id="sn_scholarship_note" placeholder="Put N/A if None" class="form-control" required data-parsley-trigger="keyup"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="card">
								<div class="card-header" style="font-weight: bold; font-size: 18px;">Scholarship Details</div>
									<div class="card-body">
										<div class="col-xs-12 col-sm-12 col-md-4 offset-md-4">
											<label>Scholarship Status<span class="text-danger">*</span></label>
											<select name="s_scholar_status" id="s_scholar_status" class="form-control" required>
											<option value="">-Select-</option>
											<option value="Pending">Pending</option>
											<option value="Approved">Approved</option>
											<option value="Rejected">Rejected</option>
											</select>
										</div>
									</div>
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="nonacad_hidden_id" id="nonacad_hidden_id" />
						<input type="hidden" name="action" id="nonacad_action" value="add_nonacad" />
						<input type="submit" name="submit" id="nonacad_submit_button" class="btn btn-success" value="Add" />
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
                <h4 class="modal-title" id="modal_title">View Scholar Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="acad_details"></div>
            <div class="modal-footer">
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
					<h4 class="modal-title" id="modal_title">View Scholar Details</h4>
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



				$('.manage_slots_button').click(function() {
    // Fetch current slots data
    $.ajax({
        url: 'scholars_action.php',
        method: 'POST',
        data: {action: 'fetch_slots'},
        success: function(response) {
            const data = JSON.parse(response);
            $('#total_slots').val(data.total_slots);
            $('#slots_status').val(data.status);
            $('#scholarship_type').val(data.scholarship_type);
            $('#manageSlotsModal').modal('show');
        }
    });
});

$('#saveSlots').click(function() {
    const totalSlots = $('#total_slots').val();
    const status = $('#slots_status').val();
    const scholarshipType = $('#scholarship_type').val();

    $.ajax({
        url: 'scholars_action.php',
        method: 'POST',
        data: {
            action: 'update_slots',
            total_slots: totalSlots,
            status: status,
            scholarship_type: scholarshipType
        },
        success: function(response) {
            alert('Scholarship slots updated successfully');
            $('#manageSlotsModal').modal('hide');
            location.reload();
        }
    });
});



				// Email button click handler
$(document).on('click', '.email_button', function() {
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

    $('#email_recipients').val(selectedEmails.join(', '));
    $('#emailModal').modal('show');
});

$('#send_email').click(function() {
    var recipients = $('#email_recipients').val();
    var subject = $('#email_subject').val();
    var message = $('#email_message').val();
    
    // Show loading state
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
            alert('Email sent successfully!');
            $('#email_subject').val('');
            $('#email_message').val('');
        },
        complete: function() {
            $('#send_email').html('Send').prop('disabled', false);
        }
    });
});




               

                // View Function
$(document).on('click', '.view_button', function() {
    var s_id = $(this).data('id');
    $.ajax({
        url: "scholars_action.php",
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
                html += '<tr><th width="40%" class="text-left" style="font-size:18px">Guardian Details</th><td width="60%"></td></tr>';
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
				html += '<tr><th width="40%" >Parents Combine Yearly Income</th><td width="60%">'+data.spcyincome+'</td></tr>';
               // Achievement Details
			   html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Achievement Details</th><td width="60%"></td></tr>';
				html += '<tr><th width="40%" >Name Of School/Institution/Company</th><td width="60%">'+data.sschool+'</td></tr>';
				html += '<tr><th width="40%" >Award Received</th><td width="60%">'+data.saward+'</td></tr>';
				html += '<tr><th width="40%" >Date Received</th><td width="60%">'+data.sreceive+'</td></tr>';
				// Scholarship Details
                html += '<tr style="background-color: crimson;"><th width="40%" class="text-left" style="font-size:20px; color: white">Scholarship Details</th><td width="60%"></td></tr>';
                html += '<tr><th width="40%" >Scholarship Type</th><td width="60%">' + data.s_scholarship_type + '</td></tr>';
               	html += '<tr><th width="40%" >Scholarship Status</th><td width="60%">' + data.s_scholar_status + '</td></tr>';
                html += '<tr><th width="40%" >Date Applied</th><td width="60%">' + data.applied_on + '</td></tr>';
                html += '</table></div>';

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
        url: "scholars_action.php",
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
            $('#s_scholar_status').val(data.s_scholar_status);

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
$('#acad_form').on('submit', function(event) {
    event.preventDefault();

    if ($('#acad_form').parsley().isValid()) {
        $('#acad_submit_button').val('Processing...').attr('disabled', true);

        $.ajax({
            url: "scholars_action.php",
            method: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#acad_submit_button').attr('disabled', false).val('Add');

                if (data.error) {
                    $('#form_message').html(data.error);
                } else {
                    $('#acadModal').modal('hide');
                    $('#message').html(data.success);
                    location.reload(); // Add this line to reload after successful edit
                }
            },
            error: function(xhr, status, error) {
                $('#form_message').html('An error occurred. Please try again.');
                $('#acad_submit_button').attr('disabled', false).val('Add');
                console.log('Response Text:', xhr.responseText);
            }
        });
    }
});

				$('#add_acad').click(function(){

				$('#acad_form')[0].reset();

				$('#acad_form').parsley().reset();

				$('#acadmodal_title').text('Add Academic Scholar');

				$('#action').val('add_acad');

				$('#acad_submit_button').val('Add');

				$('#acadModal').modal('show');

				$('#form_message').html('');

				});
					

                // Delete Action
    $(document).on('click', '.delete_button', function() {
        var id = $(this).data('id');
        if (confirm("Are you sure you want to delete this student?")) {
            $.ajax({
                url: 'scholars_action.php', // Same PHP file for delete
                type: 'POST',
                data: { id: id, delete: true }, // Pass a delete flag
                success: function(response) {
                    alert('Student deleted successfully.');
                    location.reload(); // Reload the page to see the updated table
                },
                error: function() {
                    alert('Failed to delete student. Please try again.');
                }
                });
            }
        });
  

                </script>

<?php
include('includes/scripts.php');
?>