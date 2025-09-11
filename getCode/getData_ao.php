<?php 
include(__DIR__ . '/../Database/koneksi.php');
if (isset($_SESSION['id_role']) && ($_SESSION['id_role'] == 10)) {

    $query = "SELECT users.*, cabang.*
              FROM users
              JOIN cabang ON users.kode_cabang = cabang.kode_cabang
              WHERE cabang.kode_cabang = '".$_SESSION['kode_cabang']."'
              ORDER BY users.nama ASC";
    
    $result = $mysqli->query($query);
    
    if ($result && $result->num_rows > 0) {
        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Belum Ada Data";
    }
} else {
    $query = "SELECT users.*, cabang.*
              FROM users
              JOIN cabang ON users.kode_cabang = cabang.kode_cabang
              ORDER BY users.nama ASC";
    
    $result = $mysqli->query($query);
    
    if ($result && $result->num_rows > 0) {
        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "Belum Ada Data";
    }
}
?>
