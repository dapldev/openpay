<?php
namespace openpaydapl\openpay\lib\Openpay\Api;
/**
 * Class OnlineOrderStatus
 *
 * Call 4 - Online Order Status (Optional)
 *
 * @package OpenPay\Api
 
 
 Response :
 The json data will contain:
 
 Element           Format          Notes
 Status             Int            0 – Successful >0 – Error Code
 
 Reason             Chars          A description of why it was unsuccessful.
 
 PlanID             BigInt (13)    A 13 digit number representing the Plan ID that can be used in the subsequent order
 
 PurchasePrice      Decimal        Purchase price of the order
 
 OrderStatus        Chars          “Approved” Plan was successfully created for the customer
                                   “Rejected” Plan was not created successfully
                                   “Refused” Attempt to view Plan for a different Retailer
								   
 PlanStatus         Chars          “Active” Plan created and still live in the system
									“Refunded” Plan has been refunded
									“Finished” Plan has been fully completed by customer
									“Errored” Plan has an anomalous status
									“Refused” Attempt to view Plan for a different Retailer
									“BeingProcessed” Plan has been retrieved by customer App
									“N/A” In the event that the Plan was Rejected
									
 PurchasePrice      Decimal          Purchase price of the order
 */
Class OnlineOrderStatus extends \openpaydapl\openpay\lib\Openpay\Core\ApiConnection
{   //making the api body with parameters in xml format   
    private function _prepareXmldocument(){
        $this->xml = new \SimpleXMLElement('<OnlineOrderStatus/>'); 
        $this->xml->addChild('JamAuthToken', $this->jamtoken );
        $this->xml->addChild('PlanID', $this->PlanID);
        return $this->xml;
    }/*
     * returns : Order Detailes
     */
    public function _checkorder()
    {
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