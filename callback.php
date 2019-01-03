<?php
require(dirname(__FILE__) . '/lib/Openpay/Common/Openpay.php');

/*************************************Web Call 3 API****************************/
$plan_id=$_GET['planid'];
$Method = "OnlineOrderCapturePayment";
$obj = new OnlineOrderCapturePayment(URL,$Method,'',JAMTOKEN,AUTHTOKEN,$plan_id);
$response = $obj->_checkorder(); 
$output = json_decode($response,true); 
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}

//Something to write to txt log
$log  = "Call 3 log time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
         "Log: ".$response.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./lib/Openpay/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);


echo '<pre>';print_r($output);die;
/*************************************Web Call 3 API****************************/


