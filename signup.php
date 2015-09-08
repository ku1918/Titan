<?php
session_start();
include_once 'include/dbconnect2.php';

if(isset($_POST['submit']))
{
 $username = mysqli_real_escape_string($db,$_POST['username']);
 $fullname = mysqli_real_escape_string($db,$_POST['fullname']);
 $email = mysqli_real_escape_string($db,$_POST['email']);
 $phoneNumber = mysqli_real_escape_string($db,$_POST['phoneNumber']);
 #$category = mysqli_real_escape_string($db,$_POST['category']);
 $password = md5(mysqli_real_escape_string($db,$_POST['password']));


$insert = "INSERT INTO users(username,category,password) VALUES('$username',3,'$password');";
$insert .= "INSERT INTO users_profile(username,fullname,email,phoneNumber) VALUES('$username','$fullname','$email','$phoneNumber');";
$insert .= "INSERT INTO player_credit(username) VALUES('$username')";

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
<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- styles -->
<link href="css/styles.css" rel="stylesheet">

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
<body class="login-bg">
<div class="header">
     <div class="container">
	<div class="row">
	   <div class="col-md-12">
	      <!-- Logo -->
	      <div class="logo">
		 <h1><a href="login.php">Admin Test Portal</a></h1>
	      </div>
	   </div>
	</div>
     </div>
</div>

<div class="page-content container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="login-wrapper">
			<div class="box">
			    <div class="content-wrap">
				<h6>Sign Up</h6>
		<form method="post">
		<div>
			<input type="text" class="form-control" placeholder="Username" required="" id="username" name="username" >
<!--<img id="tick" src="check/tick.png" width="16" height="16"/>
<img id="cross" src="check/cross.png" width="16" height="16"/> -->
		</div>

		<div>
			<input type="text" class="form-control" placeholder="Full Name" required="" id="fullname" name="fullname"/>
		</div>
		<div>
			<input type="email" class="form-control" placeholder="Email Address" id="email" name="email" />
		</div>
		<div>
			<input type="tel" pattern='\d{10}' class="form-control" placeholder="Phone Number (0121234567)" required="" id="phoneNumber" name="phoneNumber" />
		</div>
		<div>
			<input type="password" title="Password must contain at least 6 character" pattern=".{6,}" class="form-control" placeholder="Password" required="" id="password" name="password" onchange="form.confirmPassword.pattern = this.value;" /> 
		</div>
			<input type="password" title="Please enter the same Password as above" class="form-control" placeholder="Confirm Password" pattern=".{6,}" required="" id="confirmPassword" />
		</div> 
<!--		<div>
			<select name="category" required="" >
				<option value="Category" disabled selected>Select Category</option>
				<option value="0">Superadmin</option>
				<option value="1">Master</option>
				<option value="2">Cashier</option>
				<option value="3">Player</option>
			</select>
		</div> -->
		<div id="inform"></div>
			<!--        <input class="form-control" type="text" placeholder="E-mail address">
				<input class="form-control" type="password" placeholder="Password">
				<input class="form-control" type="password" placeholder="Confirm Password"> -->
				<div class="action">
				    <input class="btn btn-primary signup" type="submit" value="Sign Up" name="submit" >
				</div>                
		</form>
			    </div>
			<div class="already">
			    <p>Have an account already?</p>
			    <a href="login.php">Login</a>
			        </div>
			</div>
			    </div>
			</div>
		</div>
	</div>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
