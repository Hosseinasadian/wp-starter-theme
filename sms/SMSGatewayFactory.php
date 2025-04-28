<?php
namespace ALMA\SMS;

use ALMA\SMS\Drivers\FarazSMS;
use ALMA\SMS\Drivers\MeliPayamak;

class SMSGatewayFactory {
    public static function create($gatewayType) {
        switch ($gatewayType) {
            case 'farazsms':
				$username = get_option('farazsms_username','');
				$password = get_option('farazsms_password','');
				if(!$username || !$password){
					throw new \Exception("SMS Gateway Didn't Configure correctly!");
				}
                return new FarazSMS($username,$password);
            case 'melipayamak':
				$username = get_option('melipayamak_username','');
				$password = get_option('melipayamak_password','');
				if(!$username || !$password){
					throw new \Exception("SMS Gateway Didn't Configure correctly!");
				}
                return new MeliPayamak($username,$password);
            default:
                throw new \Exception("Invalid SMS Gateway");
        }
    }
}
