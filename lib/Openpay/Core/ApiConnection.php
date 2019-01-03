<?php
namespace App\Http\Controllers\lib\OpenPay\Core;
/**
 * Class ApiConnection
 *
 * this is the core class of openpay
 *
 * @package OpenPay\Core
 */
class ApiConnection
{
	protected $Method;
	public function __construct($url,$Method,$PurchasePrice='',$jamtoken,$authtoken,$PlanID='',$NewPurchasePrice='', $ReducePriceBy='', $type='',$Text='',$BasketData=array()) {
	    $this->Method = $Method;
	    $this->url = $url;
	    $this->service_url = '';
	    $this->PurchasePrice = $PurchasePrice;
	    $this->jamtoken = $jamtoken;
	    $this->authtoken = $authtoken;
	    $this->PlanID = $PlanID;
	    $this->NewPurchasePrice = $NewPurchasePrice;
	    $this->ReducePriceBy = $ReducePriceBy;
	    $this->FullRefund = $type;
	    $this->Text = $Text;
		$this->BasketData = $BasketData;
	}
	
	//This method is using for make the service url
	protected function _updateUrl(){
		$this->service_url  = $this->url . $this->Method;         
	}
	//This method is help to call the related api and return the response
	protected function _sendRequest(){ 
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_URL, $this->service_url );
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->xml->asXML() );
	    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/xml'));
	    return $this->response=curl_exec($ch);
	}
	//This method is using the curl xml response in to json format
	protected function _parseResponse(){  
	    $xml=simplexml_load_string($this->response) or die("Error: Cannot create object");
	    $this->response = json_encode($xml);
	}
}