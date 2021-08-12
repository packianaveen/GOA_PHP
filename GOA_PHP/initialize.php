<?php header('Access-Control-Allow-Origin: *');
require 'db_connection.php';
// include 'constant.php';
require_once dirname(__FILE__) . '/ModbusMasterTCP.php';


require 'log.php';
?>


<?php
error_reporting(0);
$conn = $db_conn;

	if(!$conn)
	{
		die("connection faild:" .$conn-> connect_error);

	}
$modbus = new ModbusMaster("192.168.0.10", "TCP");
$Db_delay = 5;
$modbus->connect();
print json_encode($modbus);
$data = array(1);
$modbus->writeMultipleRegister(0, 0, $data, "INT");


$sql  = "SELECT test_id from enertek_combuster_goa.test  order by test_id desc limit 1";
$result  = mysqli_query($conn,$sql);
if(!$result){
            wh_log("Initialize : " . $db_conn -> error);
        }
$rows  = array();

	if(mysqli_num_rows($result) > 0){
		while ($r  = mysqli_fetch_assoc($result)) {
			array_push($rows, $r);
			# code...
		}
		$test_id = intval($rows[0]['test_id']);
		 wh_log("Initialize (Code to PLC) : Started");
		// echo $rows[0]['test_id'];
				

	}
while(1){
	$InitializeCompleted = $modbus->readMultipleRegisters(1, 0, 1);

	if ($InitializeCompleted[1] == 1) {
    break;
  }
  
}
// print json_encode($InitializeCompleted);
$modbus->disconnect();
$inserttestData = mysqli_query($conn,"INSERT INTO `enertek_combuster_goa`.`testcommands`(`test_id`,`name`,`index`,`type`,`value`,`testcommandsTime`)
VALUES('$test_id','Communication','C1','C','',now())");
// $inserttestData = mysqli_query($conn,"INSERT INTO `enertek_combuster_goa`.`testcommands`(`test_id`,`name`,`index`,`type`,`value`,`testcommandsTime`)
// VALUES('$test_id','combustortype','C2','C','',now())");
$inserttestData = mysqli_query($conn,"INSERT INTO `enertek_combuster_goa`.`testcommands`(`test_id`,`name`,`index`,`type`,`value`,`testcommandsTime`)
VALUES('$test_id','Initialize Started','C3','C','',now())");
?>

