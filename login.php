<?php
session_start();
include_once 'include/dbconnect2.php';

if(isset($_SESSION['user']))
{
 header("Location: index.php");
}
if(isset($_POST['login']))
{
 $username = mysqli_real_escape_string($db,$_POST['username']);
 $password = mysqli_real_escape_string($db,$_POST['password']);
 $res=$db->query("SELECT * FROM users WHERE username='$username'");
 #$res=mysql_query("SELECT * FROM users WHERE username='$username'");
 $row=mysqli_fetch_array($res);
 if($row['password']==md5($password))
 {
  $_SESSION['user'] = $row['username'];
  $login_status=$db->query("UPDATE users SET login_status=1,last_login=now() where username='$username'");
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
    	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

 <link href="css/styles.css" rel="stylesheet">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type-"test/javascript" src="js/jquery.validate.min.js"></script> 



<style type="text/css">
.error{
margin-top: 6px;
margin-bottom: 0;
display: table;
padding: 5px 8px;
font-size: 11px;
font-weight: 600;
line-height: 14px;
  }

</style> 
</head>
<body>
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
                                            <!-- <a class="btn btn-primary signup" name="login">Login</a>-->
                                            <input class="btn btn-primary signup" type="submit" value="Submit" name="login"/>
                                        </div>
                                    </div>
                                </div>
                        </form>

                                <div class="already">
                                    <p class="pull-center"><a href="#" data-toggle="modal" data-target=".resetpassword" data-dismiss="modal">Forgot Password? </a>
                                </div>

                            </div>
                        </div>
                </div>
        </div>

  <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

 <!-- Modal for Reset password Starts Here -->
<div class="modal fade resetpassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal_dialog">
    <div class="modal-content modal_content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">X</button>
      <h4 class="modal-title">Forgot Your password ?</h4>
    </div>
    <div class="modal-body">
      <form class="form-horizontal"  action="#" id="form_reset_pwd">
      <fieldset>
        <p>Enter your Username to reset your password.</p>
        <div class="form-group">
          <label class="col-sm-3 control-label">Username :</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="email" placeholder="Username"/>
          </div>
        </div>
        <div id="error_result"></div>
        <div class="form-group">
          <div class="col-md-7 col-md-offset-5">
            <button type="button" class="btn btn-primary forgot_password">Send Email</button>
          </div>
        </div>
      </fieldset>
      </form>
    </div>
    </div>
  </div>
</div>
<!-- Modal for Reset password Ends Here -->


</body>
</html>
<script
  $(document).ready(function(){
    $(document).on('click','.forgot_password',function(){
      var url = "reset/reset_password.php";
      if($('#form_reset_pwd').valid()){
        $('#error_result').html('<img src="images/ajax.gif" align="absmiddle"> Please wait...');
        $.ajax({
        type: "POST",
        url: url,
        data: $("#form_reset_pwd").serialize(), // serializes the form's elements.
          success: function(data) {
            if(data==1)
            {
              $('#error_result').html('Check your email');
            }
            else
            {
              $('#error_result').html('Invalid username. Please check your username spelling.');
            }
          }
        });
      }
      return false;
    });
});
</script>
