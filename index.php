<?php
session_start();
session_regenerate_id();

require_once "config/koneksi.php";
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $selectLogin = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
    if (mysqli_num_rows($selectLogin) > 0) {
        $row = mysqli_fetch_assoc($selectLogin);

        if ($row['email'] == $email && $row['password'] == $password) {
            $_SESSION['ID'] = $row['id'];
            $_SESSION['EMAILNYABRO'] = $row['email'];
            $_SESSION['NAMALENGKAPNYA'] = $row['nama_lengkap'];
            header("Location: kasir.php");
            exit;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <title>Kasir</title>
</head>
<body>

    

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Login</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mt-2">
                                <label for="" class="form-label">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Isi email Anda">
                            </div>

                            <div class="mt-3">
                                <label for="" class="form-label">Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Isi password Anda">
                            </div>

                            <div class="mt-3" align="right">
                                <button name="login" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>



    
</body>
</html>