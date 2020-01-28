<?php

require_once '../koneksi.php';
require_once '../header.php';
second_check($status_user,'owner');
echo <<<_END

<table border=1 cellpadding=4 cellspacing=5>

<tr>
<td>Nomor</td>
<td>ID Transaksi</td>
<td>Nama Pelanggan</td>
<td>Nomor Meja</td>
<td>Nama Menu</td>
<td>Jumlah</td>
<td>Total</td>
<td>Bayar</td>
<td>Jam Bayar</td>
<td>Waiter</td>
<td>Kasir</td>
</tr>



_END;
$nomor=0;
$query = mysqli_query($koneksi,"SELECT 
`pelanggan`.`nama_pelanggan`,
`pesanan`.`nomor_meja`,
`pesanan`.`id_menu`,
`menu`.`nama_menu`,
`pesanan`.`jumlah`,
`login`.`username`,
`transaksi`.`total`,
`transaksi`.`bayar`,
`transaksi`.`jam_bayar`,
`transaksi`.`id_transaksi`,
`transaksi`.`petugas`
FROM `transaksi` 
NATURAL JOIN `pelanggan` 
NATURAL JOIN `login` 
NATURAL JOIN `menu`
NATURAL JOIN `pesanan`  
ORDER BY `transaksi`.`id_transaksi` ASC;");

while($data = mysqli_fetch_array($query)){
    $nomor++;
    $a=$data['id_transaksi'];
    $b=$data['nama_pelanggan'];
    $c=$data['nomor_meja'];
    $e=$data['nama_menu'];
    $f=$data['jumlah'];
    $g=$data['username'];
    $i=$data['total'];
    $j=$data['bayar'];
    $l=$data['petugas'];
    $k=$data['jam_bayar'];

    echo <<<_END

        <tr>
        <td>$nomor</td>
        <td>$a</td>
        <td>$b</td>
        <td>$c</td>
        <td>$e</td>
        <td>$f</td>
        <td>Rp $i</td>
        <td>Rp $j</td>
        <td>$k</td>
        <td>$g</td>
        <td>$l</td>
        </tr>

_END;
}


?>
