<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once('../dbkoneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Ambil data yang dikirim melalui form
// Ambil data yang dikirim melalui form
$id = $_POST['id'];
$nama = htmlspecialchars($_POST['nama']); // Sesuaikan dengan nama elemen form
$tmp_lahir = htmlspecialchars($_POST['tmp_lahir']); // Sesuaikan dengan nama elemen form
$tgl_lahir = htmlspecialchars($_POST['tgl_lahir']); // Sesuaikan dengan nama elemen form
$gender = htmlspecialchars($_POST['gender']); // Sesuaikan dengan nama elemen form
$telpon = htmlspecialchars($_POST['telpon']); // Sesuaikan dengan nama elemen form
$alamat = htmlspecialchars($_POST['alamat']); // Sesuaikan dengan nama elemen form
$unit_kerja_id = htmlspecialchars($_POST['unit_kerja_id']); // Sesuaikan dengan nama elemen form


// Query untuk update data paramedik berdasarkan ID
$query = "UPDATE paramedik SET nama = :nama, tmp_lahir = :tmp_lahir, tgl_lahir = :tgl_lahir, gender = :gender, telpon = :telpon, alamat = :alamat, unit_kerja_id = :unit_kerja_id WHERE id = :id";

// Persiapkan statement
$stmt = $dbh->prepare($query);

// Bind parameter
$stmt->bindParam(':nama', $nama);
$stmt->bindParam(':tmp_lahir', $tmp_lahir);
$stmt->bindParam(':tgl_lahir', $tgl_lahir);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':telpon', $telpon);
$stmt->bindParam(':alamat', $alamat);
$stmt->bindParam(':unit_kerja_id', $unit_kerja_id);
$stmt->bindParam(':id', $id);

// Eksekusi statement
$stmt->execute();


    // Jalankan statement
    if ($stmt->execute()) {
        // Jika berhasil, redirect kembali ke halaman data pasien
        header("Location: ../dataparamedik.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal mengedit data pasien.";
    }
}
?>
