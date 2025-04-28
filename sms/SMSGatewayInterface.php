<?php
namespace ALMA\SMS;
interface SMSGatewayInterface{
	public function sendSMS($recipient, $message,$from='', $options = []);
}
