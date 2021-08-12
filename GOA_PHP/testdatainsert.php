<?php header('Access-Control-Allow-Origin: *');
require 'db_connection.php';
require 'constant.php';
require_once dirname(__FILE__) . '/ModbusMasterTCP.php';
require 'log.php';
?>
<?php
$modbus = new ModbusMaster("192.168.0.120", "TCP");
$Db_delay = 5;
$modbus->connect();
$conn = $db_conn;

	if(!$conn)
	{
		die("connection faild:" .$conn-> connect_error);

	}
$sql  = "SELECT test_id FROM `test` order by `test_id` desc limit 1";
$result  = mysqli_query($conn,$sql);
if(!$result){
            wh_log("Data Insert : " . $db_conn -> error);
        }
$rows  = array();

	if(mysqli_num_rows($result) > 0){
		while ($r  = mysqli_fetch_assoc($result)) {
			array_push($rows, $r);
			# code...
		}

		
		$test_id = $rows[0]['test_id'];
        wh_log("Start (PLC TO DB) : Started");				

	}
	function hex2float($strHex) {
    $hex = sscanf($strHex, "%02x%02x%02x%02x%02x%02x%02x%02x");
    $bin = implode('', array_map('chr', $hex));
    $array = unpack("Gnum", $bin);
    return $array['num'];
}
while(1){


//sensor value read
	// $sensorData = $modbus->readMultipleRegisters(0,19, 50);
    
	// $TempData = array_slice($sensorData,0,14);
	// $arr = array_slice($sensorData,14,32);
 //    $Temp = array_chunk($TempData, 2);
 //    $T1 =PhpType::bytes2signedInt($Temp[0]);   
 //    $T2 = PhpType::bytes2signedInt($Temp[1]);    
 //   	$T3 = PhpType::bytes2signedInt($Temp[2]);    
 //    $T4 =PhpType::bytes2signedInt($Temp[3]);   
 //  	$T5 =PhpType::bytes2signedInt($Temp[4]); 
 //  	$T11 = PhpType::bytes2signedInt($Temp[5]);


//real Values

 /*   $pr = array_chunk($arr, 4);
    // print_r($pr);


    $b = $pr[0];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P1 =  round($float,1);
    
    $b = $pr[1];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P2 =  round($float,1);
    
    $b = $pr[2];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P3 =  round($float,1);
   
    $b = $pr[3];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P4=  round($float,1);
   
    $b = $pr[4];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P5 =  round($float,1);
    
    $b = $pr[5];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P6 =  round($float,1);
   
    $b = $pr[6];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P7 =  round($float,1);
    
    $b = $pr[7];

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $FFR =  round($float,1);


$ar = $modbus->readMultipleRegisters(0, $rpmc, 2);

// print_r($ar);
$rpm1 = ($ar[0]<<24) + ($ar[1]<<16) + ($ar[2]<<8) + $ar[3];
*/
$P2 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,10, 1));
$P5 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,13, 1));
$P6 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,14, 1));
$P7 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,16, 1));
$P10 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,18, 1));
$P13 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,21, 1));
$P16 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,24, 1));
$P17 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,25, 1));
$P25 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,44, 1));
$P27 = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,35, 1));



$pr =$modbus->readMultipleRegisters(0,9, 2);

$b = $pr;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P1 =  round($float,1);

$pr1 = $modbus->readMultipleRegisters(0,7, 1);
$b = $pr1;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P3 =  round($float,1);

$pr2 = $modbus->readMultipleRegisters(0,12, 1);

$b = $pr2;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P4 =  round($float,1);


$pr3 = $modbus->readMultipleRegisters(0,23, 1);
$b = $pr3;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P14 =  round($float,1);

$pr4 = $modbus->readMultipleRegisters(0,28, 1);

$b = $pr4;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P20 =  round($float,1);

$pr5 = $modbus->readMultipleRegisters(0,39, 1);
$b = $pr5;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P21 =  round($float,1);
$pr6 = $modbus->readMultipleRegisters(0,30, 1);

$b = $pr6;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P22 =  round($float,1);
$pr7 = $modbus->readMultipleRegisters(0,37, 1);
$b = $pr7;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P23 =  round($float,1);

$pr7 = $modbus->readMultipleRegisters(0,32, 1);
$b = $pr7;

    $a = dechex($b[0]);
    for($x = 1; $x < count($b); $x++) {
        $a = $a . dechex($b[$x]);
    }
    $float = hex2float($a);

    $P24 =  round($float,1);


$nshutdowncompleted = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,51, 1));
$eshutdown = PhpType::bytes2signedInt($modbus->readMultipleRegisters(0,74, 1));

$insertData = mysqli_query($conn,"INSERT INTO `enertek_combuster_goa`.`testdata`(`test_id`,`P1`,`P2`,`P3`,`P4`,`P5`,`P6`,`P7`,`P10`,`P13`,`P14`,`P16`,`P17`,`P20`,`P21`,`P22`,`P23`,`P24`,`P25`,`P27`,`testdataDate`,`Date`)VALUES('$test_id','$P1','$P2','$P3','$P4','$P5','$P6','$P7','$P10','$P13','$P14','$P16','$P17','$P20','$P21','$P22','$P23','$P24','$P25','$P27',now(),now())");



// if($logFileConstant == 2){
//     $DATA = strval($rpm1) . ','. strval($T1). ','.strval($T2). ','.strval($T3). ','.strval($T4). ','.strval($T5) . ','.strval($T11). ','. strval($P1) . ','. strval($P2) . ','. strval($P3) . ','. strval($P4). ','.strval($P5) . ','. strval($P6) . ','. strval($P7) . ','. strval($FFR) ;
//     wh_log("Sensor data :" . $DATA);
// }
    
if($nshutdowncompleted == 1){
	
	break;
}
if($eshutdown == 1){
	
	break;
}
sleep($data_access_time);
}

