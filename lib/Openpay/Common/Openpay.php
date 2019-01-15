<?php 

namespace openpay\openpaylaravel\lib\Openpay\Common;

/**

 * Class Openpay

 *

 * User have to access this file to use openpay sdk

 *

 * @package OpenPay\Common

 */

 

//define your url and tokens

		define("URL","https://retailer.myopenpay.com.au/ServiceTraining/JAMServiceImpl.svc/");//Openpay Test Mode Or Live Mode URL place here

		define("CALLBACK_URL",url('/callback'));//Openpay Callback URL place here

		define("CANCEL_URL",url('/cancel'));//Openpay Cancel URL place here

		define("FAILURE_URL",url('/failure'));//Openpay Failure URL place here

		define("FORM_URL","https://retailer.myopenpay.com.au/WebSalesTraining/"); //Openpay Form Submit URL place here

		define("JAMTOKEN","30000000000000889|155f5b95-a40a-4ae5-8273-41ae83fec8c9");//Openpay Test Mode or Live Mode JAMTOKEN place here

		$token = explode('|',JAMTOKEN);

		define("AUTHTOKEN",$token[0]);

		$service_url = '';
		require(dirname(dirname(__FILE__)) . '/Validation/Validation.php');

		require(dirname(dirname(__FILE__)) . '/Core/ApiConnection.php');

		require(dirname(dirname(__FILE__)) . '/Exception/ErrorHandler.php');

		require(dirname(dirname(__FILE__)) . '/Api/MinMaxPurchasePrice.php');//Min/Max

		require(dirname(dirname(__FILE__)) . '/Api/NewOnlineOrder.php');//call-1

		require(dirname(dirname(__FILE__)) . '/Api/OpenpayCharge.php');//call-2

		require(dirname(dirname(__FILE__)) . '/Api/OnlineOrderCapturePayment.php');//call-3

		require(dirname(dirname(__FILE__)) . '/Api/OnlineOrderStatus.php');//call-4

		require(dirname(dirname(__FILE__)) . '/Api/PlanPurchasePriceReductionCall.php');//refund 

		require(dirname(dirname(__FILE__)) . '/Api/OnlineOrderDispatchPlan.php');//Plan Dispatch Call 

