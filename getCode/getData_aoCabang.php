<?php 
include(__DIR__ . '/../Database/koneksi.php');

$kode_cabang = $_SESSION['kode_cabang'];

$query = "SELECT users.*, cabang.*
          FROM users
          JOIN cabang ON users.kode_cabang = cabang.kode_cabang
          JOIN role ON users.id_role = role.id_role
          WHERE cabang.kode_cabang = ?
          AND role.id_role = 13
          ORDER BY users.nama ASC";

$stmt = $mysqli->prepare($query);
if ($stmt) {
    $stmt->bind_param("s", $kode_cabang); // "s" untuk string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $getData_aoCabang = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Belum Ada Data";
    }

    $stmt->close();
} else {
    echo "Query error: " . $mysqli->error;
}
?>
