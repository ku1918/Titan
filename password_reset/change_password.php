<?php 
$db = new mysqli('localhost', 'root', 'mighty', 'mostlikers');
    if($_GET['user_id']!="" && $_GET['key']!=""):
        $user_id=mysqli_real_escape_string($db,$_GET['user_id']);
        $active_code=mysqli_real_escape_string($db,$_GET['key']);
        $fetch=$db->query("SELECT * FROM `users` WHERE id='$user_id' AND `active_code` = '$active_code'");
        $count=mysqli_num_rows($fetch);
        if($count!=1) :
          header("Location:index.php");
        endif;
    else :
        header("Location:index.php");
    endif;
?>

<html>
<head>
  <title>Forget Password Recevory in php </title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
   <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<style type="text/css">
.error{
margin-top: 6px;
margin-bottom: 0;
color: #fff;
background-color: #D65C4F;
display: table;
padding: 5px 8px;
font-size: 11px;
font-weight: 600;
line-height: 14px;
  }

</style>
</head>
<body>  
        <div class="modal-dialog">
        <h2>Forget Password Recevory in php</h2>
        
        <div class="modal-content col-md-8">
        <div class="modal-header">
        <h4 class="modal-title"><i class="icon-paragraph-justify2"></i> Change New Password</h4>
        </div>
        <form method="post" autocomplete="off" id="password_form">
          <div class="modal-body with-padding">                             
          <div class="form-group">
            <div class="row">
              <div class="col-sm-10">
                <label>New Password</label>
                <input type="password" id="passwords" name="password"  class="form-control required">
              </div>
            </div>
          </div>
          <div class="form-group">
          <div class="row">
            <div class="col-sm-10">
              <label>Confirm password</label>
              <input type="password" id="cpassword" name="cpassword" title="Password is mismatch" equalto="#passwords" class="form-control required" value="">
            </div>
          </div>
          </div>         
          </div>
          <div id="error_result"></div>
          <!-- end Add popup  -->  
          <div class="modal-footer">
            <input type="hidden" name="id" value="<?php echo $user_id; ?>" id="id">
            <button type="submit" id="btn-pwd" class="btn btn-primary">Submit</button>              
          </div>
        </form>          
        </div>        
        </div> 
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- demo ads -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:50px"
     data-ad-client="ca-pub-9665679251236729"
     data-ad-slot="6794107020"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>  
</body>
</html>
<script>  
  $(document).ready(function(){
    $(document).on('click','#btn-pwd',function(){
      var url = "new_password.php";       
      if($('#password_form').valid()){
        $('#error_result').html('<img src="ajax.gif" align="absmiddle"> Please wait...');  
        $.ajax({
        type: "POST",
        url: url,
        data: $("#password_form").serialize(),
          success: function(data) {                    
            if(data==1)
            {
              $('#error_result').html('Password reset successfully.');
              window.setTimeout(function() {
              window.location.href = 'index.php?sucess=1';
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
