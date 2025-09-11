<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * FROM adm";
$result = $mysqli->query($query);
if ($result) {
    if ($result->num_rows > 0) {
        $getAdm = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $getAdm = []; 
        echo "Belum Ada Data"; 
    }
} else {
    echo "Error in query: " . $mysqli->error; 
}
$result->free();
//$mysqli->close();
?>