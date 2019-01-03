<?php
namespace App\Http\Controllers\lib\OpenPay\Api;
/**
 * Class OnlineOrderCapturePayment
 *
 * Call 3 – OnlineOrderCapturePayment
 *
 * @package OpenPay\Api
 
* NOTE: This API call will actually take the deposit payment for the Plan and make the purchase Active in the Openpay system. This call must occur within 15 minutes from when the consumer has finished the Plan selection process and the user flow has redirected back to the host system.
 */
Class OnlineOrderCapturePayment extends \App\Http\Controllers\lib\OpenPay\Core\ApiConnection
{      
    private function _prepareXmldocument(){
        $this->xml = new \SimpleXMLElement('<OnlineOrderCapturePayment/>'); 
        $this->xml->addChild('JamAuthToken', $this->jamtoken );
        $this->xml->addChild('AuthToken', $this->authtoken );
        $this->xml->addChild('PlanID', $this->PlanID);
        return $this->xml;
    }
    /*
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