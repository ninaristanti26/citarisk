<div class="wrapper">
    <div class="iq-sidebar">
        <div class="iq-navbar-logo d-flex justify-content-between">
            <a href="index" class="header-logo">
              <img src="../layout/images/C.png" class="img-fluid rounded" alt="">
               <span>CitaRisk</span>
               </a>
               <div class="iq-menu-bt align-self-center">
                  <div class="wrapper-menu">
                     <div class="main-circle"><i class="ri-menu-line"></i></div>
                     <div class="hover-circle"><i class="ri-close-fill"></i></div>
                  </div>
               </div>
            </div>
            <div id="sidebar-scrollbar">
               <nav class="iq-sidebar-menu">
                  <ul id="iq-sidebar-toggle" class="iq-menu">
                    <li class="">
                        <a href="home" class="iq-waves-effect" >
                            <span class="ripple rippleEffect"></span>
                                <i class="las la-home iq-arrow-left"></i>
                                    <span>Dashboard</span>
                                    <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="data_debitur" class="iq-waves-effect" >
                            <span class="ripple rippleEffect"></span>
                                <i class="las ri-table-line iq-arrow-left"></i>
                                    <span>Data Debitur</span>
                                    <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                        </a>
                    </li>
                   <!-- <li>
                        <a href="#tables" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-table-line iq-arrow-left"></i><span>Data Based</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="tables" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                           <li><a href="data_debitur"><i class="ri-table-line"></i>Data Debitur</a></li>
                           <li><a href="data_ao"><i class="ri-database-line"></i>Data Petugas Marketing</a></li>
                           <li><a href="table-editable.html"><i class="ri-refund-line"></i>Data Cabang</a></li>
                        </ul>
                    </li>-->
                    <li>
                        <a href="#charts" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-pie-chart-box-line iq-arrow-left"></i><span>Reports</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                        <ul id="charts" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="laporan_kredit?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>"><i class="ri-folder-chart-2-line"></i>Laporan Kredit</a></li>
                        <li><a href="laporan_kredit_approved"><i class="ri-folder-chart-2-line"></i>Laporan Kredit Approved</a></li>
                        <li><a href="laporan_kredit_rejected"><i class="ri-folder-chart-2-line"></i>Laporan Kredit Rejected</a></li>
                        <li><a href="laporan_pencapaian?id_pegawai=<?php echo $_SESSION['id_pegawai']; ?>"><i class="ri-folder-chart-2-line"></i>Laporan Pencapaian</a></li>
                        </ul>
                     </li>
                  </ul>
               </nav>
               <div class="p-3"></div>
            </div>
         </div>
         <!-- TOP Nav Bar -->
         <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                  <div class="iq-menu-bt d-flex align-items-center">
                     <div class="wrapper-menu">
                        <div class="main-circle"><i class="ri-menu-line"></i></div>
                        <div class="hover-circle"><i class="ri-close-fill"></i></div>
                     </div>
                     <div class="iq-navbar-logo d-flex justify-content-between ml-3">
                        <a href="index.html" class="header-logo">
                        <img src="images/logo.png" class="img-fluid rounded" alt="">
                        <span>LENS</span>
                        </a>
                     </div>
                  </div>
                  <style>
                     .custom-badge {
                     background-color:rgb(6, 43, 98);
                     color: white;
                     padding: 0.5em 1em;
                     border-radius: 0.5rem;
                     font-size: 1rem;
                     font-weight: 500;
                     }
                  </style>
                  <span class="custom-badge"><b>Credit Analysis and Risk</b></span>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto navbar-list">
                        <li class="nav-item nav-icon dropdown"><a href="#" class=""></a></li>
                     </ul>
                  </div>
                  <ul class="navbar-list">
                     <li class="line-height">
                        <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                           <img src="../layout/images/C.png" class="img-fluid rounded mr-3" alt="user">
                           <div class="caption">
                              <h6 class="mb-0 line-height"><?php echo $_SESSION['nama']; ?></h6>
                           </div>
                        </a>
                        <div class="iq-sub-dropdown iq-user-dropdown">
                           <div class="iq-card shadow-none m-0">
                              <div class="iq-card-body p-0 ">
                                 <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">Hello <?php echo $_SESSION['nama']; ?></h5>
                                    <span class="text-white font-size-12">Available</span>
                                 </div>
                                 <a href="#" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                       <div class="rounded iq-card-icon iq-bg-primary">
                                          <i class="ri-file-user-line"></i>
                                       </div>
                                       <div class="media-body ml-3">
                                          <h6 class="mb-0 ">My Profile</h6>
                                          <p class="mb-0 font-size-12">View personal profile details.</p>
                                       </div>
                                    </div>
                                 </a>
                                 <div class="d-inline-block w-100 text-center p-3">
                                    <a class="bg-primary iq-sign-btn" href="other/logout" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>