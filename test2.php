<?php 
/**
 * Test/Example page of openpay. you can check the all calls here.
 *
 */
require(dirname(__FILE__) . '/lib/OpenPay/Common/Openpay.php');

/***************************User Parameter from site***************************/
$PurchasePrice = 5550.00;//Format : 100.00(Not more than $1 million)
//$JamCallbackURL = "https://cisites.dapldevelopment.com/openpay-au-sdk/lib/callback.php";//Not more than 250 characters
$JamCallbackURL = "http://192.168.0.159/openpay-au-sdk/callback.php";//Not more than 250 characters
$JamCancelURL ="http://192.168.0.159/openpay-au-sdk/cancel.php";//Not more than 250 characters
//$JamCancelURL ="https://cisites.dapldevelopment.com/openpay-au-sdk/lib/cancel.php";//Not more than 250 characters
//$JamFailURL = "https://cisites.dapldevelopment.com/openpay-au-sdk/lib/failure.php";//Not more than 250 characters
$JamFailURL = "http://192.168.0.159/openpay-au-sdk/failure.php";//Not more than 250 characters
$form_url = "https://retailer.myopenpay.com.au/WebSalesTraining/";
$JamRetailerOrderNo = 'F123';//Consumer site order number
//$JamEmail = 'testdevloper007@gmail.com';//Not more than 150 characters
$JamEmail = 'ritayan_z@yahoo.com';//Not more than 150 characters
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


$JamPlanID = '3000000020813';//Plan ID retrieved from Web Call 1 API
	$pagegurl = $form_url.'?JamCallbackURL='.$JamCallbackURL.'&JamCancelURL='.$JamCancelURL.'&JamFailURL='.$JamFailURL.'&JamAuthToken='.urlencode(JAMTOKEN).'&JamPlanID='.urlencode( (string) $JamPlanID).'&JamRetailerOrderNo='.urlencode( $JamRetailerOrderNo ).'&JamPrice='.urlencode($PurchasePrice).'&JamEmail='.urlencode($JamEmail).'&JamFirstName='.urlencode($JamFirstName).'&JamOtherNames='.urlencode($JamOtherNames).'&JamFamilyName='.urlencode($JamFamilyName).'&JamDateOfBirth='.urlencode($JamDateOfBirth).'&JamAddress1='.urlencode($JamAddress1).'&JamAddress2='.urlencode($JamAddress2).'&JamSubrub='.urlencode($JamSubrub).'&JamState='.urlencode($JamState).'&JamPostCode='.urlencode($JamPostCode).'&JamDeliveryDate='.urlencode($JamDeliveryDate);
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

/**************************Plan Dispatch Call API****************************/
$PlanID = '3000000020110';//Plan ID retrieved from Web Call 1 API
$Method = "OnlineOrderDispatchPlan";
$obj = new OnlineOrderDispatchPlan(URL, $Method, '', JAMTOKEN, AUTHTOKEN, $PlanID);
$output = json_decode($obj->_checkOrderDispatchPlan(),true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}
echo '<pre>';print_r($output);
/**************************Plan Dispatch Call API****************************/


/**************************Online Order Fraud Alert API****************************/
$PlanID = '3000000020110';//Plan ID retrieved from Web Call 1 API
$Method = "OnlineOrderFraudAlert";
$Text = "this is a test call";
$obj = new OnlineOrderFraudAlert(URL, $Method, '', JAMTOKEN, AUTHTOKEN, $PlanID,'','','', $Text);
$output = json_decode($obj->_OnlineOrderFraudAlert(),true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($output['status']);	
}
echo '<pre>';print_r($output);die; 
/**************************Plan Dispatch Call API****************************/