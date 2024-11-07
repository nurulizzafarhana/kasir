<?php
session_start();
session_regenerate_id();
date_default_timezone_set("Asia/Jakarta");

require_once "config/koneksi.php";

//Time
$currentTime = date('Y-m-d');

//generateTransactionCode()
function generateTransactionCode(){
    $kode = date('YmdHis');

    return $kode;
}

//click_count
if (empty($_SESSION['click_count'])) {
    $_SESSION['click_count'] = 0;
}






?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah - Transaksi</title>
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
                <div class="col-1"></div>

                <div class="col-10 mt-4">
                    <form action="" method="POST">
                        <div class="mb-1">
                            <label class="form-label" for="" >Kode Transaksi</label>
                            <input id="kode_transaksi" name="kode_transaksi" class="form-control w-50" type="text" value="<?php echo "TR-" . generateTransactionCode() ?>" readonly>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="" >Tanggal Transaksi</label>
                                <input id="tanggal_transaksi" name="tanggal_transaksi" class="form-control" type="date" value="<?php echo $currentTime ?>" readonly>
                        </div>

                        <div class="mt-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <button id="counterBtn" type="button" class="btn btn-primary btn-sm">Tambah</button>
                                </div>
                                <div class="col-auto">
                                    <input id="countDisplay" name="countDisplay" class="form-control mt-3 mt-sm-0" value="<?php echo $_SESSION['click_count'] ?>" type="number" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="table table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Kategori</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Sisa Produk</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    <!-- data ditambah di sini -->
                                </tbody>

                                <tfoot class="text-center"> 
                                    <tr>
                                        <th colspan="5">Total Harga</th>
                                        <td><input type="number" id="total_harga_keseluruhan" name="total_harga" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">Nominal Bayar</th>
                                        <td><input type="number" id="nominal_bayar_keseluruhan" name="nominal_bayar" class="form-control" readonly></td>
                                    </tr>
                                    <tr>
                                        <th colspan="5">Kembalian</th>
                                        <td><input type="number" id="kembalian_keseluruhan" name="kembalian" class="form-control" readonly></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <br>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary" name="simpan" value="Hitung">
                            <a href="kasir.php" class="btn btn-danger">Kembali</a>
                        </div>
                    </form>
                </div>
                <div class="col-1"></div>
            </div>
        </div>


        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM kategori_barang");
        $categories = mysqli_fetch_all($query, MYSQLI_ASSOC);
        ?>


        <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                //fungsi tambah baris
                const button = document.getElementById('counterBtn');
                const countDisplay = document.getElementById('countDisplay');
                const tbody = document.getElementById('tbody');

                button.addEventListener('click', function() {
                    let currentCount = parseInt(countDisplay.value) || 0;
                    currentCount++;
                    countDisplay.value = currentCount;

                    //fungsi tambah td
                    let newRow = "<tr>";
                    newRow += "<td>" + currentCount + "</td>";
                    newRow += "<td><select class='form-control category-select' name='id_kategori[]' required>";
                    newRow += "<option value=''>--Pilih Kategori--</option>";
                    <?php foreach ($categories as $category) { ?>
                        newRow += "<option value='<?php echo $category['id'] ?>'><?php echo $category['nama_kategori'] ?></option>";
                    <?php
                    } ?>
                    newRow += "</select></td>";
                    newRow += "<td><select class='form-control item-select' name='id_barang[]' required>";
                    newRow += "<option value=''>--Pilih Barang--</option>";
                    newRow += "</select></td>";
                    newRow += "<td><input type='number' name='jumlah[]' class='form-control jumlah-input' value='0' required></td>";
                    newRow += "<td><input type='number' name='sisa_produk[]' class='form-control' readonly></td>";
                    newRow += "<td><input type='number' name='harga[]' class='form-control' readonly></td>";
                    newRow += "</tr>";
                    tbody.insertAdjacentHTML('beforeend', newRow);

                    attachCategoryChangeListener();
                    attachItemChangeListener();
                    attachJumlahChangeListener();
                });

                function attachCategoryChangeListener(){
                    const categorySelects = document.querySelectorAll('.category-select');
                    categorySelects.forEach(select => {
                        select.addEventListener('change', function(){
                            const categoryId = this.value;
                            const itemSelect = this.closest('tr').querySelector('.item-select');
                                if (categoryId) {
                                fetch(`controller/get-product-dari-category.php?id_kategori=${categoryId}`)
                                .then(response => response.json())
                                .then(data => {
                                    itemSelect.innerHTML = "<option value=''>--Pilih Barang--</option>";
                                    data.forEach(item => {
                                        itemSelect.innerHTML += `<option value='${item.id}'>${item.nama_barang}</option>`;
                                    });
                                });
                                } else {
                                    itemSelect.innerHTML = "<option value=''>--Pilih Barang--</option>";
                                }
                        });
                    });
                }


                //untuk menampilkan qty dan harga
                function attachItemChangeListener() {
                    const itemSelects = document.querySelectorAll('.item-select');
                    itemSelects.forEach(select => {
                        select.addEventListener('change', function(){
                            const itemId = this.value;
                            const row = this.closest('tr');
                            const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                            const hargaInput = row.querySelector('input[name="harga[]"]');

                            if (itemId) {
                                fetch('controller/get-barang-details.php?id_barang=' + itemId)
                                    .then(response => response.json())
                                    .then(data => {
                                        sisaProdukInput.value = data.qty;
                                        hargaInput.value = data.harga;
                                    })
                            } else {
                                sisaProdukInput.value = '';
                                hargaInput.value = '';
                            }
                        });
                    });
                }

                function attachJumlahChangeListener(){
                    const jumlahInputs = document.querySelectorAll('.jumlah-input');
                    jumlahInputs.forEach(input => {
                        input.addEventListener('input', function() {
                            const row = this.closest('tr');
                            const sisaProdukInput = row.querySelector('input[name="sisa_produk[]"]');
                            const hargaInput = row.querySelector('input[name="harga[]"]');
                            const nominalBayarInput = document.getElementById('nominal_bayar_keseluruhan');
                            const kembalianInput = document.getElementById('kembalian_keseluruhan');

                            const jumlah = parseInt(this.value) || 0;
                            const sisaProduk = parseInt(sisaProdukInput.value) || 0;
                            const harga = parseFloat(hargaInput.value) || 0;

                            if (jumlah > sisaProduk) {
                                alert("Jumlah tidak boleh melebihi sisa produk");
                                this.value = sisaProduk;
                                return;
                            }
                        });
                    });
                }


            })
        </script>

    <footer class="mt-4" style="background-color: #008080;">
    </footer>


</body>

</html>