<?php

include "../html/register_pelanggan.html";
require_once "../koneksi.php";
require_once "../header.php";
second_check($status_user,'kasir');

if(isset($_POST['username']) &&
 isset($_POST['noHP']) && 
 isset($_POST['jenis_kelamin']) && 
 isset($_POST['password']) && 
 isset($_POST['alamat'])){

    $username= fix_string(get_post($koneksi,'username'));
    $password= md5(fix_string(get_post($koneksi,'password')));

    if($stmt=mysqli_prepare($koneksi,"SELECT login.passwords FROM `login` WHERE login.username=? AND login.passwords=?")){
        mysqli_stmt_bind_param($stmt,'ss',$users,$password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) < 1){
            registration_failed();
        }else{
            $noHP= get_post($koneksi,'noHP');
            $jenis_kelamin= get_post($koneksi,'jenis_kelamin');
            $alamat= get_post($koneksi,'alamat');
            $null ='';
            $expiry = get_post($koneksi,'expiry');
            if($expiry === "6_month"){
                $expiry_date = date('Y-m-d', strtotime("+6 month"));
                $bayar = 3000000000;
                $id_bayar= 1;
            }elseif($expiry === "1_year"){
                $expiry_date = date('Y-m-d', strtotime("+1 year"));
                $bayar = 5500000000;
                $id_bayar= 2;
            }elseif($expiry === "2_year"){
                $expiry_date = date('Y-m-d', strtotime("+2 year"));
                $bayar = 1050000000;
                $id_bayar= 3;
            }elseif($expiry === "5_year"){
                $expiry_date = date('Y-m-d', strtotime("+5 year"));
                $bayar = 26000000000;
                $id_bayar= 4;
            }else{
                registration_failed();
            }
            

            if($query=mysqli_prepare($koneksi,"insert into pelanggan values(?,?,?,?,?,?)")){
                mysqli_stmt_bind_param($query,'isssss',$null,$username,$jenis_kelamin,$noHP,$alamat,$expiry_date);
                mysqli_stmt_execute($query);
                printf("%d Row inserted.\n", mysqli_stmt_affected_rows($query));
                $check_id_pelanggan=mysqli_query($koneksi,"select id_pelanggan from pelanggan where nama_pelanggan='$username'");
                while($data=mysqli_fetch_array($check_id_pelanggan)){
                    $id_pelanggan = $data['id_pelanggan'];
                    $query=mysqli_query($koneksi,"insert into pesanan values(NULL,$id_bayar,$id_pelanggan,1,'$id_users',0,'done')");
                    $check_id_pesanan=mysqli_query($koneksi,"select id_pesanan from pesanan where id_pelanggan=$id_pelanggan");
                    while($data=mysqli_fetch_array($check_id_pesanan)){
                        $id_pesanan=$data['id_pesanan'];
                        $query=mysqli_query($koneksi,"insert into transaksi values(NULL,$id_pesanan,$bayar,$bayar,'$users','lunas',NULL)");
                        if($query){
                            echo "
                            <script>
                                alert('Registrasi Berhasil!');
                                window.location='kasir.php';
                            </script>
                        ";
                        }else{
                            registration_failed();
                        }
                            
                    }
                    
                }
                
            }else{
                registration_failed();
            }
        }
    }

    
}
function registration_failed(){
    echo "
        <script>
            alert('Error! coba lagi yang lain');
            window.location='register_pelanggan.php';
        </script>
        ";
}

function get_post($koneksi,$var)
{
return $koneksi->real_escape_string($_POST[$var]);
}

function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}

?>