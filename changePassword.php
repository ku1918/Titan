<?php
include_once 'include/dbconnect2.php';
    if($_GET['user_id']!="" && $_GET['key']!=""):
        $user_id=mysqli_real_escape_string($db,$_GET['user_id']);
        $active_code=mysqli_real_escape_string($db,$_GET['key']);
        $fetch=$db->query("SELECT * FROM `users` WHERE user_id='$user_id' AND `active_code` = '$active_code'");
        $count=mysqli_num_rows($fetch);
        if($count!=1) :
          header("Location:login.php");
        endif;
    else :
        header("Location:login.php");
    endif;
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
                                        <h6>Forget Password</h6>
                                    <div class="social">
                                </div>
                                <form method="post" id="password_form">
                                        <input class="form-control" title="Password must contain at least 6 character" pattern=".{6,}" type="password" required="" id="password" name="password" placeholder="Password">


                                        <input class="form-control" type="password" title="Please enter the same Password as above" required="" id="cPassword" name="cPassword" placeholder="Confirm Password" equalto="#password"> 
                                        <div class="action">
                                            <!-- <a class="btn btn-primary signup" name="login">Login</a>-->
				            <input type="hidden" name="id" value="<?php echo $user_id; ?>" id="id">
                                            <input class="btn btn-primary signup" type="submit" id="btn-pwd" value="Reset" name="forgetPassword"/>
					          <div id="error_result"></div>


                                        </div>
                                    </div>
                                </div>
                        </form>

                            </div>
                        </div>
                </div>
        </div>

  <!--<script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script> -->


</body>
</html>

</script>
</body>
</html>
<script>
  $(document).ready(function(){
    $(document).on('click','#btn-pwd',function(){
      var url = "reset/new_password.php";
      if($('#password_form').valid()){
        $('#error_result').html('<img src="reset/ajax.gif" align="absmiddle"> Please wait...');
        $.ajax({
        type: "POST",
        url: url,
        data: $("#password_form").serialize(),
          success: function(data) {
            if(data==1)
            {
              $('#error_result').html('Password reset successfully.');
              window.setTimeout(function() {
              window.location.href = 'login.php?sucess=1';
              }, 1000);
            }
            else
            {
              $('#error_result').html('Password reset failed. Enter again.');
            }
          }
        });
      }
      return false;
    });
});
</script>
             
