<?php
include("../Database/koneksi.php");
function getBwkDataByPegawai($mysqli, $id_pegawai) {
    $stmt = $mysqli->prepare("
        SELECT *
        FROM users
        JOIN bwk ON users.id_pegawai = bwk.id_pegawai
        JOIN cabang ON bwk.kode_cabang = cabang.kode_cabang
        WHERE users.id_pegawai = ?
    ");

    if (!$stmt) {
        die("Query prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("s", $id_pegawai);
    $stmt->execute();
    $result = $stmt->get_result();
    $getBwk = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $getBwk;
}
?>
