<?php
require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'waiter');

if(isset($_POST['jumlah']) && isset($_POST['nomor_meja'])){
    $id_pelanggan = 0;
        if($_POST['nama_pelanggan'] != ''){
            $nama_pelanggan= $_POST['nama_pelanggan'];
            $query = mysqli_query($koneksi,"select id_pelanggan from pelanggan where nama_pelanggan='$nama_pelanggan';");
            $row = mysqli_fetch_array($query, MYSQLI_NUM);
            if(mysqli_num_rows($query) == 0){
                echo "
                <script>
                    alert('Nama Pelanggan Tidak Ditemukan');
                    window.location='waiter_orderan.php';
                </script>
                ";
            }
            $id_pelanggan = $row[0];
        }
    $jumlah = $_POST['jumlah'];
    $nomor_meja = $_POST['nomor_meja'];
    $id_menu = $_POST['id_menu'];
    $query = mysqli_query($koneksi,"INSERT INTO pesanan VALUES (NULL,$id_menu,$id_pelanggan,$jumlah,$id_users,$nomor_meja,'pending')");
    if($query){
        echo"
        <script>
            alert('Lanjut!');
            window.location='waiter_orderan.php';
        </script>
        ";
    }
    }
    

$query = mysqli_query($koneksi,"SELECT * FROM `menu` WHERE photo_location != '' ;");
if(!$query) die($koneksi->error);
$rows = mysqli_num_rows($query);

echo" <input type=search id='search-all' placeholder='SEARCH IT' style='position:sticky;top:7px;left:45%'> <br /><br />";

for($j=0;$j < $rows;++$j){
	$row = mysqli_fetch_array($query,MYSQLI_ASSOC);
    $nama=$row['nama_menu'];
    $harga=$row['harga'];
    $picture=$row['photo_location'];
    $id=$row['id_menu'];
    $id_table=strtolower($nama);

    echo <<<_END
    <form action="waiter_orderan.php" method="post">
    <table border="1" cellspacing=5 cellpadding=2  id='$id_table'>
    <input type=hidden name=id_menu value=$id>
    <tr>
    <td rowspan=7><img src="../Picture/$picture" width=250></td>
    </tr>
    <tr>
        <td>Nama Menu</td>
        <td><input type=hidden value='$nama' name=nama>$nama</td>
    </tr>
    <tr>
        <td>Harga</td>   
        <td><input type=hidden value=$harga name=harga>Rp. $harga</td>
    </tr>
    <tr>
        <td>Jumlah</td>
        <td><input type="number" name="jumlah"></td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td><input type="text" name="nama_pelanggan" placeholder="ONLY FOR VIP"></td>
    </tr>
    <tr>
        <td>Nomor Meja</td>
        <td><input type="text" name="nomor_meja"></td>
    </tr>

    <tr>
        <td colspan=2 align=center><input type="submit" value="add"></td>       
    </tr>
    
    </table>
    
    </form>
_END;
}
?>
<script>
    let search = document.getElementById('search-all');
    let table = document.getElementsByTagName("table");
    search.oninput = () => {
        for(j=0;j<table.length;j++){
            data=table[j].getAttribute('id');
            data2 = document.getElementById(data);
            console.log(search.value);
            if(data.toLowerCase().indexOf(search.value) >- 1){
                data2.style.display = '';
            }else{
                data2.style.display = 'none';
            }
        }
    }
</script>            
</body>
</html>
