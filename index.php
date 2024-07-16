<?php
session_start();
require_once "function.php";

if (!isset($_SESSION["akun-admin"]) && !isset($_SESSION["akun-user"])) {
    header("Location: login.php");
    exit;
}

// Ambil data berdasarkan query yang sesuai dengan parameter GET
if (isset($_GET["transaksi"])) {
    $menu = ambil_data("SELECT * FROM transaksi");
} else if (isset($_GET["pesanan"])) {
    $menu = ambil_data("SELECT p.kode_pesanan, tk.nama_pelanggan, p.kode_menu, p.qty FROM pesanan AS p JOIN transaksi AS tk ON (tk.kode_pesanan = p.kode_pesanan)");
} else {
    if (!isset($_GET["search"])) {
        $menu = ambil_data("SELECT * FROM menu ORDER BY kode_menu DESC");
    } else {
        $key_search = $_GET["key-search"];
        $menu = ambil_data("SELECT * FROM menu WHERE nama LIKE '%$key_search%' OR harga LIKE '%$key_search%' OR kategori LIKE '%$key_search%' OR `status` LIKE '%$key_search%' ORDER BY kode_menu DESC");
    }
}

// Proses pesanan jika form pesan dikirim
if (isset($_POST["pesan"])) {
    $pesanan = tambah_data_pesanan();
    echo $pesanan > 0 ? "<script>alert('Pesanan Berhasil Dikirim!');</script>" : "<script>alert('Pesanan Gagal Dikirim!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <title>Menu</title>
</head>
<body>

<!-- Container untuk navbar -->
<nav class="navbar">

<!-- Daftar tak-terurut untuk item navigasi -->
<ul class="navbar-list">

<!-- Tautan untuk halaman "Home" -->
<li class="navbar-item"> <a href="index.php">MENU</a></li>


<!-- Tautan "Services" dengan menu dropdown -->
<li class="navbar-item dropdown">
<a href="index.php?pesanan">PESANAN</a>

<!-- Kontainer untuk konten dropdown -->
<div class="dropdown-content">
<a href="#">Service 1</a>
<a href="#">Service 2</a>
<a href="#">Service 3</a>
</div>
</li>

<!-- Tautan untuk halaman "About" -->
<li class="navbar-item"><a href="index.php?transaksi">TRANSAKSI</a></li>

<!-- Tautan untuk halaman "Contact" -->
<li class="navbar-item"><a href="logout.php" onclick="return confirm('Ingin Logout?')">Logout</a></li>

</ul>
</nav>
    
    <!-- Header 
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="#">PPP</a>
        </div>
        <ul class="navbar-list">
            
                <li class="navbar-item dropdown">
                    <a href="#">Manage</a>
                    <div class="dropdown-content">
                        <a href="index.php">MENU</a>
                        <a href="index.php?pesanan">PESANAN</a>
                        <a href="index.php?transaksi">TRANSAKSI</a>
                    </div>
                </li>
           
            <li class="navbar-item"><a href="logout.php" onclick="return confirm('Ingin Logout?')">Logout</a></li>
        </ul>
    </nav>-->
    <?php if (isset($_SESSION["akun-admin"])) { ?>
        <?php } ?>
    
    <!-- Content -->
    <div class="container">
        <?php
        // Memuat halaman berdasarkan parameter GET yang diberikan
        if (isset($_GET["pesanan"])) include "halaman/pesanan.php";
        else if (isset($_GET["transaksi"])) include "halaman/transaksi.php";
        else include "halaman/beranda.php";
        ?>
    </div>
</body>
</html>
