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

#$logging="select * from transaction_log where date between '$datefrom' and '$dateto'";

$logging="select * from transaction_log";
$result =$db->query($logging);
$transactiondata=mysqli_fetch_array($result);



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

<!-- Include Required Prerequisites -->
<!--<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>  -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" /> 
 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> 
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />   
<!--<script type="text/javascript">
function functionn()
{
 var id = 'test';
 document.location.href = "http://appboss.duckdns.org/profile/userid?="+id;
}
</script> -->


<script type="text/javascript">
$(function() {

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  	$('#to').val(start.format('YYYY-MM-DD'));
        $('#from').val(end.format('YYYY-MM-DD'));
    }
    cb(moment().subtract(29, 'days'), moment());


    $('#reportrange').daterangepicker({
	 "timePicker": true,
    "timePicker24Hour": true,
    "timePickerSeconds": true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

});
</script> 

<script type="text/javascript" charset="utf-8">
                        $(document).ready(function() {
 $('#example').DataTable( {

"columnDefs": [ {
    "targets": 1,
    "data": "google.com",
    "render": function ( data, type, full, meta ) {
      return data + " (" + '<a href=/profile.php?id='+data+'>Profile</a>' + ")";

    }
  } ],

                                        "fnFooterCallback": function ( nRow, aaData, iDataStart, iDataEnd ) {
                                                /* Calculate the total market share for all browsers in this table (ie inc. outside
                                                 * the pagination
                                                 */
var api = this.api(), data;
                                // Remove the formatting to get integer data for summation
                                var intVal = function ( i ) {
                                        return typeof i === 'string' ? i.replace(/[\$,-]/g, '')*1 : typeof i === 'number' ?     i : 0;
                                };

                                // total_salary over all pages
                                total_salary = api.column( 2 ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                },0 );

                                // total_page_salary over this page
                                total_page_deposits = api.column( 2, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );

                                total_page_withdrawal = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
                                total_page_bets = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
                                total_page_wins = api.column( 5, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
                                total_page_netLoss = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
                                total_page_netPurchase = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
                                total_page_netGaming = api.column( 8, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
                                total_page_progressiveShare = api.column( 9, { page: 'current'} ).data().reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                }, 0 );
				

                                total_page_deposits = parseFloat(total_page_deposits).toFixed(2);
                                total_page_withdrawal = parseFloat(total_page_withdrawal).toFixed(2);
                                total_page_bets = parseFloat(total_page_bets).toFixed(2);
                                total_page_wins = parseFloat(total_page_wins).toFixed(2);
                                total_page_netLoss = parseFloat(total_page_netLoss).toFixed(2);
                                total_page_netPurchase = parseFloat(total_page_netPurchase).toFixed(2);
                                total_page_netGaming = parseFloat(total_page_netGaming).toFixed(2);
                                total_page_progressiveShare = parseFloat(total_page_progressiveShare).toFixed(2);

                                                /* Modify the footer row to match what we want */
                                                var nCells = nRow.getElementsByTagName('th');
                                                nCells[1].innerHTML = total_page_deposits;
                                                nCells[2].innerHTML = total_page_withdrawal;
                                                nCells[3].innerHTML = total_page_bets;
                                                nCells[4].innerHTML = total_page_wins;
                                                nCells[5].innerHTML = total_page_netLoss;
                                                nCells[6].innerHTML = total_page_netPurchase;
                                                nCells[7].innerHTML = total_page_netGaming;
                                                nCells[8].innerHTML = total_page_progressiveShare;
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
 <div class="row">
                                                <div class="col-md-12">
                                                        <div class="content-box-header">
                                                                <div class="panel-title">Search Filter</div>

                                                        </div>
                                                        <div class="content-box-large box-with-header">
Date : 
<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 25%">
    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
    <span></span> <b class="caret"></b>
</div>
<form method='post'>
<input  name="to" id="to" type='date'>
<input name="from" id="from" type='date'>
<input class="btn btn-primary signup" type="submit" value="Generate" name="generate" >
</form>




                                                        </div>
                                                </div>
                                        </div>


        <div class="content-box-large">
          <div class="panel-heading">
            <div class="panel-title">Reports</div>
          </div>

	
          <div class="panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" class="dataTable" id="example">
<thead>
                <tr>
                  <th>Date</th>
                  <th>Username</th>
                  <th>Deposits</th>
                  <th>Withdrawal</th>
                  <th>Bets</th>
                  <th>Wins</th>
                  <th>Net Loss</th>
                  <th>Net Purchase</th>
                  <th>Net Gaming</th>
                  <th>Progressive Share</th>

               </tr>
</thead>
		  <?php   while($row=mysqli_fetch_array($result)){  
			
		  echo "<tr>"; 
		  echo "<td>" . $row['date'] . "</td>";  
		  echo "<td id='user_profile_col' OnClick='functionn()'>" . $row['Username'] . "</td>";  
		  echo "<td>" . $row['Deposits'] . "</td>";  
		  echo "<td>" . $row['Withdrawal'] . "</td>";  
		  echo "<td>" . $row['Bets'] . "</td>";  
		  echo "<td>" . $row['Wins'] . "</td>";  
		  echo "<td>" . $row['NetLoss'] . "</td>";  
		  echo "<td>" . $row['NetPurchase'] . "</td>";  
		  echo "<td>" . $row['NetGaming'] . "</td>";  
		  echo "<td>" . $row['ProgressiveShare'] . "</td>";  
		  echo "</tr>"; 
		
}?>

 <tfoot>
                <tr>
                        <th style="text-align:right" colspan="2">Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                </tr>
        </tfoot>


		  
            </table>
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
  <script src="js/tables.js"></script> 

</body>
</html>
