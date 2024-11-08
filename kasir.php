<?php
session_start();
session_regenerate_id();

require_once "config/koneksi.php";

$queryDetail = "SELECT * FROM penjualan";
$result = $koneksi->query($queryDetail);

// Menghitung nomor urut
$no = 1;


//Jika session kosong, maka melempar ke Login
// if (empty($_SESSION['nama']) && empty($_SESSION['email'])) {
//     header("Location: index.php");
//     exit();
// }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
</head>

<body>


    <h1 class="col-md-12 mt-1 text-center">
        Udah login nih!
        <?php echo $_SESSION['EMAILNYABRO'] ?>
    </h1>

    <!-- Navigation Bar -->
     <?php require_once "inc/navbar.php"?>
    <!-- EndNavbar -->


        <div class="container justify-content-center">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="card mt-3">
                        <div class="card-header text-center">
                            <h1>Manage Kasir</h1>
                        </div>

                        <div class="card-body">
                            <div class="table table-responsive">
                                <div class="mt-2 mb-4">
                                    <a href="tambah-transaction.php" class="btn btn-primary btn-sm">Manage Kasir</a>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Transaksi</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Struk Pembayaran</th>
                                            <th>Status Pembayaran</th>
                                            <th>Settings</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                            <?php if ($result->num_rows > 0): ?>
                                            <?php while($row = $result->fetch_assoc()): ?>
                                                <tr class="text-center">
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['kode_transaksi']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['tanggal_transaksi']); ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <!-- Tambahkan tombol atau link untuk mengedit atau menghapus transaksi -->
                                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="col-2">

                </div>

            </div>
        </div>



        <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <footer class="mt-4" style="background-color: #008080;">
    </footer>


</body>

</html>