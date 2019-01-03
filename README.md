Openpay Sdk Documentation:


This docmetation basically for non composer php. if you want to use our sdk for composer based php like laravel go to in lib folder and take OpenPayLaravel folder. and delete the other one. There is an instruction for the use.

Non composer php framework/Custom php:
------------------------------------------
------------------------------------------


1. Copy the lib folder into the root of the project.
2. Include the Openpay.php in the checkout page 
   like require(dirname(__FILE__) . '/lib/OpenPay/Common/Openpay.php');
3. then you have to set the basic parameters like this 

$current_url='http://phpsdk.openpaytestandtrain.com.au';
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

4. now you have to call the Call-1 new online order menthods like this :

$Method = "NewOnlineOrder";
$obj = new NewOnlineOrder(URL,$Method,$PurchasePrice,JAMTOKEN, AUTHTOKEN,'','','','','');
$responsecall1 = $obj->_checkorder();
$outputcall1 = json_decode($responsecall1,true);
$openErrorStatus = new ErrorHandler();
if($openErrorStatus !=''){
	$openErrorStatus->_checkstatus($outputcall1['status']);	
} 

5. Store cal-1 response in log file use this code:

//Something to write to txt log
$log  = "Call-time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
         "Log: ".$responsecall1.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./lib/Openpay/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);

6. now we got plan id and ready for payment so here it is

if($outputcall1)
{
	$JamPlanID = $outputcall1['PlanID'];//Plan ID retrieved from Web Call 1 API
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
}

7. After the process is complete, the Jam system will redirect to the URL supplied along with a response value for the transaction.
Success Result [JamCallbackURL]?status=LODGED&planid=1000000004231&orderid=h00000001
Cancel Result [JamCancelURL or JamCallbackURL]?status=CANCELLED&planid=1000000004231&orderid=h00000001
Failure Result [JamFailURL or JamCallbackURL]?status=FAILURE&planid=1000000004231&orderid=h00000001

8. add the payment capture Api(call-3) at the successful page
require(dirname(__FILE__) . '/lib/Openpay/Common/Openpay.php');
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





