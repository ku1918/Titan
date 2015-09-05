<?php
session_start();
include_once 'include/dbconnect.php';

if(isset($_SESSION['user'])!="")
{
 header("Location: index.php");
}
if(isset($_POST['login']))
{
 $username = mysql_real_escape_string($_POST['username']);
 $password = mysql_real_escape_string($_POST['password']);
 $res=mysql_query("SELECT * FROM users WHERE username='$username'");
 $row=mysql_fetch_array($res);
 if($row['password']==md5($password))
 {
  $_SESSION['user'] = $row['user_id'];
  header("Location: index.php");
 }
 else
 {
  ?>
        <script>alert('wrong details');</script>
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
			                <h6>Sign In</h6>
				    <div class="social">
	                        </div>
				<form method="post">
			                <input class="form-control" type="text" required="" id="username" name="username" placeholder="Username">


			                <input class="form-control" type="password" required="" name="password" placeholder="Password">
			                <div class="action">
			                    <!--<a class="btn btn-primary signup" name="login">Login</a>-->
			                    <input class="btn btn-primary signup" type="submit" value="Submit" name="login"/>
			                </div>                
			            </div>
			        </div>
			</form>

			        <div class="already">
			            <p>Don't have an account yet?</p>
			            <a href="signup.php">Sign Up</a>
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
