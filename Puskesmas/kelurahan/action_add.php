<?php
require_once("../dbkoneksi.php");

if (isset($_POST['submit'])) {
    $id = htmlspecialchars($_POST['id']);
    $nama = htmlspecialchars($_POST['nama']);

    // Check for empty fields
    if (empty($id) || empty($nama)) {
        // Handle empty fields
        echo "<p><font color='red'>ID dan Nama Unit Kerja wajib diisi!</font></p>";
    } else {
        // If all fields are filled, insert data into database
        $query = "INSERT INTO kelurahan (id, nama) VALUES (:id, :nama)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);

        if ($stmt->execute()) {
            header("Location: /PROJEK UTS/Puskesmas/data_kelurahan.php");
            exit(); // Pastikan untuk keluar dari skrip setelah mengalihkan pengguna
        } else {
            echo "<p><font color='red'>Gagal menambahkan data.</font></p>";
        }
    }
}
?>
