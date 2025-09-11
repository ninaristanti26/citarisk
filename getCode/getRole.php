<?php 
include(__DIR__ . '/../Database/koneksi.php');

$query = "SELECT * FROM role";
$result = $mysqli->query($query);
if ($result) {
    if ($result->num_rows > 0) {
        $getRole = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $getRole = []; 
        echo "Belum Ada Data"; 
    }
} else {
    echo "Error in query: " . $mysqli->error; 
}
$result->free();
$mysqli->close();
?>