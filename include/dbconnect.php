<?php
if(!mysql_connect("localhost","root","mighty"))
{
	die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("app"))
{
	die('oops database selection problem ! --> '.mysql_error());
}

?>
