<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = mysqli_prepare($db, "DELETE FROM penghuni WHERE id_penghuni = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;