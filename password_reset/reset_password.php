<?php 
  $db = new mysqli('localhost', 'root', 'mighty', 'mostlikers');
  if($_POST['email']!=""):
      $email=mysqli_real_escape_string($db,$_POST['email']);
      $db_check=$db->query("SELECT * FROM `users` WHERE email='$email'");
      $count=mysqli_num_rows($db_check);
      if($count==1) :
         $row=mysqli_fetch_array($db_check);
         $active_code=md5(uniqid(rand(5, 15), true));
         $link = 'http://apptest.duckdns.org/password_reset/change_password.php?user_id='.$row['id'].'&key='.$active_code;         
         $fetch=$db->query("UPDATE `users` SET `active_code` = '$active_code' WHERE `email`='$email' ");
         $to="$email"; //change to ur mail address
         $strSubject="Mostlikers | Password Recovery Link";
         $message = '<p>Password Recovery Link : '.$link.'</p>' ;              
         $headers = 'MIME-Version: 1.0'."\r\n";
         $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
         $headers .= "From: titanbosswin@gmail.com";            
         $mail_sent=mail($to, $strSubject, $message, $headers);  
          if($mail_sent) echo 1;
          else echo 0;  
      else :
        echo 0;
      endif;
  else :
      header("Location:index.php");
  endif;
?>
