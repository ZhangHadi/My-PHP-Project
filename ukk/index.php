<?php

destroy_session_and_data();

include_once "./html/login.html";
require_once "koneksi.php";

delete_expired_pelanggan($koneksi);

if(isset($_POST['username'])&& isset($_POST['password'])){

    $username= get_post($koneksi,'username');
    $password= md5(get_post($koneksi,'password'));
    $status = '';
    $query="SELECT login.status,login.id_user FROM `login` WHERE login.username=? AND login.passwords=?";

    if($stmt=mysqli_prepare($koneksi,$query))
        mysqli_stmt_bind_param($stmt,'ss',$username,$password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $status, $id_user);    

        if(mysqli_stmt_error($stmt)){
            $err = mysqli_stmt_error($stmt);
            echo "<script>console.log('$err');</script>";
            login_failed();
        }else{
            if(mysqli_stmt_num_rows($stmt) > 0){
                while (mysqli_stmt_fetch($stmt)) {
                    login_success($username,$status,$id_user);
                }
            }else{
                    login_failed();
                }
            
        }


}

function get_post($koneksi,$var)
{
    return mysqli_real_escape_string($koneksi,$_POST[$var]);
}

function login_failed(){
    echo"<script>
        alert('Sepertinya Ada Kesalahan, Silahkan dicoba lagi ya!')
        window.location='index.php';
        </script>";
}

function login_success($username,$status,$id_user){
    session_start();
        setcookie($username,session_id(),null,'/',null,TRUE,TRUE);
        $_SESSION['username']=$username;
        $_SESSION['status']=$status;
        $_SESSION['id_user']=$id_user;
        echo"<script>
        alert('Welcome $status!!');
        window.location='home.php';
        </script>";
}

function destroy_session_and_data()
{
session_start();
$_SESSION = array();
header( "Set-Cookie: name=value; httpOnly" );
session_destroy();
}
function delete_expired_pelanggan($koneksi){
    date_default_timezone_set('Asia/Jakarta');
    $query=mysqli_query($koneksi,"SELECT * FROM pelanggan");
    while($data=mysqli_fetch_array($query)){
        $pelanggan_expiry = $data['expiry'];
        $id = $data['id_pelanggan'];
        $date1=date_create(date('Y-m-d'));
        $date2=date_create($pelanggan_expiry);
        $interval = date_diff($date1,$date2);
        $days = $interval->format('%R%a');
        if($days < -1 ){
            mysqli_query($koneksi,"DELETE FROM PELANGGAN WHERE id_pelanggan=$id");
        }

    }
    
}


?>