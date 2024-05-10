<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: 404.php");
    exit();
}

require_once('../dbkoneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Ambil ID pasien yang akan dihapus dari parameter URL
    $id = $_GET['id'];

    // Query untuk menghapus data pasien berdasarkan ID
    $query = "DELETE FROM paramedik WHERE id = :id";

    // Persiapkan statement
    $stmt = $dbh->prepare($query);

    // Bind parameter
    $stmt->bindParam(':id', $id);

    // Jalankan statement
    if ($stmt->execute()) {
        // Jika berhasil, redirect kembali ke halaman data pasien
        header("Location: /PROJEK UTS/Puskesmas/dataparamedik.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menghapus data pasien.";
    }
} else {
    // Jika tidak ada ID yang dikirimkan, redirect ke halaman data pasien
}