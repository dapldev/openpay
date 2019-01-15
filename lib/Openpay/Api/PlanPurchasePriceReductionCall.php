<?php
namespace openpayau\openpaylaravel\lib\Openpay\Api;
/**
 * Class PlanPurchasePriceReductionCall
 *
 *Plan Purchase Price Reduction Call
 
 *This API is provided to suit automated fulfilment systems that can automatically adjust the value of prospective orders when stock availability requires it. Where no such system is available, a human interface is provided via the web pages to make adjustments to Plan purchase prices.
 *
 * @package OpenPay\Api
 
 
 parameters 
 
 Element   			 Value          Optional?  						Notes
 
 JamAuthToken        Chars                                       A unique string issued to the Retailer.
									Either token 
									must be present
 AuthToken           Chars                                       First Part: Store Identity Num (Retailer Issued) Second Part: GUID issued by Openpay
 
 PlanID              BigInt (13)    No                           The Plan ID that represents the recently created order.
 
 NewPurchasePrice    Money          No                           Must be zero, or greater than zero and less than the current Purchase Price for
                                                                 the Plan ID concerned. Either NewPurchasePrice OR ReducePriceBy must be supplied. In the event that both are greater than zero, they both must be accurate (i.e. New Purchase Price and Reduction are correct).
 
 ReducePriceBy       Money          No                           Must be zero, or greater than zero and less than the current Purchase Price for 
                                                                 the Plan ID concerned. This will reduce the current value of a Plan by the nominated amount and helps cater for Split Order situations where the original value of the order is no longer known
 
 FullRefund       True/False        No                            If True then the entire Plan will be Refunded instead of reduced. 
                                                                  A setting of True here will completely override the NewPurchasePrice and ReducePriceBy field values. If Null then assumed to be False.
					
 
 */
Class PlanPurchasePriceReductionCall extends \openpayau\openpaylaravel\lib\Openpay\Core\ApiConnection 
{    //making the api body with parameters in xml format   
	  private function _prepareXmldocument(){
        $this->xml = new \SimpleXMLElement('<OnlineOrderReduction/>'); 
        $this->xml->addChild('JamAuthToken', $this->jamtoken );
        $this->xml->addChild('PlanID', $this->PlanID);
        $this->xml->addChild('NewPurchasePrice', $this->NewPurchasePrice);
        $this->xml->addChild('ReducePriceBy', $this->ReducePriceBy);
        $this->xml->addChild('FullRefund', $this->FullRefund);
        return $this->xml;
    }
    /*
     * returns : Order Detailes
     */
    public function _checkorder()
    {
      // Algo ;
      try {
        \openpayau\openpaylaravel\lib\Openpay\Validation\Validation::_validatePrice($this->PurchasePrice);
        if($this->ReducePriceBy)
        {
          \openpayau\openpaylaravel\lib\Openpay\Validation\Validation::_validatePrice($this->ReducePriceBy);
        }
        //If the exception is thrown, this text will not be shown
        $this->_updateUrl();
        $this->_prepareXmldocument();
        $this->_sendRequest();
        $this->_parseResponse();
        return $this->response;
      }
      catch(Exception $e) {
        echo 'Message: ' .$e->getMessage();
      }
    }
}