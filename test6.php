<?php
session_start();
include_once 'include/dbconnect2.php';

if(!isset($_SESSION['user'])){
        header ("Location: login.php");
}

$res=$db->query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysqli_fetch_array($res);
$username=$userRow['username'];
$getCredit=$db->query("SELECT * FROM player_credit WHERE username='$username'");
$creditBalance=mysqli_fetch_array($getCredit);


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


  <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
                <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
                <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" >

                        $(document).ready(function() {
                                var dataTable = $('#example').DataTable( {
                                        "processing": true,
                                        "serverSide": true,
                                        "ajax":{
                                                url :"employee-grid-data.php", // json datasource
                                                type: "post",  // method  , by default get
                                                error: function(){  // error handling
                                                        $(".employee-grid-error").html("");
                                                        $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                                        $("#employee-grid_processing").css("display","none");

                                                }
                                        }
                                } );
                        } );
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
				 <li><?php echo $userRow['username']?></li>
                                 <li>Credit : RM <?php echo $creditBalance['credit']?></li>
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
                    <li><a href="tables.html"><i class="glyphicon glyphicon-list"></i> Reports</a></li>
                    <li><a href="tables.html"><i class="glyphicon glyphicon-list"></i> Tables</a></li>
                    <li class="current"><a href="creditTransfer.php"><i class="glyphicon glyphicon-tasks"></i> Credit Transfer</a></li>
                    <li><a href="forms.html"><i class="glyphicon glyphicon-tasks"></i> Forms</a></li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Pages
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="signup.html">Signup</a></li>
                        </ul>
                    </li>
                </ul>
             </div>
		  </div>
		  <div class="col-md-10">
  			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Master List</div>
				</div>
  				<div class="panel-body">
  				<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>Username</th>
								<th>Current Credit</th>
								<th>CSS grade</th>
							</tr>
					</thead>
					</table>
  				</div>
  			</div>



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

      <link href="vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://code.jquery.com/jquery.js"></script> -->
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>

    <script src="vendors/datatables/dataTables.bootstrap.js"></script>

    <script src="js/custom.js"></script>
    <script src="js/tables.js"></script>
  </body>
</html>
