<?php
/* 
 * Class OnlineOrderFraudAlert
 *
 *Plan Dispatch Call
 * @package OpenPay\Api
 This API call is provided for those systems that support latent customer fraud warning alerts that may be received outside of the normal process.
parameters 
 
 Element   			 Value          Optional?  						Notes
 
 JamAuthToken        Chars                                       A unique string issued to the Retailer.
									Either token 
									must be present
									
  AuthToken           Chars                                       First Part: Store Identity Num (Retailer Issued) Second Part: GUID issued by Openpay 
  
  PlanID              BigInt (13)                                The Plan ID that represents the recently created order.
 									
 Details           Text             Yes                         Any comments / details about the person involved that were received from the external source. 
 
 
 
  Response :
 The json data will contain:
 
 Element           Format          Notes
 Status             Int            0 – Successful >0 – Error Code
 
 Reason             Chars          A description of the error encountered.
 
 PlanID             BigInt (13)    The PlanID that was inspected
*/
Class OnlineOrderFraudAlert extends ApiConnection 
{
	
    
    private function _prepareXmldocument(){
        $this->xml = new SimpleXMLElement('<OnlineOrderFraudAlert/>'); 
        $this->xml->addChild('JamAuthToken', $this->jamtoken );
        $this->xml->addChild('PlanID', $this->PlanID);
        $this->xml->addChild('Text', $this->Text);
        return $this->xml;
    }
   
    
    /*
     * returns : Order Detailes
     */
    public function _OnlineOrderFraudAlert()
    {
		 try {
			   // Algo ;
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