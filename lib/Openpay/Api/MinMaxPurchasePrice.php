<?php
namespace openpay-sdk\openpaylaravel\lib\Openpay\Api;
/**
 * Class MinMaxPurchasePrice
 *
 *Min max range against a JamAuthToken
 *
 * @package OpenPay\Api
	This will return the range of your JamAuthToken
 */
Class MinMaxPurchasePrice extends \openpay-sdk\openpaylaravel\lib\Openpay\Core\ApiConnection 
{
    //to prepare the xml request
	private function _prepareXmldocument(){ 
        $this->xml = new \SimpleXMLElement('<MinMaxPurchasePrice/>'); 
        $this->xml->addChild('JamAuthToken', $this->jamtoken ); 
        return $this->xml;
    }
	//get the output method
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
