<?php
$password_input = '12345';
$hash_from_db = '$2y$10$gpDPn/RX.vfXlmq76vYHP.3jB0HcJYgBwOB.EETXym4'; // paste hasil dari database

if (password_verify($password_input, $hash_from_db)) {
    echo "✅ Cocok";
} else {
    echo "❌ Tidak cocok";
}
