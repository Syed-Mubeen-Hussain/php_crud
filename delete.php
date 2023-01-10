<?php
include('connection.php');
$id = mysqli_real_escape_string($con,$_GET['id']);
$res = mysqli_query($con,"delete from Student where id = '$id'");
if($res){
    echo '<script>
        window.location.href = "view.php";
    </script>';
}
?>