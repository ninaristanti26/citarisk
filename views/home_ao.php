<?php include "other/header.php"; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<style>
.iq-card {
   background: linear-gradient(135deg, #ffffff, #f7f9fc);
   border-radius: 15px;
   box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
   transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.iq-card:hover {
   transform: translateY(-5px);
   box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.iq-card-body {
   padding: 20px;
   color: #333;
}

.iq-icon-box {
   width: 50px;
   height: 50px;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 24px;
   box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

p.text-secondary {
   font-weight: 600;
   color: #6c757d !important;
   margin-bottom: 10px;
}

h4 {
   font-size: 24px;
   font-weight: 700;
   color: #111;
}

</style>
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../cal/css/style.css">
<!-- Page Content -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">
         <!-- Total Pengajuan Kredit -->
        <?php 
include(__DIR__ . '/../getCode/getDebiturRekap.php');
?>
<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-body iq-box-relative">
            <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-danger">
                <i class="ri-pantone-line text-white"></i>
            </div>
            <p class="text-secondary">Total Pengajuan Kredit</p>
            <div class="d-flex align-items-center justify-content-between">
                <h4><?php echo htmlspecialchars($total_riwayat); ?></h4>
                <span class="text-danger"><b><i class="ri-arrow-down-fill"></i></b></span>
            </div>
        </div>
    </div>
</div>
<!-- Total Perlu Approval -->
<?php 
include(__DIR__ . '/../getCode/getRekapPerluApp.php');
?>
<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
   <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
      <div class="iq-card-body iq-box-relative">
         <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-success">
            <i class="ri-database-2-line text-white"></i>
         </div>
            <p class="text-secondary">Pengajuan Kredit Perlu Approval</p>
            <div class="d-flex align-items-center justify-content-between">
               <h4><?php echo htmlspecialchars($total_pending_semua); ?></h4>
               <span class="text-success"><b><i class="ri-arrow-up-fill"></i></b></span>
            </div>
         </div>
      </div>
   </div>

<!-- Total Ditolak -->
<?php 
include(__DIR__ . '/../getCode/getRekapRejected.php');
?>
<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
   <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
      <div class="iq-card-body iq-box-relative">
         <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-warning">
            <i class="ri-pie-chart-2-line text-white"></i>
         </div>
         <p class="text-secondary">Pengajuan Kredit Ditolak</p>
         <div class="d-flex align-items-center justify-content-between">
            <h4><?php echo htmlspecialchars($total_rejected_semua); ?></h4>
            <span class="text-warning"><b><i class="ri-arrow-up-fill"></i></b></span>
         </div>
      </div>
   </div>
</div>
<div class="col-md-12">
   <section class="ftco-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="elegant-calencar d-md-flex">
						<div class="wrap-header d-flex align-items-center img" style="background-image: url(../cal/images/bg.jpg);">
				      <p id="reset">Today</p>
			        <div id="header" class="p-0">
						<div class="head-info">
		            	<div class="head-month"></div>
		                <div class="head-day"></div>
		            </div>
		            <!-- <div class="next-button d-flex align-items-center justify-content-center"><i class="fa fa-chevron-right"></i></div> -->
			        </div>	
			      </div>
			      <div class="calendar-wrap">
			      	<div class="w-100 button-wrap">
				      	<div class="pre-button d-flex align-items-center justify-content-center"><i class="fa fa-chevron-left"></i></div>
				      	<div class="next-button d-flex align-items-center justify-content-center"><i class="fa fa-chevron-right"></i></div>
			      	</div>
			        <table id="calendar">
		            <thead>
		                <tr>
	                    <th>Sun</th>
	                    <th>Mon</th>
	                    <th>Tue</th>
	                    <th>Wed</th>
	                    <th>Thu</th>
	                    <th>Fri</th>
	                    <th>Sat</th>
		                </tr>
		            </thead>
		            <tbody>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
	                <tr>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                  <td></td>
	                </tr>
		            </tbody>
			        </table>
			      </div>
			    </div>
				</div>
			</div>
		</div>
	</section> 
</div>
</div>
</div>
</div>
      </div>
   </div>
</div>
<!-- Page Content END -->
<script src="../cal/js/jquery.min.js"></script>
  <script src="../cal/js/popper.js"></script>
  <script src="../cal/js/bootstrap.min.js"></script>
  <script src="../cal/js/main.js"></script>
<?php include "other/footer.php"; ?>