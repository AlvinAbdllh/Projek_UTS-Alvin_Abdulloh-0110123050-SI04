<?php
require_once("../dbkoneksi.php");

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $tmp_lahir = htmlspecialchars($_POST['tmp_lahir']);
    $tgl_lahir = htmlspecialchars($_POST['tgl_lahir']);
    $gender = htmlspecialchars($_POST['gender']);
    $telpon = htmlspecialchars($_POST['telpon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $unit_kerja_id = htmlspecialchars($_POST['unit_kerja_id']); // Ubah nama variabel

    // Check for empty fields
    if (empty($nama) || empty($tmp_lahir) || empty($tgl_lahir) || empty($gender) || empty($telpon) || empty($alamat) || empty($unit_kerja_id)) {
        // Handle empty fields
        echo "<p><font color='red'>All fields are required!</font></p>";
    } else {
        // If all fields are filled, insert data into database
        $query = "INSERT INTO paramedik (nama, tmp_lahir, tgl_lahir, gender, telpon, alamat, unit_kerja_id) VALUES (:nama, :tmp_lahir, :tgl_lahir, :gender, :telpon, :alamat, :unit_kerja_id)"; // Ubah nama tabel dan kolom
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':tmp_lahir', $tmp_lahir);
        $stmt->bindParam(':tgl_lahir', $tgl_lahir);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':telpon', $telpon);
        $stmt->bindParam(':alamat', $alamat);
        $stmt->bindParam(':unit_kerja_id', $unit_kerja_id); // Ubah nama kolom

        if ($stmt->execute()) {
            header("Location: /PROJEK UTS/Puskesmas/dataparamedik.php");
            exit(); // Pastikan untuk keluar dari skrip setelah mengalihkan pengguna
        } else {
            echo "<p><font color='red'>Failed to add data.</font></p>";
        }
        
    }
}
?>
