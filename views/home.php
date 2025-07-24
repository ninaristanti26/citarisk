<?php
// Pastikan tidak ada output sebelum session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, redirect ke halaman login
    header("Location: index.php");
    exit;
}
?>
<body>
      <!-- loader Start 
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>-->
      <!-- loader END -->
      <!-- Wrapper Start -->
      <?php 
   if($_SESSION['id_role'] == 13) { 
      include("home_ao.php");

      }elseif($_SESSION['id_role'] == 12) { 
       include("home_analis.php");
            
      }elseif($_SESSION['id_role'] == 11) { 
       include("home_kaspem.php");
      
      }elseif($_SESSION['id_role'] == 15) { 
         include("home_kaspem.php");

      }elseif($_SESSION['id_role'] == 10) { 
       include("home_pinca.php");
            
      }elseif($_SESSION['id_role'] == 14) { 
       include("home_admin.php");
      
      }elseif($_SESSION['id_role'] == 9) { 
         include("home_admin.php");
      
      }elseif($_SESSION['id_role'] == 8) { 
         include("home_admin.php");

      }elseif($_SESSION['id_role'] == 7) { 
         include("home_admin.php");

      }elseif($_SESSION['id_role'] == 6) { 
         include("home_admin.php");
      
      }elseif($_SESSION['id_role'] == 5) { 
         include("home_admin.php");
      
      }elseif($_SESSION['id_role'] == 16) { 
         include("home_adm_kredit.php");}
?>