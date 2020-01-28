<?php
require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'waiter');

if (isset($_POST['done']) && isset($_POST['id_pesanan']) && isset($_POST['total'])){
    $id_pesanan=$_POST['id_pesanan'];
    $total=$_POST['total'];
    $query = mysqli_query($koneksi,"UPDATE pesanan SET status_pesanan='done' where id_pesanan=$id_pesanan;");
    $query = mysqli_query($koneksi,"INSERT INTO transaksi VALUES(NULL,$id_pesanan,$total,0,'','belum lunas',NULL)");

}
if(isset($_POST['batal']) && isset($_POST['id_pesanan']) && isset($_POST['status_pesanan'])){
    $id_pesanan=$_POST['id_pesanan'];
    $query = mysqli_query($koneksi,"DELETE FROM pesanan where id_pesanan=$id_pesanan;");
}

echo <<<_END
<center>
<table border=1 cellpadding=5 cellspacing=5>

<tr>
<td>Nomor</td>
<td>ID Pelanggan</td>
<td>Nama Pelanggan</td>
<td>Nomor Meja</td>
<td>ID Pesanan</td>
<td>Nama Menu</td>
<td>Jumlah</td>
<td>Waiter</td>
<td>Status_Pesanan</td>
<td>Action!</td>
</tr>

_END;
$nomor=0;

$query = mysqli_query($koneksi,"
SELECT 
`pelanggan`.`id_pelanggan`,
`pelanggan`.`nama_pelanggan`,
`pesanan`.`nomor_meja`,
`pesanan`.`id_pesanan`,
`menu`.`nama_menu`,
`menu`.`harga`,
`pesanan`.`id_menu`,
`pesanan`.`jumlah`,
`login`.`username`,
`pesanan`.`status_pesanan`
FROM `pesanan` 
NATURAL JOIN `pelanggan` 
NATURAL JOIN `login` 
NATURAL JOIN `menu` 
WHERE pesanan.status_pesanan = 'pending'
ORDER BY `pesanan`.`id_pesanan` ASC;");

while($data = mysqli_fetch_array($query)){
    $nomor++;
    $a=$data['id_pelanggan'];
    $z=$data['nama_pelanggan'];
    $b=$data['nomor_meja'];
    $c=$data['id_pesanan'];
    $d=$data['nama_menu'];
    $y=$data['id_menu'];
    $x=$data['harga'];
    $e=$data['jumlah'];
    $f=$data['username'];
    $g=$data['status_pesanan'];
    $total=$x * $e;


    if($g === "done"){
        echo "<tr style='background:green'>";
    }elseif($g === "batal"){
        echo "<tr style='background:red'>";
    }else{
        echo "<tr>";
    }
        
        
        echo <<<_END
            <td>$nomor</td>
            <td>$a</td>
            <td>$z</td>
            <td>$b</td>
            <td>$c</td>
            <td>$d</td>
            <td>$e</td>
            <td>$f</td>
            <td>$g</td>
            <td>        

_END;
if($g === 'done' || $g === 'batal'){
    echo "
     &nbsp;&nbsp;&emsp;- </td></tr>
    ";
}else{
    
    echo <<<_END
    <form action='waiter_ngantar_orderan.php' method=POST>
    <input type=hidden name='id_pesanan' value='$c'>
    <input type=hidden name='total' value='$total'>
    <input type=submit value=Done! name='done'>
    </form>

    <form action='waiter_ngantar_orderan.php' method=POST>
        <input type=hidden name='id_pesanan' value='$c'>
        <input type=hidden name='status_pesanan' value='$g'>
        <input type=submit value=Batal! name='batal'>
    </form>

    <form action='waiter_edit_orderan.php' method=POST>        
        <input type=hidden name='nama_pelanggan' value='$z'>
        <input type=hidden name='nomor_meja' value='$b'>
        <input type=hidden name='id_pesanan' value='$c'>
        <input type=hidden name='nama_menu' value='$d'>
        <input type=hidden name='jumlah' value='$e'>
        <input type=submit value=Edit!!! name='edit'>
    </form>

    </td>
    </tr>
_END;
}
}





?>
<script>
    setFetch('./waiter_ngantar_orderan.php',60000);
</script>
</body>
</html>
