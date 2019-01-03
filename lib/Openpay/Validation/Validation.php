<?php
namespace App\Http\Controllers\lib\OpenPay\Validation;
/**
 * Class Validation
 *
 * use for validation in openpay api class
 *
 * @package OpenPay\Validation
 */
class Validation
{
	//use date format: dd mmm yyyy{ 01 Jan 2001}
	public static function _validateDate($date)
	{
		if(!preg_match("/^([0-9]{2} [A-Za-z]{3} [0-9]{4})$/",$date))
	    {
	        throw new \Exception("Date should be in dd mmm yyyy{ 01 Jan 2001} format");
	        return false;
	    }
	    return $date;
	}
	
	//use price Format: NNNN.NN and should not to be negetive
	public static function _validatePrice($PurchasePrice)
	{
		/* if(!is_float($PurchasePrice))
	    {
	        throw new \Exception("All Price should be in decimal format");
	        return false;
	    } */
	    if($PurchasePrice < 0)
	    {
	    	throw new \Exception("Purchase Price should be in positive");
	    	return false;
	    }
	    return $PurchasePrice;
	}
	
	//use The state for the address (e.g. VIC, NSW, etc)
	public static function _validateState($state)
	{
		//format: VIC
		if(!preg_match("/^([A-Z]{3})$/",$state))
	    {
	        throw new \Exception("State should be in VIC format");
	        return false;
	    }
	    return $state;
	}
	
	//The postcode for the customers address.Format: NNNN (zero-padded to the left)
	public static function _validatePostcode($postcode)
	{
		//format: 3000
		if(!preg_match("/^([0-9]{4})$/",$postcode))
	    {
	        throw new \Exception("Postcode should be in 3000 format");
	        return false;
	    }
	    return $postcode;
	}
	
	//This validation for min max range supplied by openpay for the particular jamauthtoken
	public static function _minmaxPrice($PurchasePrice)
	{
		$Method = "MinMaxPurchasePrice";
		$obj = new \App\Http\Controllers\lib\OpenPay\Api\MinMaxPurchasePrice(URL,$Method,'',JAMTOKEN, AUTHTOKEN);
		$output = json_decode($obj->_checkorder(),true);

		if($output['status']==0)
		{

			if(($PurchasePrice >= $output['MaxPrice']) || ($PurchasePrice <= $output['MinPrice'] ))
			{
				
				throw new \Exception("Invalid Purchase Price (purchase price should be in Min/Max purchase price range)");
	        	return false;
			}
		}
		return $PurchasePrice;
	}
}