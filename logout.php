<?php
include_once 'include/dbconnect2.php';
session_start();

$res=$db->query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
$username=$userRow['username'];


if(!isset($_SESSION['user']))
{
	header("Location: login.php");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: index.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
        $login_status=$db->query("UPDATE users SET login_status=0 where username='$username'");
	unset($_SESSION['user']);
	header("Location: login.php");
}
?>
