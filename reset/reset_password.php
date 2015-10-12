<?php 

function randStrGen($len){
    $result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
            $randItem = array_rand($charArray);
            $result .= "".$charArray[$randItem];
    }
    return $result;
}

// Usage example

include_once'../include/dbconnect2.php';
#$db = new mysqli('localhost', 'root', 'mighty', 'app');
  if($_POST['email']!=""):
      $email=mysqli_real_escape_string($db,$_POST['email']);
      $db_check=$db->query("SELECT * FROM `users` WHERE username='$email'");
      $email_account=$db->query("SELECT phoneNumber FROM `users_profile` WHERE username='$email'");
      $phone=mysqli_fetch_array($email_account);
      $phone2=$phone['phoneNumber']; 
      $count=mysqli_num_rows($db_check);
      if($count==1) :
	$newPassword = randStrGen(6);
 $md5Password = md5(mysqli_real_escape_string($db,$newPassword));
             $updatePassword=$db->query("UPDATE `users` SET `password` = '$md5Password' WHERE username='$email'");

        // Textlocal account details
    #   $username = 'titan2boss@gmail.com';
        $apiKey = 'FriuSQw2cXg-oL6WngD4CVqiG4EFPaTlci0cGl2osW';

        // Message details
        $numbers = array("'6'.'$phone2'");
        $sender = urlencode('Titan Boss');
        $message = rawurlencode("Your Temporary Password : '$newPassword'");

            $numbers = implode(',', $numbers);

        // Prepare data for POST request
        #$data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
        $data = array('apiKey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('http://api.txtlocal.com/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
   #     echo $response;

    /*     $row=mysqli_fetch_array($db_check);
         $row2=mysqli_fetch_array($email_account);
         $active_code=md5(uniqid(rand(5, 15), true));
         $link = 'http://apptest.duckdns.org/changePassword.php?user_id='.$row['user_id'].'&key='.$active_code;         
         $fetch=$db->query("UPDATE `users` SET `active_code` = '$active_code' WHERE `username`='$email' ");
         $to=$row2['email']; //change to ur mail address
         $strSubject="TitanGame | Password Recovery Link";
         $message = '<p>Password Recovery Link : '.$link.'</p>' ;              
         $headers = 'MIME-Version: 1.0'."\r\n";
         $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
         $headers .= "From: titanbosswin@gmail.com";            
         $mail_sent=mail($to, $strSubject, $message, $headers);  
          if($mail_sent) echo 1;
          else echo 0;  
*/
	echo 1;
      else :
        echo 0;
      endif; 
  else :
      header("Location:index.php");
  endif;

?>
