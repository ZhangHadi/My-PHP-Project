<?php

session_start();
$user=$_SESSION['username'];
$status=$_SESSION['status'];
if($user){
    if($status === "kasir"){
        echo "
        <script>
            window.location='./kasir/kasir.php';
        </script>
        ";
    }elseif($status === "owner"){
        echo "
        <script>
            window.location='./owner/owner.php';
        </script>
        ";
    }elseif($status === "waiter"){
        echo "
        <script>
            window.location='./waiter/waiter_orderan.php';
        </script>
        ";
    }elseif($status === "admin"){
        echo "
        <script>
            window.location='./admin/admin.php';
        </script>
        ";
    }else{
        echo<<<_END
        <script>
        window.location='index.html';
        
        </script>
_END;
    session_destroy();
        }
}
    
?>