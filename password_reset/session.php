<?php 
$db = new mysqli('localhost', 'root', '', 'mostlikers');
session_start();
$check=$_SESSION['login_username'];
if(!isset($check))
{
    header("Location:index.php");
} 
?>