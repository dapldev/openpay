<?php
namespace openpaydapl\openpay\lib\Openpay\Api;
/**
 * Class OpenpayCharge
 *
 * Call 2 - Online Plan Creation Post
 *
 * @package OpenPay\Api
 
 */
class OpenpayCharge
{
	//this method is making the dynamic url and redirect to openpay login page
	public static function _charge($pagegurl)
	{
		//echo $pagegurl;die;
		return redirect($pagegurl)->send();die;
		//echo '<script>window.location.href="'.$pagegurl.'"</script>';die;
	}
	
	/*After the process is complete, the Jam system will redirect to the URL supplied along with a response value for the transaction.
				Success Result [JamCallbackURL]?status=SUCCESS&planid=1000000004231&orderid=h00000001
				
				Cancel Result [JamCancelURL or JamCallbackURL]?status=CANCELLED&planid=1000000004231&orderid=h00000001
				
				Failure Result [JamFailURL or JamCallbackURL]?status=FAILURE&planid=1000000004231&orderid=h00000001
	*/
}
?>
