<?php 
include(__DIR__ . '/../Database/koneksi.php');
$query = "SELECT * FROM cabang";
$result = $mysqli->query($query);
if ($result) {
    if ($result->num_rows > 0) {
        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $options = []; 
        echo "Belum Ada Data"; 
    }
} else {
    echo "Error in query: " . $mysqli->error; 
}
$result->free();
//$mysqli->close();
?>