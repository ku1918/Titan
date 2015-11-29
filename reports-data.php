<?php
/* Database connection start */
include_once 'include/dbconnect2.php';
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'date', 
	1 => 'Username',
	2 => 'Deposits',
	3 => 'Withdrawal',
	4 => 'Bets',
	5 => 'Wins',
	6 => 'NetLoss',
	7 => 'NetPurchase',
	8 => 'NetGaming',
	9 => 'ProgressiveShare',

);

// getting total number records without any search
$sql = "SELECT *";
$sql.=" FROM transaction_log";
$query=mysqli_query($db, $sql) or die("Fail Query");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *";
$sql.=" FROM transaction_log WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( date LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR Username LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR Deposits LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR Withdrawal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR Bets LIKE '".$requestData['search']['value']."%'";
	$sql.=" OR Wins LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR NetLoss LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR NetPurchase LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR NetGaming LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR ProgressiveShare LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($db, $sql) or die("Fail Query");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($db, $sql) or die("Fail Query");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["date"];
	$nestedData[] = $row["Username"];
	$nestedData[] = $row["Deposits"];
	$nestedData[] = $row["Withdrawal"];
	$nestedData[] = $row["Bets"];
	$nestedData[] = $row["Wins"];
	$nestedData[] = $row["NetLoss"];
	$nestedData[] = $row["NetPurchase"];
	$nestedData[] = $row["NetGaming"];
	$nestedData[] = $row["ProgressiveShare"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
