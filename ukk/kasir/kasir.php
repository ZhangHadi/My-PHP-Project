
<?php
require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'kasir');


if (isset($_POST['add']) && isset($_POST['id_transaksi'])){
    $id_transaksi=$_POST['id_transaksi'];
    $query = mysqli_query($koneksi,"UPDATE transaksi SET petugas='$users' where id_transaksi=$id_transaksi;");
}
if(isset($_POST['batal']) && isset($_POST['id_transaksi'])){
    $id_transaksi=$_POST['id_transaksi'];
    $query = mysqli_query($koneksi,"UPDATE transaksi SET petugas='' where id_transaksi=$id_transaksi;");
}

echo <<<_END
<center>
<table border=1 cellpadding=5 cellspacing=5>

<tr>
<td>Nomor</td>
<td>Nama Pelanggan</td>
<td>Nomor Meja</td>
<td>ID Pesanan</td>
<td>Nama Menu</td>
<td>Jumlah</td>
<td>Waiter</td>
<td>ID Transaksi</td>
<td>Total</td>
<td>Bayar</td>
<td>Action!</td>
</tr>



_END;
$nomor=0;

$query = mysqli_query($koneksi,"
SELECT 
`pelanggan`.`nama_pelanggan`,
`pesanan`.`nomor_meja`,
`pesanan`.`id_pesanan`,
`pesanan`.`id_menu`,
`menu`.`nama_menu`,
`pesanan`.`jumlah`,
`login`.`username`,
`transaksi`.`id_transaksi`,
`transaksi`.`total`,
`transaksi`.`bayar`,
`transaksi`.`petugas`
FROM `transaksi` 
NATURAL JOIN `pelanggan` 
NATURAL JOIN `login` 
NATURAL JOIN `menu`
NATURAL JOIN `pesanan`  
WHERE `transaksi`.`bayar`=0 AND `transaksi`.`status_transaksi`='belum lunas' ORDER BY `transaksi`.`id_transaksi` ASC;");

while($data = mysqli_fetch_array($query)){
    $nomor++;
    $b=$data['nama_pelanggan'];
    $c=$data['nomor_meja'];
    $d=$data['id_pesanan'];
    $e=$data['nama_menu'];
    $f=$data['jumlah'];
    $g=$data['username'];
    $h=$data['id_transaksi'];
    $i=$data['total'];
    $j=$data['bayar'];
    $k=$data['petugas'];


    if($k === $users){
        echo "<tr style='background:rgba(0,200,0,.8)'>";
    }else{
        echo "<tr>";
    }
        
        
        echo <<<_END
            <td>$nomor</td>
            <td>$b</td>
            <td>$c</td>
            <td>$d</td>
            <td>$e</td>
            <td>$f</td>
            <td>$g</td>
            <td>$h</td>
            <td>$i</td>
            <td>$j</td>
            <td>        

_END;
if($j != 0 || $k !== $users && $k !== ''){
    echo "
     &nbsp;&nbsp;&emsp;- </td></tr>
    ";
}elseif($k !== ''){
    echo <<<_END
    <form action='kasir.php' method=POST>
        <input type=hidden name='id_transaksi' value='$h'>
        <input type=submit value=Batal! name='batal'>
    </form>

    </td>
    </tr>
_END;
}
else{
    
    echo <<<_END
    <form action='kasir.php' method=POST>
    <input type=hidden name='id_transaksi' value=$h>
    <input type=submit value=Add! name='add'>
    </form>

    </td>
    </tr>
_END;
}
}





?>
</table>
<script>
    setFetch('./kasir.php',600000);
</script>
</body>
</html>