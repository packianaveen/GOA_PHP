<?php header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db_connection.php';
require_once dirname(__FILE__) . '/ModbusMasterTCP.php';
require 'log.php';
?> 
<?php
$conn = $db_conn;

	if(!$conn)
	{	
		die("connection faild:" .$conn-> connect_error);

	}
// $modbus = new ModbusMaster("192.168.0.120", "TCP");
// $modbus->connect();
$data = json_decode(file_get_contents("php://input"));
$turboIdVal = mysqli_real_escape_string($db_conn, trim($data->turboIdVal));

$sql  = "SELECT testno from enertek_combuster_goa.test where turboconfig_id='$turboIdVal' order by test_id desc limit 1";
$result  = mysqli_query($conn,$sql);
// if(!$result){
//             wh_log("Get Test ID : " . $db_conn -> error);
//         }
$rows  = array();

	if(mysqli_num_rows($result) > 0){
		while ($r  = mysqli_fetch_assoc($result)) {
			array_push($rows, $r);
			# code...
		}

		$testno =  $rows[0]['testno'];
		// wh_log("Get Test ID : Started");
           		

	}
	else
	{
		$testno = 0;
	}
$newtestNo = $testno+1;
$witnessItems = [];
$testerItems = [];
for($i=0;$i<count($data->testerItems);$i++){
	$testerItems[$i] = $data->testerItems[$i];
}
$testerItems = implode(',', $testerItems);
for($i=0;$i<count($data->witnessItems);$i++){
	$witnessItems[$i] = $data->witnessItems[$i];
}
$witnessItems = implode(',', $witnessItems);

	$inserttestidData = mysqli_query($conn,"INSERT INTO `enertek_combuster_goa`.`test`(`turboconfig_id`,`testno`,`tester`,`witness`,`testingdatetime`)VALUES('$turboIdVal','$newtestNo','$testerItems','$witnessItems',Now())");
?>


