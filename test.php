<?php
/**
 * Test/Example page of openpay. you can check the all calls here.
 *
 */
 $current_url='http://phpsdk.openpaytestandtrain.com.au';
 //echo  $current_url;die();
require(dirname(__FILE__) . '/lib/Openpay/Common/Openpay.php');
/***************************User Parameter from site***************************/
$PurchasePrice = 170.00;//Format : 100.00(Not more than $1 million)
$JamCallbackURL = $current_url."/openpay-au-sdk/callback.php";//Not more than 250 characters
$JamCancelURL = $current_url."/openpay-au-sdk/cancel.php";//Not more than 250 characters
$JamFailURL = $current_url."/openpay-au-sdk/failure.php";//Not more than 250 characters
$form_url = "https://retailer.myopenpay.com.au/WebSalesTraining/";
$JamRetailerOrderNo = '10000478';//Consumer site order number
$JamEmail = 'gautamtest@gmail.com';//Not more than 150 characters
$JamFirstName = 'Test';//First name(Not more than 50 characters)
$JamOtherNames = 'Devloper';//Middle name(Not more than 50 characters)
$JamFamilyName = 'Test';//Last name(Not more than 50 characters)
$JamDateOfBirth = '04 Nov 1982';//dd mmm yyyy
$JamAddress1 = '15/520 Collins Street';//Not more than 100 characters
$JamAddress2 = '';//Not more than 100 characters
$JamSubrub = 'Melbourne';//Not more than 100 characters
$JamState = 'VIC';//Not more than 3 characters
$JamPostCode = '3000';//Not more than 4 characters
$JamDeliveryDate = '01 Jan 2019';//dd mmm yyyy
/***************************User Parameter****************************/
$product= array('BasketData' => array( 'BasketItem' => array(
																array('ItemName' => 'Shoes', 'ItemGroup' => 'Footwear', 'ItemCode' => '1234567890', 'ItemGroupCode' => 'F123', 'ItemRetailUnitPrice' => '10.00', 'ItemQty' => '10', 'ItemRetailCharge' => '100.00'),
																array('ItemName' => 'Shirt', 'ItemGroup' => 'Dress', 'ItemCode' => '0897564213', 'ItemGroupCode' => 'F789', 'ItemRetailUnitPrice' => '7.00', 'ItemQty' => '10', 'ItemRetailCharge' => '70.00')
			
		)
	)
);

					
$cartProduct=(object)$product;								
 /**************************Min/Max Purchase API****************************/
 /*
$Method = "MinMaxPurchasePrice";
$obj = new MinMaxPurchasePrice(URL,$Method,'',JAMTOKEN, AUTHTOKEN);
$output = json_decode($obj->_checkorder(),true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}
echo '<pre>';print_r($output); */
/**************************Min/Max Purchase API****************************/
/**************************Web Call 1 API****************************/
$Method = "NewOnlineOrder";
$obj = new NewOnlineOrder(URL,$Method,$PurchasePrice,JAMTOKEN, AUTHTOKEN,'','','','','');
$responsecall1 = $obj->_checkorder();
$outputcall1 = json_decode($responsecall1,true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($outputcall1['status']);	
}
//echo '<pre>';print_r($outputcall1);die();
/**************************Web Call 1 API****************************/

//Something to write to txt log
$log  = "Call-time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
         "Log: ".$responsecall1.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./lib/OpenPay/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);
/**************************Web Call 2 API****************************/
if($outputcall1)
{
	$JamPlanID = $outputcall1['PlanID'];//Plan ID retrieved from Web Call 1 API
	$pagegurl = $form_url.'?JamCallbackURL='.$JamCallbackURL.'&JamCancelURL='.$JamCancelURL.'&JamFailURL='.$JamFailURL.'&JamAuthToken='.urlencode(JAMTOKEN).'&JamPlanID='.urlencode( (string) $JamPlanID).'&JamRetailerOrderNo='.urlencode( $JamRetailerOrderNo ).'&JamPrice='.urlencode($PurchasePrice).'&JamEmail='.urlencode($JamEmail).'&JamFirstName='.urlencode($JamFirstName).'&JamOtherNames='.urlencode($JamOtherNames).'&JamFamilyName='.urlencode($JamFamilyName).'&JamDateOfBirth='.urlencode($JamDateOfBirth).'&JamAddress1='.urlencode($JamAddress1).'&JamAddress2='.urlencode($JamAddress2).'&JamSubrub='.urlencode($JamSubrub).'&JamState='.urlencode($JamState).'&JamPostCode='.urlencode($JamPostCode).'&JamDeliveryDate='.urlencode($JamDeliveryDate);
	
	//var_dump($pagegurl);die();
	try {
	  	if($JamDateOfBirth)
	  		Validation::_validateDate($JamDateOfBirth);	 
	  	if($JamDateOfBirth)
	  		Validation::_validateDate($JamDeliveryDate);
	  	if($JamState)
	  		Validation::_validateState($JamState);
	  	if($JamPostCode)
	  		Validation::_validatePostcode($JamPostCode);	  	
		$charge = OpenpayCharge::_charge($pagegurl);
	}
	catch(Exception $e) {
	  	echo 'Message: ' .$e->getMessage();
	}
}
/**************************Web Call 2 API****************************/
/**************************Web Call 4(Optional) API****************************/
$PlanID = '3000000019868';//Plan ID retrieved from Web Call 1 API
$Method = "OnlineOrderStatus";
$obj = new OnlineOrderStatus(URL,$Method,'',JAMTOKEN, AUTHTOKEN, $PlanID);
$output = json_decode($obj->_checkorder(),true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}
echo '<pre>';print_r($output);die;
/**************************Web Call 4(Optional) API****************************/
/**************************Refund API****************************/
$PlanID = '3000000020110';//Plan ID retrieved from Web Call 1 API
$Method = "OnlineOrderReduction";
$NewPurchasePrice = 200.00;//The amount you want to capture as Plan price
$ReducePriceBy = 50.00;//The amount you want to refund
$type = 'False';//True if want to refund full Plan price 
$obj = new PlanPurchasePriceReductionCall(URL, $Method, '', JAMTOKEN, AUTHTOKEN, $PlanID, $NewPurchasePrice, $ReducePriceBy, $type);
$output = json_decode($obj->_checkorder(),true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}
echo '<pre>';print_r($output);die; 
/**************************Refund API****************************/

/**************************Plan Dispatch Call API****************************/
$PlanID = '3000000020110';//Plan ID retrieved from Web Call 1 API
$Method = "OnlineOrderDispatchPlan";
$obj = new OnlineOrderDispatchPlan(URL, $Method, '', JAMTOKEN, AUTHTOKEN, $PlanID);
$output = json_decode($obj->_checkOrderDispatchPlan(),true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}
echo '<pre>';print_r($output);die; 
/**************************Plan Dispatch Call API****************************/
?>