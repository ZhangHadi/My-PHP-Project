<?php

require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'owner');

echo <<<_END

<table border=1 cellpadding=10>

<tr>
<td>Nomor</td>
<td>ID Menu</td>
<td>Nama Menu</td>
<td>Harga</td>
</tr>



_END;
$nomor=0;
$query = mysqli_query($koneksi,"select * from menu;");
while($data = mysqli_fetch_array($query)){
    $nomor++;
    $a=$data['id_menu'];
    $b=$data['nama_menu'];
    $c=$data['harga'];

    echo <<<_END

        <tr>
            <td>$nomor</td>
            <td>$a</td>
            <td>$b</td>
            <td>$c</td>
        </tr>

_END;
}


?>
