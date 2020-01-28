<?php

require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'kasir');


if(isset($_POST['bayar']) && isset($_POST['uang']) && isset($_POST['id_transaksi'])){
    $id = $_POST['id_transaksi'];
    $uang= $_POST['uang'];
    $status_transaksi = 'lunas';
    $id_pelanggan=$_POST['id_pelanggan'];
    if($id_pelanggan != 0){
        $status_transaksi = 'lunas(VIP)';
    }

    $query = mysqli_query($koneksi,"UPDATE transaksi SET bayar=$uang, status_transaksi='$status_transaksi' where id_transaksi=$id");

    echo "
    <script>
        alert('Berhasil Terbayar');
        window.location='bayar.php';
    </script>
    ";
}


if(isset($_POST['semua']) && isset($_POST['semua_id_transaksi']) && isset($_POST['semua_bayaran'])){
    $semua_id = $_POST['semua_id_transaksi'];
    $semua_bayar= $_POST['semua_bayaran'];
    $id_array = explode(',',$semua_id);
    $uang_array = explode(',',$semua_bayar);
    $status_transaksi = 'lunas';
    $id_pelanggan=$_POST['id_pelanggan'];
    if($id_pelanggan != 0){
        $status_transaksi = 'lunas(VIP)';
    }
    for($j=0;$j<count($id_array);$j++){
        $id=$id_array[$j];
        $uang=$uang_array[$j];
        echo "
    <script>
        alert('$status_transaksi, $id , $uang');
      
    </script>
    ";
        $query = mysqli_query($koneksi,"UPDATE transaksi SET bayar=$uang, status_transaksi='$status_transaksi' where id_transaksi=$id");
    }

    

    echo "
    <script>
        alert('Berhasil Terbayar Semua');
        window.location='bayar.php';
    </script>
    ";
}


$query = mysqli_query($koneksi,"SELECT 
`pelanggan`.`id_pelanggan`,
`menu`.`nama_menu`,
`menu`.`harga`,
`pesanan`.`jumlah`,
`transaksi`.`id_transaksi`,
`transaksi`.`total`,
`transaksi`.`bayar`,
`transaksi`.`status_transaksi`,
`transaksi`.`petugas`
FROM `transaksi` 
NATURAL JOIN `pelanggan` 
NATURAL JOIN `menu`
NATURAL JOIN `pesanan`  
WHERE `transaksi`.`petugas`='$users' AND `transaksi`.`status_transaksi`='belum lunas' ORDER BY `transaksi`.`id_transaksi` ASC;");
$rows = mysqli_num_rows($query);
$total = 0;
$semua_id_transaksi=NULL;
$semua_bayaran=NULL;

echo<<<_END

<table border=1 id='bayar' cellpadding=4>

<tr>
<td>Nama Menu</td>
<td>Jumlah</td>
<td>Harga</td>
<td>Total</td>
</tr>

_END;



for($j=0;$j<$rows;$j++){
    $data = mysqli_fetch_array($query);
    $a=$data['nama_menu'];
    $b=$data['harga']; 
    $c=$data['jumlah'];
    $d=$data['id_transaksi'];
    $e=$data['total'];
    $f=$data['bayar'];
    $g=$data['petugas'];
    $h=$data['id_pelanggan'];
    if($h != 0){
        $e = $e*80/100;
    }
    if($j==0){
        $semua_id_transaksi=$d;
        $semua_bayaran=$e;
    }else{
        $semua_id_transaksi = $semua_id_transaksi . ',' . $d;
        $semua_bayaran = $semua_bayaran . ',' . $e;
    }
    
    $total+= $e;

    echo<<<_END

    <tr>
    <td>$a</td>
    <td>$c</td>
    <td>Rp. $b</td>
    
_END;
if($f == 0 || $f != $e){
    echo<<<_END
<form method=POST action=bayar.php>
<input type=hidden name=id_pelanggan value=$h>
<input type=hidden name=id_transaksi value=$d>
<td><input type=number name=uang value=$e> <input type=submit name=bayar value=bayar></td>
</form>

_END;


}




}
echo<<<_END
<form method=POST action=bayar.php>
<input type=hidden value=$semua_id_transaksi name='semua_id_transaksi'>
<input type=hidden value=$semua_bayaran name='semua_bayaran'>
<input type=hidden name=id_pelanggan value=$h>
<tr>
<td colspan=3>TOTAL</td>
<td>Rp. $total &emsp;&emsp;<input type=submit value='Bayar Semua' name='semua'></td>
</tr>
</form>
</table>
_END;


?>