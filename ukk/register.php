<?php

include "./html/register.html";

require_once "koneksi.php";
if ($koneksi->connect_error) die($koneksi->connect_error);



if(isset($_POST['username']) && isset($_POST['password'])){
    $username= fix_string(get_post($koneksi,'username'));
    $password= fix_string(md5(get_post($koneksi,'password')));
    $status= "user";
    $null ='';
    
    


    if($query=mysqli_prepare($koneksi,"insert into login values(?,?,?,?)")){
        mysqli_stmt_bind_param($query,'isss',$null,$username,$password,$status);
        mysqli_stmt_execute($query);
        printf("%d Row inserted.\n", mysqli_stmt_affected_rows($query));
        echo "
        <script>
            alert('Registrasi Berhasil!');
            window.location='index.php';
        </script>
        ";
    }else{
        echo "
        <script>
            alert('Error! coba lagi yang lain');
            window.location='register.php';
        </script>
        ";
    }
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