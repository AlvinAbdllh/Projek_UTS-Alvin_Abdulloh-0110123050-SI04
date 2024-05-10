<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<?php
include_once 'header.php';
include_once 'sidebar.php';
?>

<?php
require_once('dbkoneksi.php');

// Query untuk mengambil data pasien
$query_pasien = "SELECT id, nama FROM pasien";
$stmt_pasien = $dbh->query($query_pasien);
$pasiens = $stmt_pasien->fetchAll(PDO::FETCH_ASSOC);

// Query untuk mengambil data paramedik
$query_paramedik = "SELECT id, nama FROM paramedik";
$stmt_paramedik = $dbh->query($query_paramedik);
$paramediks = $stmt_paramedik->fetchAll(PDO::FETCH_ASSOC);
?>


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Periksa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Periksa</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Data</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Formulir untuk menambah data -->

                        <form action="periksa/action_add.php" method="post">
                            <!-- Formulir untuk menambah data periksa -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="berat" class="form-label">Berat Badan</label>
                                        <input type="number" class="form-control" id="berat" name="berat">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tinggi" class="form-label">Tinggi Badan</label>
                                        <input type="number" class="form-control" id="tinggi" name="tinggi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tensi" class="form-label">Tensi</label>
                                        <input type="text" class="form-control" id="tensi" name="tensi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pasien_id" class="form-label">Pasien</label>
                                <select class="form-control" id="pasien_id" name="pasien_id">
                                    <?php foreach ($pasiens as $pasien) : ?>
                                        <option value="<?php echo $pasien['id']; ?>"><?php echo $pasien['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="paramedik_id" class="form-label">Paramedik</label>
                                <select class="form-control" id="paramedik_id" name="paramedik_id">
                                    <?php foreach ($paramediks as $paramedik) : ?>
                                        <option value="<?php echo $paramedik['id']; ?>"><?php echo $paramedik['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


    </section>

    <!-- Main content -->
    <div class="card-body">
        <?php if ($role === 'admin') : ?>
            <!-- Tombol "Add New Data" hanya ditampilkan untuk admin -->
            <a type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-default">Add New Data</a>
        <?php endif; ?>

        <table id="data_pasien" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="data_pasien_info">
            <thead>
                <tr>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1" aria-sort="ascending">No</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Tanggal</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Berat</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Tinggi</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Tensi</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Keterangan</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Pasien id</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Paramedik id</th>
                    <?php if ($role === 'admin') : ?>
                        <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('dbkoneksi.php');
                $query = "SELECT * FROM periksa";
                $stmt = $dbh->query($query);

                $nomor = 1; // Counter for numbering rows

                // Fetch associative array
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td class="dtr-control sorting_1" tabindex="0"><?= $nomor++ ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['berat'] ?></td>
                        <td><?= $row['tinggi'] ?></td>
                        <td><?= $row['tensi'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td><?= $row['pasien_id'] ?></td>
                        <td><?= $row['paramedik_id'] ?></td>

                        <td>
                            <?php if ($role === 'admin') : ?>
                                <!-- Tombol untuk membuka modal -->
                                <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                <a type="button" class="btn btn-danger mb-2" href="periksa/action_delete.php?id=<?= $row['id'] ?>&delete=delete">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Modal untuk mengedit data -->
                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Data Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="periksa/action_edit.php" method="post">
                                        <!-- Hidden input untuk menyimpan ID pasien -->
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                        <!-- Formulir untuk mengedit data -->
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="editTanggal" class="form-label">Tanggal</label>
                                                    <input type="date" class="form-control" id="editTanggal" name="tanggal" value="<?= $row['tanggal'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editBerat" class="form-label">Berat Badan</label>
                                                    <input type="number" class="form-control" id="editBerat" name="berat" value="<?= $row['berat'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editTinggi" class="form-label">Tinggi Badan</label>
                                                    <input type="number" class="form-control" id="editTinggi" name="tinggi" value="<?= $row['tinggi'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editTensi" class="form-label">Tensi</label>
                                                    <input type="text" class="form-control" id="editTensi" name="tensi" value="<?= $row['tensi'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editKeterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" id="editKeterangan" name="keterangan" rows="3"><?= $row['keterangan'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="editPasienId" class="form-label">ID Pasien</label>
                                                    <select class="form-control" id="editPasienId" name="pasien_id">
                                                        <?php foreach ($pasiens as $pasien) : ?>
                                                            <option value="<?php echo $pasien['id']; ?>" <?php echo ($row['pasien_id'] == $pasien['id']) ? 'selected' : ''; ?>><?php echo $pasien['nama']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editParamedikId" class="form-label">ID Paramedik</label>
                                                    <select class="form-control" id="editParamedikId" name="paramedik_id">
                                                        <?php foreach ($paramediks as $paramedik) : ?>
                                                            <option value="<?php echo $paramedik['id']; ?>" <?php echo ($row['paramedik_id'] == $paramedik['id']) ? 'selected' : ''; ?>><?php echo $paramedik['nama']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>



    <!-- Modal untuk mengedit data -->




</div>



<!-- Modal -->

<!-- /.content -->
<!-- /.content-wrapper -->
<?php
include_once 'footer.php';
?>