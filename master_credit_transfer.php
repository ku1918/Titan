<?php
session_start();
include_once 'include/dbconnect2.php';

if(!isset($_SESSION['user'])){
        header ("Location: login.php");
}

$res=$db->query("select * from users where username='".$_SESSION['user']."'");
$userRow=mysqli_fetch_array($res);
$username=$userRow['username'];
$userCategory=$userRow['category'];

$getCredit=$db->query("select username,credit from ((select * from player_credit) union (select * from cashier_credit) union (select * from master_credit)) as a where a.username='$username'");
$creditBalance=mysqli_fetch_array($getCredit);
$sourceCredit=$creditBalance['credit'];

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
        <script>alert('Insufficient Amount');</script>
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
        <script>alert('Topup success');</script>
        <?php
}
 else
 {
  ?>
        <script>alert('Topup Fail');</script>
        <?php
 }
}
}
}
else{
?>
	<script>alert('Invalid User');</script>
        <?php
}
}
elseif(isset($_POST['withdraw'])){

$totalAmount = $getTargetCreditFloat-$amount;
$transferAmount = $getSourceCreditFloat+$amount;


if($userRowCount > 0){
if($amount > $getTargetCreditFloat ){
?>
        <script>alert('Withdraw Amount Exceed');</script>
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
        <script>alert('Withdraw success');</script>
        <?php
}
 else
 {
  ?>
        <script>alert('Withdraw Fail');</script>
        <?php
 }
}
}
}
else{
?>
	<script>alert('Invalid User');</script>
        <?php
}
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta name="generator"
    content="HTML Tidy for HTML5 (experimental) for Windows https://github.com/w3c/tidy-html5/tree/c63cc39" />
    <title>App Testing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen" />
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
      <script type="text/javascript" language="javascript" >
                        $(document).ready(function() {
                                var dataTable = $('#master-credit').DataTable( {
                                        "processing": true,
                                        "serverSide": true,
                                        "ajax":{
                                                url :"master-credit-data.php", // json datasource
                                                type: "post",  // method  , by default get
                                                error: function(){  // error handling
                                                        $(".master-credit-error").html("");
                                                        $("#master-credit").append('<tbody class="player-credit-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                                        $("#master-credit_processing").css("display","none");

                                                }
                                        }
                                } );
                        } );
                </script>
  </head>
  <body>
  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <!-- Logo -->
          <div class="logo">
            <h1>
              <a href="index.php">Admin Test Portal</a>
            </h1>
          </div>
        </div>
        <div class="col-md-5">
          <div class="row">
            <div class="col-lg-12"></div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="navbar navbar-inverse" role="banner">
            <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<b class="caret"></b></a>
                  <ul class="dropdown-menu animated fadeInUp">
                    <li>
                        <?php echo $username ?>
                    </li>
	                <?php if ($userCategory == 0){ ?>
                                <li>Credit : Infinite </li>
                                <?php } else{ ?>
                                <li>Credit : RM <?php echo $sourceCredit ?></li>
                                <?php } ?>

                    <li>
                      <a href="logout.php?logout">Logout</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-content">
    <div class="row">
      <div class="col-md-2">
        <div class="sidebar content-box" style="display: block;">
	 <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
			 <?php
                      if($userCategory == 0){
                ?>
                    <li><a href="reports.php"><i class="glyphicon glyphicon-list"></i> Reports</a></li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Credit Transfer
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="master_credit_transfer.php">Master</a></li>
                            <li><a href="cashier_credit_transfer.php">Cashier</a></li>
                            <li><a href="player_credit_transfer.php">Player</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Extra
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="signup_internal.php">Signup New User</a></li>
                        </ul>
                    </li>
                <?php
                        }
                        elseif($userCategory == 1){
                        ?>
                         <li><a href="reports.php"><i class="glyphicon glyphicon-list"></i> Reports</a></li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Credit Transfer
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="cashier_credit_transfer.php">Cashier</a></li>
                            <li><a href="player_credit_transfer.php">Player</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Extra
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="signup_internal.php">Signup New User</a></li>
                        </ul>
                    </li>
                <?php
                }
                elseif($userCategory == 2){
 ?>
                 <li><a href="reports.php"><i class="glyphicon glyphicon-list"></i> Reports</a></li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Credit Transfer
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="player_credit_transfer.php">Player</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Extra
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="signup_internal.php">Signup New User</a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>


	</ul>
        </div>
      </div>
      <div class="col-md-10">
        <div class="content-box-large">
          <div class="panel-heading">
            <div class="panel-title">Player List</div>
          </div>
          <div class="panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="master-credit">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Credit</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
		<div class="row">
		      <div class="col-md-5">
        <div class="content-box-large">
          <div class="panel-heading">
            <div class="panel-title">Top Up/Withdraw</div>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form" method="post">
              <div class="form-group">
                <label for="Username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Username" required="" id="target_username" name="target_username" />
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-2" for="prepend">Credit</label>
                <div class="col-md-10">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="input-group">
                      <span class="input-group-addon">RM</span> 
                      <input class="form-control" name="amount" id="amount" required="" placeholder="Amount" type="number" /></div>
                    </div>
                  </div>
                </div>
              </div>
		<div class="form-group">
                                                                    <div class="col-sm-offset-2 col-sm-10">
                                                                        <input class="btn btn-primary" type="submit" value="Top Up" id="topup" name="topup" >
                                                                        <input class="btn btn-primary" type="submit" value="Withdraw" name="withdraw" id="withdraw">

                                                                    </div>
                                                                  </div>

            </form>
          </div>
        </div>
      </div>
      </div>
	  </div>
     

    </div>
  </div>

  <footer>
    <div class="container">
      <div class="copy text-center">Property of Seremban 
      <a href='#'>Website</a></div>
    </div>
  </footer>
  <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen" />
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <!-- jQuery UI -->
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
  <!-- Include all compiled plugins (below), or include individual files as needed -->
   
  <script src="bootstrap/js/bootstrap.min.js"></script> 
  <script src="vendors/datatables/js/jquery.dataTables.min.js"></script> 
  <script src="vendors/datatables/dataTables.bootstrap.js"></script> 
  <script src="js/custom.js"></script> 
  <script src="js/tables.js"></script></body>
</html>
