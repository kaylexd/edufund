<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('includes/db.php');
// Query to count students with is_scholar = 1 (approved)
$sql = "SELECT COUNT(*) AS approved_count FROM admin_status WHERE is_scholar = 1";
$result = $conn->query($sql);

// Fetch the count from the result
$approved_count = 0;
if ($result && $row = $result->fetch_assoc()) {
    $approved_count = $row['approved_count'];
}

$sql = "SELECT COUNT(*) AS pending_count FROM scholarship_applications WHERE s_account_status = 'pending'";
$result = $conn->query($sql);

// Fetch the count from the result
$pending_count = 0;
if ($result && $row = $result->fetch_assoc()) {
    $pending_count = $row['pending_count'];
}
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

  <!-- Content Row -->
  <div class="row">


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Total Students Approved</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?php echo htmlspecialchars($approved_count); ?> <!-- Display the approved count -->
          </div>
          <div class="mt-2">
            <a href="scholars.php" class="text-primary" style="text-decoration: underline;">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-primary shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Total Rejected</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">
            <?php echo htmlspecialchars($pending_count); ?>
          </div>
          <div class="mt-2">
            <a href="generate.php" class="text-primary" style="text-decoration: underline;">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Subject for Approval</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                    <?php 
                      $sql = "SELECT COUNT(*) AS valid_count 
                              FROM scholarship_applications sa
                              JOIN admin_status a ON sa.student_id = a.student_id
                              WHERE sa.s_account_status = 'Valid' 
                              AND a.is_scholar = 0 
                              AND a.s_scholar_status = 'Pending'";
                      $result = $conn->query($sql);
                      $row = $result->fetch_assoc();
                      echo htmlspecialchars($row['valid_count']);
                      ?>

                    </div>
                    <div class="mt-2">
                        <a href="students.php" class="text-primary" style="text-decoration: underline;">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-bg-gray text-uppercase mb-1">Total Registered</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $sql = "SELECT COUNT(id) AS total_count FROM students";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo htmlspecialchars($row['total_count']);
                        ?>
                    </div>
                    <div class="mt-2">
                        <a href="generate.php" class="text-primary" style="text-decoration: underline;">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




                        <script>
$(document).ready(function() {
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });

    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        $(this).parent().find('.dropdown-menu').toggleClass('show');
    });
});
</script>



                               <!-- Chart.js -->
<script src="vendor/chart.js/Chart.min.js"></script>




  <?php
include('includes/scripts.php');
?>