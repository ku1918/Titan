<?php
session_start();
include_once 'include/dbconnect2.php';

if(!isset($_SESSION['user'])){
	header ("Location: login.php");
}


//UserInformation
$res=$db->query("select * from users where username='".$_SESSION['user']."'");
$userRow=mysqli_fetch_array($res);
$username=$userRow['username'];
$userCategory=$userRow['category'];


//get User Credit
$getCredit=$db->query("select username,credit from ((select * from player_credit) union (select * from cashier_credit) union (select * from master_credit)) as a where a.username='$username'");
$creditBalance=mysqli_fetch_array($getCredit);
$sourceCredit=$creditBalance['credit'];

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Admin Testing</title>
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
				<li>Username : <?php echo $username ?></li>
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
                    <li class="current"><a href="index.php"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
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
		<!--Credit Balance Value -->
		<div class="sidebar content-box" style="display: block;">
		<b>Total Credit Balance:</b>
				<?php 
				if ($userCategory == 0){
				 echo "<p style='float: right;'>Infinite</p>";
				}
				else{
				 echo "<p style='float: right;'>$sourceCredit</p>";
				}
				?>
		</div>
		  </div>
		  <div class="col-md-10">
		  	<div class="row">
		  		<div class="col-md-6">
		  			<div class="content-box-large">
		  				<div class="panel-heading">
							<div class="panel-title">Welcome to Admin Test Portal Main Page</div>
						</div>
		  				<div class="panel-body">
							helo
		  				</div>
		  			</div>
		  		</div>

		  		<div class="col-md-6">
		  			<div class="row">
		  				<div class="col-md-12">
		  					<div class="content-box-header">
			  					<div class="panel-title">Content2</div>
								
				  			</div>
				  			<div class="content-box-large box-with-header">
							</div>
		  				</div>
		  			</div>
		  			<div class="row">
		  				<div class="col-md-12">
		  					<div class="content-box-header">
			  					<div class="panel-title">Content3</div>
								
				  			</div>
				  			<div class="content-box-large box-with-header">
							</div>
		  				</div>
		  			</div>
		  		</div>
		  	</div>

		  	<div class="row">
		  		</div>
		  	</div>

		  </div>
		</div>
    </div>

    <footer>
         <div class="container">
         
            <div class="copy text-center">
		Property of Seremban
            </div>
            
         </div>
      </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

  </body>
</html>
