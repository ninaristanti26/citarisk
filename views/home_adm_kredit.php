<?php include "other/header.php"; ?>
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

<!-- Page Content -->
<div id="content-page" class="content-page">
   <div class="container-fluid">
      <div class="row">

         <!-- Total Petugas Marketing -->
         <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
               <div class="iq-card-body iq-box-relative">
                  <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-primary">
                     <i class="ri-focus-2-line text-white"></i>
                  </div>
                  <p class="text-secondary">Total Petugas Marketing</p>
                  <div class="d-flex align-items-center justify-content-between">
                     <h4>18</h4>
                     <span class="text-primary"><b><i class="ri-arrow-up-fill"></i></b></span>
                  </div>
               </div>
            </div>
         </div>

         <!-- Total Pengajuan Kredit -->
         <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
               <div class="iq-card-body iq-box-relative">
                  <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-danger">
                     <i class="ri-pantone-line text-white"></i>
                  </div>
                  <p class="text-secondary">Total Pengajuan Kredit</p>
                  <div class="d-flex align-items-center justify-content-between">
                     <h4>19</h4>
                     <span class="text-danger"><b><i class="ri-arrow-down-fill"></i></b></span>
                  </div>
               </div>
            </div>
         </div>

         <!-- Total Perlu Approval -->
         <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
               <div class="iq-card-body iq-box-relative">
                  <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-success">
                     <i class="ri-database-2-line text-white"></i>
                  </div>
                  <p class="text-secondary">Pengajuan Kredit Perlu Approval</p>
                  <div class="d-flex align-items-center justify-content-between">
                     <h4>5</h4>
                     <span class="text-success"><b><i class="ri-arrow-up-fill"></i></b></span>
                  </div>
               </div>
            </div>
         </div>

         <!-- Total Ditolak -->
         <div class="col-sm-6 col-md-6 col-lg-3 mb-4">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
               <div class="iq-card-body iq-box-relative">
                  <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-warning">
                     <i class="ri-pie-chart-2-line text-white"></i>
                  </div>
                  <p class="text-secondary">Pengajuan Kredit Ditolak</p>
                  <div class="d-flex align-items-center justify-content-between">
                     <h4>0</h4>
                     <span class="text-warning"><b><i class="ri-arrow-up-fill"></i></b></span>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
               <div class="iq-card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                     <h4 class="card-title">Pencapaian Target</h4>
                  </div>
               </div>
               <div class="iq-card-body row m-0 align-items-center pb-0">
                  <div class="col-md-8">
                     <div id="iq-income-chart"></div>
                  </div>
                  <div class="col-md-4">
                     <div class="chart-data-block">
                        <h4><b>Target</b></h4>
                        <h2><b>15000000</b></h2>
                        <p></p>
                           <div class="chart-box d-flex align-items-center justify-content-between mt-5 mb-5">
                              <div id="iq-chart-boxleft"></div>
                              <div id="iq-chart-boxright"></div>
                           </div>
                           <div class="mt-3 pr-3">
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="d-flex align-items-center">
                                    <span class="bg-primary p-1 rounded mr-2"></span>
                                    <p class="mb-0">Approve</p>
                                 </div>
                                 <h6><b>78%</b></h6>
                              </div>
                              <div class="d-flex align-items-center justify-content-between">
                                 <div class="d-flex align-items-center">
                                    <span class="bg-danger p-1 rounded mr-2"></span>
                                    <p class="mb-0">Rejected</p>
                                 </div>
                                 <h6><b>12%</b></h6>
                              </div>
                              </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
      </div>
   </div>
</div>
<!-- Page Content END -->

<?php include "other/footer.php"; ?>
