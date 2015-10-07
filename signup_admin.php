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



if(isset($_POST['submit']))
{
 $username = mysqli_real_escape_string($db,$_POST['username']);
 $fullname = mysqli_real_escape_string($db,$_POST['fullname']);
 $email = mysqli_real_escape_string($db,$_POST['email']);
 $phoneNumber = mysqli_real_escape_string($db,$_POST['phoneNumber']);
 #$category = mysqli_real_escape_string($db,$_POST['category']);
 $password = md5(mysqli_real_escape_string($db,$_POST['password']));


$insert = "INSERT INTO users(username,category,password) VALUES('$username',0,'$password');";
$insert .= "INSERT INTO users_profile(username,fullname,email,phoneNumber) VALUES('$username','$fullname','$email','$phoneNumber');";

if($category == 1){
$insert .= "INSERT INTO master_credit(username) VALUES('$username')";
}
elseif ($category == 2){
$insert .= "INSERT INTO cashier_credit(username) VALUES('$username')";
}
elseif ($category == 3){
$insert .= "INSERT INTO player_credit(username) VALUES('$username')";
}


if($db->multi_query($insert) === TRUE)
 {

  ?>
        <?php
        header('Location: registerSuccess.html');
}
 else
 {
  ?>
        <script>alert('error while registering you...');</script>
        <?php
 }
}
?>


<!DOCTYPE html>
<html>
  <head>
    <title>App Testing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="vendors/select/bootstrap-select.min.css" rel="stylesheet">
    <link href="vendors/tags/css/bootstrap-tags.css" rel="stylesheet">

    <link href="css/forms.css" rel="stylesheet">

    <!--CheckUsername-->
	
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script>
$(document).ready(function(){
$('#username').keyup(username_check);
});

function username_check(){
var username = $('#username').val();
if(username == ""){
$('#username').css('border', '3px #CCC solid');
}else{

jQuery.ajax({
   type: "POST",
   url: "check/check.php",
   data: 'username='+ username,
   cache: false,
   success: function(response){
if(response == 1){
        $('#username').css('border', '3px #C33 solid');
        $('#inform').text("The username has been taken.Please use another.");
        }else{
        $('#username').css('border', '3px #090 solid');
        $('#inform').text("The username is avalable");
             }

}
});
}

}
</script>




    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="index.php">Admin Test Portal</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              <div class="row">
	                <div class="col-lg-12">
	                </div>
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
				                                <li><?php echo $username ?></li>
                                <li>Credit : RM <?php echo $sourceCredit ?></li>
                                  <li><a href="logout.php?logout">Logout</a></li>

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

	  			<div class="row">
					<div class="col-md-6">
	  					<div class="content-box-large">
			  				<div class="panel-heading">
					            <div class="panel-title">Sign up Form</div>
					        </div>
			  				<div class="panel-body">
			  					<form class="form-horizontal" role="form" method="post">
								  <div class="form-group">
								    <label for="Username" class="col-sm-2 control-label">Username</label>
								    <div class="col-sm-10">
								 <input type="text" class="form-control" placeholder="Username" required="" id="username" name="username" >

								    </div>
								  </div>
								  <div class="form-group">
								    <label for="Full Name" class="col-sm-2 control-label">Full Name</label>
								    <div class="col-sm-10">
									 <input type="text" class="form-control" placeholder="Full Name" required="" id="fullname" name="fullname"/>

								    </div>
								  </div>
								  <div class="form-group">
								    <label class="col-sm-2 control-label">Email Address</label>
								    <div class="col-sm-10">
									<input type="email" class="form-control" placeholder="Email Address" id="email" name="email" />
								    </div>
								  </div>
								  <div class="form-group">
								    <label class="col-sm-2 control-label">Telephone number</label>
								    <div class="col-sm-10">
									 <input type="tel" class="form-control" placeholder="Phone Number" data-mask="(999) 999-9999"  required="" id="phoneNumber" name="phoneNumber" />
								    </div>
								  </div>
								  <div class="form-group">
								 <label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
								 <input type="password" title="Password must contain at least 6 character" pattern=".{6,}" class="form-control" placeholder="Password" required="" id="password" name="password" onchange="form.confirmPassword.pattern = this.value;" />
								    </div>
								  </div>
								  <div class="form-group">
								 <label class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
								
								<input type="password" title="Please enter the same Password as above" class="form-control" placeholder="Confirm Password" pattern=".{6,}" required="" id="confirmPassword" />
								    </div>
								  </div>
								<div class="form-group">
									 <label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-10">
								 <select class="form-control input-sm" name="category" required="" >
                              	  				
								<?php 
								if ($userCategory == 0){
								?>
								<option value="0" selected >Superadmin</option>
								<?php
								}
								elseif ($userCategory == 1){
							        ?>	
                                                                <option value="2">Cashier</option>
                                                                <option value="3">Player</option>
								<?php
								}
								elseif ($userCategory == 2){
								?>
                                                                <option value="3">Player</option>
								<?php
								}
								?>
								
                					        </select> 
							                <div id="inform"></div>
								</div>
								</div>

								  <div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">
									<input class="btn btn-primary signup" type="submit" value="Sign Up" name="submit" >
									<input class="btn btn-primary signup" type="reset" value="Reset" name="Reset" >

								    </div>
								  </div>
								</form>
			  			</div>
	  				</div>
	  			</div>

														


	  		<!--  Page content -->
    	</div>
    	</div>
    </div>

    <footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>
            
         </div>
      </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>

    <script src="vendors/select/bootstrap-select.min.js"></script>

    <script src="vendors/tags/js/bootstrap-tags.min.js"></script>

    <script src="vendors/mask/jquery.maskedinput.min.js"></script>

    <script src="vendors/moment/moment.min.js"></script>

    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

     <!-- bootstrap-datetimepicker -->
     <link href="vendors/bootstrap-datetimepicker/datetimepicker.css" rel="stylesheet">
     <script src="vendors/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script> 


    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/forms.js"></script>
  </body>
</html>
