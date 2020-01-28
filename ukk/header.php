<?php

session_start();
$users = $_SESSION['username'];
$id_users=$_SESSION['id_user'];
$status_user = $_SESSION['status'];

if($status_user=='kasir'){
  verified_successfully($status_user,'register_pelanggan.php','Register MemberShip?',
  'bayar.php','Ke Pembayaran?','kasir.php','Liat Liat Pembayaran?');
}elseif($status_user=='waiter'){
  verified_successfully($status_user,'waiter_ngantar_orderan.php','Antar Orderan?',
  'waiter_orderan.php','Mau Catat Orderan?','','');
    
}elseif($status_user=='owner'){
  verified_successfully($status_user,'owner.php','Liat List Menu?',
  'transaction_owner.php','Liat List Transaksi?','','');
    
}elseif($status_user=='admin'){
  verified_successfully($status_user,'admin.php','Liat Menu?',
  'make_menu.php','Insert Menu?','','');
    
}else{
    PENYUSUP();
}

function second_check($status_user,$status_asli){
  $status_user != $status_asli ? PENYUSUP() : true;
}
function verified_successfully($status_user,$php_1,$keterangan_php_1,
$php_2,$keterangan_php_2,$php_3,$keterangan_php_3){
  echo "
  <!DOCTYPE HTML>
  <html>
  <head>
  <title>$status_user</title>  
  <link rel='stylesheet' href='../style.css'>
  </head>
  <body>
  <div id='nav'>
  <a href=$php_1>$keterangan_php_1</a>
  <a href=$php_2>$keterangan_php_2</a>
";
if($php_3!='' && $keterangan_php_3!=''){
  echo"
  <a href=$php_3>$keterangan_php_3</a>
";
}
echo"
<a href='../'>Log Out</a>
</div>
<br />
<br /><br />
";
}
function PENYUSUP(){
  echo "
    <script>
    alert('NYASAR KANG?');
    window.location='../';
    </script>
    ";
}
?>
<script>
const setFetch = (location,time) => {
    setInterval(() => {
        console.log('refresh');
        window.location= location;
    },time)
}

</script>
