Openpay Sdk laravel 5.4> Documentation:
**************************


    ////// ////// ////// ///  // ////// ////// //    //
   //  // //  // //     ///  // //  // //  //  //  //
  //  // ////// ////// // / // ////// //////   ////
 //  // //     //     //  /// //     //  //    //
////// //     ////// //  /// //     //  //    //



This docmetation basically for composer php. if you want to use our sdk for composer based php like laravel go to in lib folder and take OpenPayLaravel folder. and delete the other one. There is an instruction for the use.
here openpaydapl is vander name
Laravel Framework:
------------------------------------------
------------------------------------------

1. To install Openpay composer package run the below command
  composer require openpay/openpaylaravel dev-master

   *After Installation give write permission to the log folder in the path "/vendor/openpaydapl/ 
    openpay/lib/Openpay/log".

2. Include the Openpay.php in the any controller page
   require(app_path('/../vendor/openpay/openpaylaravel/lib/Openpay/Common/Openpay.php'));
   
   In the file the basic urls are define like this and use those constant.

   define("URL","https://retailer.myopenpay.com.au/ServiceTraining/JAMServiceImpl.svc/");//Openpay 
   Test Mode Or Live Mode URL place here
   
   define("CALLBACK_URL",url('/callback'));//Openpay Callback URL place here

   define("CANCEL_URL",url('/cancel'));//Openpay Cancel URL place here

   define("FAILURE_URL",url('/failure'));//Openpay Failure URL place here

   define("FORM_URL","https://retailer.myopenpay.com.au/WebSalesTraining/"); //Openpay Form Submit 
   URL place here

   define("JAMTOKEN","30000000000000889|155f5b95-a40a-4ae5-8273-41ae83fec8c9");//Openpay Test Mode 
   or Live Mode JAMTOKEN place here.(* When it is generate just change the JAMTOKEN) 

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

4. now you have to call the Call-1 NEW ONLINE ORDER API menthods like this :

					$Method = "NewOnlineOrder";
						$obj = new \openpay\openpaylaravel\lib\Openpay\Api\NewOnlineOrder(URL,$Method,$PurchasePrice,JAMTOKEN, AUTHTOKEN,'','','','','');
						
						$responsecall1 = $obj->_checkorder();
						$output = json_decode($responsecall1,true);
						$openErrorStatus = new \openpay\openpaylaravel\lib\OpenPay\Exception\ErrorHandler();
						if($openErrorStatus !=''){
							$openErrorStatus->_checkstatus($output['status']);	
						} 

5. Store Call-1 response in log file use this code:

                    $log  = "Call-time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
								 "Log: ".$responsecall1.PHP_EOL.
								"-------------------------".PHP_EOL;
						//Save string to log, use FILE_APPEND to append.
						file_put_contents(app_path('/../vendor/openpay/openpaylaravel/lib/Openpay').'/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);

6. now we got plan id and ready for payment so here it is by Call-2 API

						if($output){

						$JamPlanID = $output['PlanID'];//Plan ID retrieved from Web Call 1 API
						$pagegurl = $form_url.'?JamCallbackURL='.$JamCallbackURL.'&JamCancelURL='.$JamCancelURL.'&JamFailURL='.$JamFailURL.'&JamAuthToken='.urlencode(JAMTOKEN).'&JamPlanID='.urlencode( (string) $JamPlanID).'&JamRetailerOrderNo='.urlencode( $JamRetailerOrderNo ).'&JamPrice='.urlencode($PurchasePrice).'&JamEmail='.urlencode($JamEmail).'&JamFirstName='.urlencode($JamFirstName).'&JamOtherNames='.urlencode($JamOtherNames).'&JamFamilyName='.urlencode($JamFamilyName).'&JamDateOfBirth='.urlencode($JamDateOfBirth).'&JamAddress1='.urlencode($JamAddress1).'&JamAddress2='.urlencode($JamAddress2).'&JamSubrub='.urlencode($JamSubrub).'&JamState='.urlencode($JamState).'&JamPostCode='.urlencode($JamPostCode).'&JamDeliveryDate='.urlencode($JamDeliveryDate);
									try {
										if($JamDateOfBirth)
											\openpay\openpaylaravel\lib\OpenPay\Validation\Validation::_validateDate($JamDateOfBirth);	 
										if($JamDateOfBirth)
											\openpay\openpaylaravel\lib\OpenPay\Validation\Validation::_validateDate($JamDeliveryDate);
										if($JamState)
											\openpay\openpaylaravel\lib\OpenPay\Validation\Validation::_validateState($JamState);
										if($JamPostCode)
											\openpay\openpaylaravel\lib\OpenPay\Validation\Validation::_validatePostcode($JamPostCode);	  	
										$charge = \openpay\openpaylaravel\lib\OpenPay\Api\OpenpayCharge::_charge($pagegurl);
									}
									catch(Exception $e) {
										echo 'Message: ' .$e->getMessage();
									}
								}

7. After the process is complete, the Jam system will redirect to the URL supplied along with a response value for the transaction.
Success Url : [JamCallbackURL]?status=SUCCESS&planid=3000000022284&orderid=1402

Success Result :
	Array
	(
   	 	[status] => 0
    	 	[reason] => Array
        		(
        		)

    		[PlanID] => 3000000022284
    		[PurchasePrice] => 110.0000
	)
Cancel Url : [JamCancelURL or JamCallbackURL]?status=CANCELLED&planid=3000000022284&orderid=1402

Cancel Result :
	Array ( [status] => CANCELLED [planid] => 3000000022284 [orderid] => 1402 ) 

Failure Url : [JamFailURL or JamCallbackURL]?status=FAILURE&planid=3000000022284&orderid=1402

Failure Result :
	Array ( [status] => FAILURE [planid] => 3000000022284 [orderid] => 1402 )

8. add the Call-3 PAYMENT CAPTURE API like below:
 
		$PlanID = '3000000019868';
		$Method = "OnlineOrderCapturePayment";
		$obj = new \openpay\openpaylaravel\lib\OpenPay\Api\OnlineOrderCapturePayment(URL,$Method,'',JAMTOKEN,AUTHTOKEN,$PlanID);
		$response = $obj->_checkorder(); 
		$output = json_decode($response,true); 
		$openErrorStatus = new \openpay\openpaylaravel\lib\OpenPay\Exception\ErrorHandler();
		if($openErrorStatus !=''){
			$openErrorStatus->_checkstatus($output['status']);	
		}
		//Something to write to txt log
		$log  = "Call 3 log time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				 "Log: ".$response.PHP_EOL.
				"-------------------------".PHP_EOL;
		//Save string to log, use FILE_APPEND to append.
		file_put_contents(app_path('/../vendor/openpay/openpaylaravel/lib/Openpay').'/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);

9.Check your order status
		
		$PlanID = '3000000019868';//Plan ID retrieved from Web Call 1 API
		$Method = "OnlineOrderStatus";
		$obj = new lib\OpenPay\Api\OnlineOrderStatus(URL,$Method,'',JAMTOKEN,AUTHTOKEN,$PlanID);
		$response = $obj->_checkorder(); 
		$output = json_decode($response,true); 
		$openErrorStatus = new lib\OpenPay\Exception\ErrorHandler();
		//Something to write to txt log
		$log  = "Order status log time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				 "Log: ".$response.PHP_EOL.
				"-------------------------".PHP_EOL;
		//Save string to log, use FILE_APPEND to append.
		file_put_contents(app_path('Http/Controllers/lib/Openpay').'/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);

10. For Refund Process


		$PlanID = '3000000020110';//Plan ID retrieved from Web Call 1 API
		$Method = "OnlineOrderReduction";
		$ReducePriceBy = 50.00;//The amount you want to refund
		$type = False;// make True if want to refund full Plan price
		//echo $ReducePriceBy.'=='.$type;die;
		//True if want to refund full Plan price
		$obj = new \openpay\openpaylaravel\lib\Openpay\Api\PlanPurchasePriceReductionCall(URL, $Method, '', JAMTOKEN, AUTHTOKEN, $PlanID, '', $ReducePriceBy, $type);

		$response = $obj->_checkorder(); 
		$output = json_decode($response,true); 
		//dd($output);
		$openErrorStatus = new \openpay\openpaylaravel\lib\Openpay\Exception\ErrorHandler();
		//Something to write to txt log
		$log  = "Order refund log time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		         "Log: ".$response.PHP_EOL.
		        "-------------------------".PHP_EOL;
		//Save string to log, use FILE_APPEND to append.
		file_put_contents(app_path('/../vendor/openpay/openpaylaravel/lib/Openpay').'/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);

		Refund process will be excute as per the following steps.

			1. At the time of full refund the $ReducePriceBy should be set null and $type should be set False.

			2.For Partial refund $ReducePriceBy should be set as needed and $type should be set True.

			3.Retailers will get refund upto a certain amount which will be set by the Openpay merchant.Once the retailer has reached maximum refund amount limit they will get a message like “Invalid Web Sales Plan Status For Partial Refund”


11. For Plan Dispatch

This call supports Retailers that are set up to not receive any payment for their Plans until their system has issued a dispatch notice. This allows those retailers to make adjustments to their orders as needed prior to fulfilment and then receive the payment and reconciliation information after the dispatch event occurs.


		$PlanID = '3000000020110';//Plan ID retrieved from Web Call 1 API
		$Method = "OnlineOrderDispatchPlan";
		$obj = new \openpay\openpaylaravel\lib\Openpay\Api\OnlineOrderDispatchPlan(URL,$Method,'',JAMTOKEN,AUTHTOKEN,$PlanID);
		$response = $obj->_checkOrderDispatchPlan(); 
		$output = json_decode($response,true); 
		$openErrorStatus = new \openpay\openpaylaravel\lib\Openpay\Exception\ErrorHandler();
		//Something to write to txt log
		$log  = "Order dispatch log time: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
				 "Log: ".$response.PHP_EOL.
				"-------------------------".PHP_EOL;
		//Save string to log, use FILE_APPEND to append.
		file_put_contents(app_path('/../vendor/openpay/openpaylaravel/lib/Openpay').'/Log/log'.date("j.n.Y").'.log', $log, FILE_APPEND);		

