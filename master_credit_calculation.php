<?php
session_start();
include_once 'include/dbconnect2.php';

  $targetUser=$_POST['target_username'];
  $amount=$_POST['amount'];

  $checkUser=$db->query("SELECT username FROM master_credit WHERE username='$targetUser'");
  $userRowCount=mysqli_num_rows($checkUser);

  $getTargetCreditSQL = $db->query("SELECT credit FROM master_credit WHERE username='$targetUser'");
  $getTargetCreditArray=mysqli_fetch_array($getTargetCreditSQL);
  $getTargetCreditArray2=$getTargetCreditArray['credit'];
  $getTargetCreditFloat=floatval($getTargetCreditArray2);

  $getSourceCreditFloat=floatval($sourceCredit);

if(isset($_POST['topup'])){
$totalAmount = $getTargetCreditFloat+$amount;
$transferAmount = $getSourceCreditFloat-$amount;

if($userRowCount > 0){

if($amount > $getSourceCreditFloat && $userCategory != 0){
?>
        <script>alert('Insufficient Amount');
	window.location='master_credit_transfer.php';
	</script>
        <?php
}
else{
$updateTarget = "UPDATE master_credit SET credit='$totalAmount' where username='$targetUser';";
if(mysqli_query($db,$updateTarget) === TRUE)
{
if(mysqli_affected_rows($db)>0){

if($userCategory == 1){
$updateSource = "UPDATE master_credit SET credit='$transferAmount' where username='$username'";
}
elseif($userCategory == 2){
$updateSource = "UPDATE cashier_credit SET credit='$transferAmount' where username='$username'";
}

$transfer=$db->query($updateSource);
$message = mysqli_real_escape_string($db,"$username,$targetUser,$amount,-,$getTargetCreditFloat,$totalAmount");
$logsql = "INSERT into transaction_log (date,transaction) values ( now(),'$message')";
$logging=$db->query($logsql) or trigger_error($db->error."[$logsql]");
  ?>
        <script>
	alert('Topup Success');
	window.location='master_credit_transfer.php';
	</script> 
        <?php
}
 else
 {
  ?>
        <script>alert('Topup Fail');
	window.location='master_credit_transfer.php';
	</script>
        <?php
}
}
}
}
{
?>
        <script>alert('Invalid User');
	window.location='master_credit_transfer.php';
	</script>
        <?php

}
}
elseif(isset($_POST['withdraw'])){

$totalAmount = $getTargetCreditFloat-$amount;
$transferAmount = $getSourceCreditFloat+$amount;


if($userRowCount > 0){
if($amount > $getTargetCreditFloat ){
?>
        <script>alert('Withdraw Amount Exceed');
	window.location='master_credit_transfer.php';
	</script>
        <?php
}
else{
$updateTarget = "UPDATE master_credit SET credit='$totalAmount' where username='$targetUser';";

if(mysqli_query($db,$updateTarget) === TRUE)
{
if(mysqli_affected_rows($db) > 0){
if($userCategory == 1){
$updateSource = "UPDATE master_credit SET credit='$transferAmount' where username='$username'";
}
elseif($userCategory == 2){
$updateSource = "UPDATE cashier_credit SET credit='$transferAmount' where username='$username'";
}
$transfer=$db->query($updateSource);
  ?>
        <script>alert('Withdraw success');
	window.location='master_credit_transfer.php';
	</script>
        <?php
}
 else
 {
  ?>
        <script>alert('Withdraw Fail');
	window.location='master_credit_transfer.php';
	</script>
        <?php
 }
}
}
}
else{
?>
        <script>alert('Invalid User');
	window.location='master_credit_transfer.php';
	</script>
        <?php
}
}
?>

