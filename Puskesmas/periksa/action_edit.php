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
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $berat = htmlspecialchars($_POST['berat']);
    $tinggi = htmlspecialchars($_POST['tinggi']);
    $tensi = htmlspecialchars($_POST['tensi']);
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $pasien_id = htmlspecialchars($_POST['pasien_id']);
    $paramedik_id = htmlspecialchars($_POST['paramedik_id']);

    // Query untuk update data periksa berdasarkan ID
    $query = "UPDATE periksa SET tanggal = :tanggal, berat = :berat, tinggi = :tinggi, tensi = :tensi, keterangan = :keterangan, pasien_id = :pasien_id, paramedik_id = :paramedik_id WHERE id = :id";

    // Persiapkan statement
    $stmt = $dbh->prepare($query);

    // Bind parameter
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':berat', $berat);
    $stmt->bindParam(':tinggi', $tinggi);
    $stmt->bindParam(':tensi', $tensi);
    $stmt->bindParam(':keterangan', $keterangan);
    $stmt->bindParam(':pasien_id', $pasien_id);
    $stmt->bindParam(':paramedik_id', $paramedik_id);
    $stmt->bindParam(':id', $id);

    // Eksekusi statement
    if ($stmt->execute()) {
        // Jika berhasil, redirect kembali ke halaman data periksa
        header("Location: ../data_periksa.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal mengedit data periksa.";
    }
}
?>
