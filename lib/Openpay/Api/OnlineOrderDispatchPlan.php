<?php
namespace App\Http\Controllers\lib\OpenPay\Api;
/**
 * Class OnlineOrderDispatchPlan
 *
 *Plan Dispatch Call
 
 *This call supports Retailers that are set up to not receive any payment for their Plans until their system has issued a dispatch notice. This allows those retailers to make adjustments to their orders as needed prior to fulfilment and then receive the payment and reconciliation information after the dispatch event occurs.
 *
 * @package OpenPay\Api
 
 
 parameters 
 
 Element   			 Value          Optional?  						Notes
 
 JamAuthToken        Chars                                       A unique string issued to the Retailer.
									Either token 
									must be present
 AuthToken           Chars                                       First Part: Store Identity Num (Retailer Issued) Second Part: GUID issued by Openpay 
 
 PlanID              BigInt (13)                                 The Plan ID that represents the recently created order to be dispatched.
 
 
 
  Response :
 The json data will contain:
 
 Element           Format          Notes
 Status             Int            0 – Successful >0 – Error Code
 
 Reason             Chars          A description of the error encountered.
 
 PlanID             BigInt (13)    The PlanID that was inspected
 */
Class OnlineOrderDispatchPlan extends \App\Http\Controllers\lib\OpenPay\Core\ApiConnection 
{
	  private function _prepareXmldocument(){
        $this->xml = new \SimpleXMLElement('<OnlineOrderDispatchPlan/>'); 
        $this->xml->addChild('JamAuthToken', $this->jamtoken );
        $this->xml->addChild('PlanID', $this->PlanID);
        return $this->xml;
    }
    /*
     * returns : Order Detailes
     */
    public function _checkOrderDispatchPlan()
    {
      // Algo ;
      try {
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