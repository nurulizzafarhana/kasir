<?php
session_start();
session_regenerate_id();


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
                                    <a href="tambah-transaction.php" class="btn btn-primary btn-sm">Kasir</a>
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
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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