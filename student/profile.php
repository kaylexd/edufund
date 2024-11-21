<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

$id = $_SESSION['user_id'];

// Fetch student data
$query = "SELECT sfname, smname, slname, semail, s_pass FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Set default values if data is not found
$sfname = isset($row['sfname']) ? $row['sfname'] : '';
$smname = isset($row['smname']) ? $row['smname'] : '';
$slname = isset($row['slname']) ? $row['slname'] : '';
$semail = isset($row['semail']) ? $row['semail'] : '';
$s_pass = isset($row['s_pass']) ? $row['s_pass'] : '';

// In the notifications dropdown
$sql = "SELECT * FROM announcements WHERE student_id = ? AND is_read = 0 ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);

$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    echo "<div class='dropdown-item'>";
    echo htmlspecialchars($row['message']);
    echo "<div class='small text-gray-500'>" . $row['created_at'] . "</div>";
    echo "</div>";
}

$sql = "SELECT COUNT(*) as count FROM announcements WHERE student_id = ? AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count'];
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Student</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap and Core Plugins -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- DataTables and other plugins, ensuring DataTables core is loaded first -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Custom scripts -->
<script src="../js/sb-admin-2.min.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


  
   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">



<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
  <div class="sidebar-brand-icon">
  <img src="../img/logo.png" alt>
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
  <a class="nav-link" href="apply.php">
  <i class="fa-solid fa-magnifying-glass"></i>
    <span>Apply</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="profile.php">
  <i class="fa-solid fa-magnifying-glass"></i>
    <span>Profile</span></a>
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

          <!-- Nav Item - Alerts -->
          <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw"></i>
                  <!-- Counter - Alerts -->
                  <span class="badge badge-danger badge-counter"><?php echo $count; ?></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">Alerts Center</h6>
                  <?php
                  $sql = "SELECT subject, message, created_at FROM announcements WHERE student_id = ? AND is_read = 0 ORDER BY created_at DESC";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("i", $_SESSION['user_id']);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  // Loop through the results and display each notification
                  while ($row = $result->fetch_assoc()) {
                      echo "<div class='dropdown-item'>";
                      echo "<div class='font-weight-bold'>" . htmlspecialchars($row['subject']) . "</div>";
                      echo htmlspecialchars($row['message']);
                      echo "<div class='small text-gray-500'>" . $row['created_at'] . "</div>";
                      echo "</div>";
                  }

                  // Show all alerts link
                  echo "<a class='dropdown-item text-center small text-gray-500' href='#'>Show All Alerts</a>";
                  ?>
              </div>
          </li>
            
            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                <?php echo htmlspecialchars($semail); ?> 
                </span>
                <img class="img-profile rounded-circle" src="../img/user-solid.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileEditModal">
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
        

        

            <!-- Display Profile Information -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Student Profile</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <th width="30%">First Name</th>
                    <td><?php echo htmlspecialchars($sfname); ?></td>
                </tr>
                <tr>
                    <th>Middle Name</th>
                    <td><?php echo htmlspecialchars($smname); ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo htmlspecialchars($slname); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($semail); ?></td>
                </tr>
            </table>
            <button class="btn btn-primary" data-toggle="modal" data-target="#profileEditModal">
                <i class="fas fa-edit fa-sm"></i> Edit Profile
            </button>
        </div>
    </div>
</div>

<!-- Profile Edit Modal -->
<div class="modal fade" id="profileEditModal" tabindex="-1" role="dialog" aria-labelledby="profileEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileEditModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="profileEditForm" method="POST" action="update_profile.php">
                <div class="modal-body">
                <?php if(isset($_SESSION['modal_msg'])): ?>
                  <div class="alert <?php echo isset($_SESSION['modal_success']) && $_SESSION['modal_success'] ? 'alert-success' : 'alert-danger'; ?>">
        <?php 
        echo $_SESSION['modal_msg'];
        if(isset($_SESSION['modal_success'])) {
            echo "<script>
                setTimeout(function() {
                    $('#profileEditModal').modal('hide');
                }, 3000);
            </script>";
        }
        unset($_SESSION['modal_msg']); 
        unset($_SESSION['modal_success']);
        unset($_SESSION['show_modal']);
        ?>
    </div>
<?php endif; ?>

                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo htmlspecialchars($sfname); ?>" >
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" value="<?php echo htmlspecialchars($smname); ?>">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo htmlspecialchars($slname); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($semail); ?>">
                    </div>
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" class="form-control" name="current_password" id="current_password">
                        <div id="current_password_message" class="text-danger"></div>
                    </div>
                  <div class="form-group">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="new_password" id="new_password">
                      <small class="form-text text-muted">Leave blank if you don't want to change password</small>
                  </div>
                  <div class="form-group">
                      <label>Confirm New Password</label>
                      <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                      <div id="password_match_message" class="text-danger"></div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Function to provide real-time feedback on form fields
    function validateFields() {
        const currentPassword = $('#current_password').val();
        const newPassword = $('#new_password').val();
        const confirmPassword = $('#confirm_password').val();

        // Show error if new password and confirm password do not match
        if (newPassword && confirmPassword && newPassword !== confirmPassword) {
            $('#password_match_message').html('Passwords do not match').addClass('text-danger').removeClass('text-success');
            $('#confirm_password').removeClass('is-valid').addClass('is-invalid');
        } else if (newPassword && confirmPassword && newPassword === confirmPassword) {
            $('#password_match_message').html('Passwords match').removeClass('text-danger').addClass('text-success');
            $('#confirm_password').removeClass('is-invalid').addClass('is-valid');
        } else {
            $('#password_match_message').html('');
            $('#confirm_password').removeClass('is-invalid is-valid');
        }

        // Show message if current password is missing when trying to change the password
        if (newPassword || confirmPassword) {
            if (!currentPassword) {
                $('#current_password_message').html('Current password is required for password changes').addClass('text-danger');
                $('#current_password').removeClass('is-valid').addClass('is-invalid');
            } else {
                $('#current_password_message').html('').removeClass('text-danger');
                $('#current_password').removeClass('is-invalid').addClass('is-valid');
            }
        } else {
            $('#current_password_message').html('');
            $('#current_password').removeClass('is-invalid is-valid');
        }
    }

    // Event listeners for real-time feedback
    $('#current_password, #new_password, #confirm_password').on('keyup', validateFields);
});

$(document).ready(function() {
    // Check if a session message is present and set a timer to close the modal
    <?php if (isset($_SESSION['modal_msg'])): ?>
        setTimeout(function() {
            $('#profileEditModal').modal('hide'); // Hide the modal after 3 seconds
        }, 3000); // 3-second timer
    <?php endif; ?>
});

</script>





<!-- Add status message display here -->
<?php if(isset($_SESSION['status_msg'])): ?>
    <div class="col-xl-12">
        <div class="alert alert-info">
            <?php 
            echo $_SESSION['status_msg'];
            unset($_SESSION['status_msg']); 
            ?>
        </div>
    </div>
<?php endif; ?>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  
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




  </div>
  <!-- End of Main Content -->



</div>
<!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

</body>

</html>