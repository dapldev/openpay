<?php
namespace App\Http\Controllers\lib\Openpay\Exception;
/**
 * Class ErrorHandler
 *
 * this class is using for error handeling of openpay
 *
 * @package OpenPay\Exception
 */
class ErrorHandler
{
	public function _checkstatus($error_code) {
		if($error_code == 0) {
			return 'Successful';
		}
		elseif($error_code == 12700) {
			return 'Retailer identity key supplied not valid';
		}
		elseif($error_code == 12701) {
			return 'Retailer is not Active';
		}
		elseif($error_code == 12702) {
			return 'Retailer location is not Active';
		}
		elseif($error_code == 12703) {
			return 'Retailer location origin not Active';
		}
		elseif($error_code == 12704) {
			return 'Plan ID supplied does not exist';
		}
		elseif($error_code == 12705) {
			return 'Plan ID supplied is not owned by this Retailer';
		}
		elseif($error_code == 12706) {
			return 'Plan ID supplied is not owned by this Retailer';
		}
		elseif($error_code == 12707) {
			return 'Plan ID supplied is not owned by this Retailer';
		}
		elseif($error_code == 12708) {
			return 'Invalid Purchase Price (<0, Not Numeric or outside of Min/Max Purchase Price range)';
		}
		elseif($error_code == 12709) {
			return 'New Purchase Price is greater than current Purchase Price';
		}
		elseif($error_code == 127010) {
			return 'New Purchase Price is less than or equal to zero';
		}
		elseif($error_code == 127011) {
			return 'Plan must be Active for this feature to apply';
		}
		elseif($error_code == 127012) {
			return 'Plan ID does not support dispatch message';
		}
		elseif($error_code == 127013) {
			return 'Plan ID has already been dispatched';
		}
		elseif($error_code == 12711) {
			return 'Invalid Web Sales Plan Status For Partial Refund';
		}
	}
}