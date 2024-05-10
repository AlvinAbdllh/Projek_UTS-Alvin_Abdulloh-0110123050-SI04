<?php
require_once("../dbkoneksi.php");

if (isset($_POST['submit'])) {
    $tanggal = htmlspecialchars($_POST['tanggal']);
    $berat = htmlspecialchars($_POST['berat']);
    $tinggi = htmlspecialchars($_POST['tinggi']);
    $tensi = htmlspecialchars($_POST['tensi']);
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $pasien_id = htmlspecialchars($_POST['pasien_id']);
    $paramedik_id = htmlspecialchars($_POST['paramedik_id']);

    // Check for empty fields
    if (empty($tanggal) || empty($pasien_id) || empty($paramedik_id)) {
        // Handle empty fields
        echo "<p><font color='red'>Tanggal, ID Pasien, dan ID Paramedik wajib diisi!</font></p>";
    } else {
        // If all fields are filled, insert data into database
        $query = "INSERT INTO periksa (tanggal, berat, tinggi, tensi, keterangan, pasien_id, paramedik_id) VALUES (:tanggal, :berat, :tinggi, :tensi, :keterangan, :pasien_id, :paramedik_id)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':berat', $berat);
        $stmt->bindParam(':tinggi', $tinggi);
        $stmt->bindParam(':tensi', $tensi);
        $stmt->bindParam(':keterangan', $keterangan);
        $stmt->bindParam(':pasien_id', $pasien_id);
        $stmt->bindParam(':paramedik_id', $paramedik_id);

        if ($stmt->execute()) {
            header("Location: /PROJEK UTS/Puskesmas/data_periksa.php");
            exit(); // Pastikan untuk keluar dari skrip setelah mengalihkan pengguna
        } else {
            echo "<p><font color='red'>Gagal menambahkan data.</font></p>";
        }
        
    }
}
?>
