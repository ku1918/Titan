<html>
<head>
  <title>Forget password recovery using Ajax, php and mysqli | Mostlikers </title>
  <link href='http://www.mostlikers.com/favicon.ico' rel='icon' type='image/x-icon'/>
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

</style> -->
</head>
<body>
      <div class="modal-dialog">

                <div class="form-group">
                     <p class="pull-right"><a href="#" data-toggle="modal" data-target=".resetpassword" data-dismiss="modal">
                        Forgot Password? </a>
                     </p>
                  </div>
                  </div>
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
        <p>Enter your Email Address here to receive a linkdd to change password.</p>
        <div class="form-group">
          <label class="col-sm-3 control-label">Email :</label>
          <div class="col-sm-9">
            <input type="text" class="form-control required email" name="email" placeholder="Email"/>
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
<script>
  $(document).ready(function(){
    $(document).on('click','.forgot_password',function(){
      var url = "reset_password.php";
      if($('#form_reset_pwd').valid()){
        $('#error_result').html('<img src="ajax.gif" align="absmiddle"> Please wait...');
        $.ajax({
        type: "POST",
        url: url,
        data: $("#form_reset_pwd").serialize(), // serializes the form's elements.
          success: function(data) {
            if(data==1)
            {
              $('#error_result').html('Check your email');
              $('#error_result').addClass("green");
            }
            else
            {
              $('#error_result').html('Invalid email id. Please check your email id.');
              $('#error_result').addClass("red");
            }
          }
        });
      }
      return false;
    });
});
</script>
                                    
