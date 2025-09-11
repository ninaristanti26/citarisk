<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = $_GET['url'] ?? 'login'; 
$url = trim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

$path = "views/$url.php";

if (file_exists($path)) {
    include $path;
} else {
    http_response_code(404);
    echo "Halaman tidak ditemukan: <strong>$url</strong>";
}
