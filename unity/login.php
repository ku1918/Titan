<?PHP


include_once '../include/dbconnect2.php';

$PostUser = $_POST['user'];
$PostPassword = $_POST['password'];
#$Email =  'test3';
#$Password = 'test3';
#$Email = mysqli_real_escape_string($db,$_POST['user']);
#$Password = md5(mysqli_real_escape_string($db,$_POST['password']));

if (!$PostUser || !$PostPassword){
        echo "Login Empty";
}
else{

 #$username = mysqli_real_escape_string($db,$PostUser);
 #$password = mysqli_real_escape_string($db,$PostPassword);
 $res=$db->query("SELECT * FROM users WHERE username='$PostUser'");
 #$res=mysql_query("SELECT * FROM users WHERE username='$username'");
 $row=mysqli_fetch_array($res);
 if($row['password']==md5($PostPassword))
 {
  $login_status=$db->query("UPDATE users SET login_status=1,last_login=now() where username='$PostUser'");
  die("login-SUCCESS");
 }
}


#$con = mysql_connect("127.0.0.1","root","mighty") or ("Cannot connect!"  . mysql_error());
#if (!$con)
#	die('Could not connect: ' . mysql_error());
#	
#mysql_select_db("Accounts" , $con) or die ("could not load the database" . mysql_error());
#
#$check = mysql_query("SELECT * FROM accounts WHERE `Email`='".$Email."'");
#$numrows = mysql_num_rows($check);
#if ($numrows == 0)
#{
#	die ("Username does not exist \n");
#}
#else
#{
#	#$pass = md5($pass);
#	while($row = mysql_fetch_assoc($check))
#	{
#		if ($pass == $row['pass'])
#			die("login-SUCCESS");
#		else
#			die("Password does not match \n");
#	}
#}

?>
