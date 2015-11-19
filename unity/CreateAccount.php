<?php
//Email and Password
$Email = $_POST['user'];
$Password = $_POST['password'];
#$Email =  'test3';
#$Password = 'test3';
#$Email = mysqli_real_escape_string($db,$_POST['user']);
#$Password = md5(mysqli_real_escape_string($db,$_POST['password']));



include_once '../include/dbconnect3.php';


//PHP Only


#mysql_connect($Hostname,$User ,$PasswordP) or die ("Can't connect to DB");
#mysql_select_db($DBName) or die ("Can't Connect to DB");

if (!$Email || !$Password){
	echo "Empty";
	
}else{	
	#$SQL =  "select * From accounts WHERE Email = '" . $Email ."'";
	$createAccountSQL = $db->query("Select * from accounts where email = '" . $Email . "'"); 
	#$Result = mysql_query($SQL);
	#$Total = mysqli_num_rows($createAccountSQL);
	$row = mysqli_num_rows($createAccountSQL);
	if($row == 0 ){
		#$createAccountSQL2 = $db->query("INSERT INTO 'accounts' ('Email','Password','Characters') values ('" . $Email . "',MD5('" . $Password . "'),0)");
		$createAccountSQL2 = $db->query("INSERT INTO `accounts`(`Email`, `Password`, `Characters`) values ('$Email','$Password',0)");
		#$SQL1 = mysql_query($insert);
		echo "Success";
	}else{
		echo "Already Used";
		
	}
}

?>
