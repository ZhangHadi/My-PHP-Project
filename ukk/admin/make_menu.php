<?php

require_once "../koneksi.php";
require_once "../header.php";
include "../html/make_menu.html";

second_check($status_user,'admin');

if($koneksi->connect_error) die($koneksi->connect_error);

if(isset($_POST['nama_menu']) && isset($_POST['harga']) && isset($_FILES['photo']) ){

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Check if file was uploaded without errors
        if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
            $allowed  = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["photo"]["name"];
            $filetype = $_FILES["photo"]["type"];
            $filesize = $_FILES["photo"]["size"];
            $phpfile  = explode(".",$_FILES["photo"]["name"]);
            $d		  = $phpfile[0];
            
            $locate   ="../Picture/" . $filename;
            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
        
            // Verify file size - 5MB maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
        
            // Verify MYME type of the file
            if(in_array($filetype, $allowed)){
                // Check whether file exists before uploading it
                if(file_exists("../Picture/" . $filename)){
                    echo $filename . " is already exists.";
                } else{
                    move_uploaded_file($_FILES["photo"]["tmp_name"], $locate);
                    echo "Your file was uploaded successfully.";                    
                    $a=$_POST['nama_menu'];
                    $b=$_POST['harga'];
                    $nomor='';
                    $query=mysqli_prepare($koneksi,"insert into menu values(?,?,?,?)");
                    mysqli_stmt_bind_param($query,'isss',$nomor,$a,$b,$filename);
                    mysqli_stmt_execute($query);
                    printf("%d Row inserted.\n", mysqli_stmt_affected_rows($query));
                    echo"<script>alert('Your file was uploaded successfully \\n Uploaded $a Into Database')</script>";
                    mysqli_stmt_close($query);
                    mysqli_close($koneksi);
                    echo"<script>window.location='admin.php'</script>";
                };          
                } 
            } else{
                echo "Error: There was a problem uploading your file. Please try again."; 
            }
        } else{
            echo "Error: " . $_FILES["photo"]["error"];
        }
}

?>