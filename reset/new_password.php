<?php 
include_once '../include/dbconnect2.php';
if($_POST['password']!=""):
    $pass_encrypt=md5(mysqli_real_escape_string($db,$_POST['password']));
    $user_id=mysqli_real_escape_string($db,$_POST['id']);
    $fetch=$db->query("UPDATE `users` SET `password` = '$pass_encrypt',`active_code`='' WHERE user_id='$user_id'");
    if($fetch): echo 1;  
    else : echo 0;
    endif;
else :
    header("Location:index.php");
endif;
?>
