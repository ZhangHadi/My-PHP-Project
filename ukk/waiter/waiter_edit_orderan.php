<?php
require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'waiter');

if(isset($_POST['nama_pelanggan_baru']) &&
isset($_POST['nomor_meja_baru']) &&
isset($_POST['id_pesanan']) &&
isset($_POST['nama_menu_baru']) &&
isset($_POST['jumlah_baru'])
){

    $a=strtolower($_POST['nama_pelanggan_baru']);
    $b=$_POST['nomor_meja_baru'];
    $c=$_POST['id_pesanan'];
    $d=$_POST['nama_menu_baru'];
    $e=$_POST['jumlah_baru'];

    $query = mysqli_query($koneksi,"SELECT * FROM pelanggan where nama_pelanggan='$a';");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $y = $row['id_pelanggan'];
    if($y === ''){
        echo "<script>
        alert('ADA KESALAHAN PADA NAMA PELANGGAN YANG BARU!');
        window.location = 'waiter_edit_orderan.php';
        </script>";
    }
    $query = mysqli_query($koneksi,"SELECT * FROM menu where nama_menu='$d';");
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $z = $row['id_menu'];
    if($z === ''){
        echo "<script>
        alert('ADA KESALAHAN PADA NAMA MENU YANG BARU!');
        window.location = 'waiter_edit_orderan.php';
        </script>";
    }


    $query = mysqli_query($koneksi,"UPDATE pesanan SET id_pelanggan='$y' WHERE id_pesanan='$c';");
    $query = mysqli_query($koneksi,"UPDATE pesanan SET nomor_meja='$b' WHERE id_pesanan='$c';");
    $query = mysqli_query($koneksi,"UPDATE pesanan SET id_menu='$z' WHERE id_pesanan='$c';");
    $query = mysqli_query($koneksi,"UPDATE pesanan SET jumlah='$e' WHERE id_pesanan='$c';");

    echo"
    <script>
        alert('SUDAH KE EDIT!');
        window.location = 'waiter_ngantar_orderan.php';
    </script>
    ";

}


if(isset($_POST['nama_pelanggan']) &&
isset($_POST['nomor_meja']) &&
isset($_POST['id_pesanan']) &&
isset($_POST['nama_menu']) &&
isset($_POST['jumlah'])
){

    $nama_pelanggan=$_POST['nama_pelanggan'];    
    $nomor_meja=$_POST['nomor_meja'];
    $id_pesanan=$_POST['id_pesanan'];
    $nama_menu=$_POST['nama_menu'];
    $jumlah=$_POST['jumlah'];

    echo<<<_END

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Order</title>
    
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <form action="waiter_edit_orderan.php" method="post">
        
        <table border=1>
        <tr>
        <td colspan=2 align=center><h2>Edit Orderan!</h2></td>
        </tr>
        
        <tr>
        <td>ID Pesanan</td>
        <td><input type="disabled" name="id_pesanan" value=$id_pesanan></td>
        </tr>

        <tr>
        <td>Nama Pelanggan</td>
        <td><input type="text" name="nama_pelanggan_baru" value='$nama_pelanggan'></td>
        </tr>

        <tr>
        <td>Nama Menu</td>
        <td><input type="text" name="nama_menu_baru" value='$nama_menu'></td>
        </tr>
        
        <tr>
        <td>Jumlah</td>
        <td><input type="number" name="jumlah_baru" value=$jumlah></td>
        </tr>

        <tr>
        <td>Nomor_Meja</td>
        <td><input type="number" name="nomor_meja_baru" value=$nomor_meja></td>
        </tr>

        <tr>
        <td colspan=2 align=center><input type="submit" name="submit" value="Upload"></td>       
        </tr>
        </table>
        </form>
        </body>
        </html>

_END;

}

?>