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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data kelurahan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data kelurahan</li>
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

                        <form action="kelurahan/action_add.php" method="post">
                            <!-- Formulir untuk menambah data periksa -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="id" class="form-label">ID</label>
                                        <input type="text" class="form-control" id="id" name="id">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
                                    </div>
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
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Id</th>
                    <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Nama</th>
                    <?php if ($role === 'admin') : ?>
                        <th class="sorting" tabindex="0" aria-controls="data_pasien" rowspan="1" colspan="1">Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('dbkoneksi.php');
                $query = "SELECT * FROM kelurahan";
                $stmt = $dbh->query($query);

                $nomor = 1; // Counter for numbering rows

                // Fetch associative array
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td class="dtr-control sorting_1" tabindex="0"><?= $nomor++ ?></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nama'] ?></td>

                        <td>
                            <?php if ($role === 'admin') : ?>
                                <!-- Tombol untuk membuka modal -->
                                <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                <a type="button" class="btn btn-danger mb-2" href="kelurahan/action_delete.php?id=<?= $row['id'] ?>&delete=delete">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Modal untuk mengedit data -->
                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Data Pasien</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="kelurahan/action_edit.php" method="post">
                                        <div class="row">
                                            <div class="md-3">
                                                <label for="editid" class="form-label">ID</label>
                                                <input type="text" class="form-control" id="editid" name="id" value="<?= $row['id'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="md-3">
                                                <label for="editnama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="editnama" name="nama" value="<?= $row['nama'] ?>">
                                            </div>
                                        </div>
                                        <!-- Tambahkan elemen formulir lainnya di sini jika diperlukan -->
                                        <div class="row">
                                            <div class="modal-footer justify-content-between">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
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

<!-- /.content -->>
<!-- /.content-wrapper -->
<?php
include_once 'footer.php';
?>