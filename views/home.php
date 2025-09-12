<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index");
    exit;
}

switch ($_SESSION['id_role']) {
    case 13:
        include("home_ao.php");
        break;
    case 12:
        include("home_analis.php");
        break;
    case 11:
    case 15:
        include("home_kaspem.php");
        break;
    case 10:
        include("home_pinca.php");
        break;
    case 16:
        include("home_adm_kredit.php");
        break;
    case 9:
    case 8:
    case 7:
    case 6:
    case 5:
        include("home_admin.php");
        break;
    default:
        echo "Role tidak dikenali.";
}
