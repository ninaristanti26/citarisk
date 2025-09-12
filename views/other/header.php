<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index");
    exit;
}
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>CitaRisk | BPR Sukabumi</title>
      <link rel="shortcut icon" href="../layout/images/favicon.ico" />
      <link rel="stylesheet" href="../layout/css/bootstrap.min.css">
      <link rel="stylesheet" href="../layout/css/typography.css">
      <link rel="stylesheet" href="../layout/css/style.css">
      <link rel="stylesheet" href="../layout/css/responsive.css">
      <link href='../layout/fullcalendar/core/main.css' rel='stylesheet' />
      <link href='../layout/fullcalendar/daygrid/main.css' rel='stylesheet' />
      <link href='../layout/fullcalendar/timegrid/main.css' rel='stylesheet' />
      <link href='../layout/fullcalendar/list/main.css' rel='stylesheet' />
      <link href="../datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
      <link href="../datatables-responsive/dataTables.responsive.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="../layout/css/flatpickr.min.css">
   </head>
   <body>
<?php 
   if($_SESSION['id_role'] == 13) { 
      include("header_ao.php");

      }elseif($_SESSION['id_role'] == 12) { 
       include("header_analis.php");
            
      }elseif($_SESSION['id_role'] == 11) { 
       include("header_kaspem.php");
      
      }elseif($_SESSION['id_role'] == 15) { 
         include("header_kaspem.php");

      }elseif($_SESSION['id_role'] == 10) { 
       include("header_pinca.php");
            
      }elseif($_SESSION['id_role'] == 14) { 
       include("header_admin.php");
      
      }elseif($_SESSION['id_role'] == 9) { 
         include("header_admin.php");
      
      }elseif($_SESSION['id_role'] == 8) { 
         include("header_admin.php");

      }elseif($_SESSION['id_role'] == 7) { 
         include("header_admin.php");

      }elseif($_SESSION['id_role'] == 6) { 
         include("header_admin.php");
      
      }elseif($_SESSION['id_role'] == 5) { 
         include("header_admin.php");
      
      }elseif($_SESSION['id_role'] == 16) { 
         include("header_adm_kredit.php");}
?>
         <!-- TOP Nav Bar END -->