<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once('../dbkoneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim melalui form
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']); // Mengambil 'nama' dari $_POST
 

    // Query untuk update data unit kerja berdasarkan ID
    $query = "UPDATE unit_kerja SET nama = :nama WHERE id = :id";

    // Persiapkan statement
    $stmt = $dbh->prepare($query);

    // Bind parameter
    $stmt->bindParam(':nama', $nama); // Mengikat $nama ke parameter ':nama'
    $stmt->bindParam(':id', $id);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Jika berhasil, redirect kembali ke halaman data unit kerja
        header("Location: ../data_unitkerja.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal mengedit data unit kerja.";
    }
}
?>
