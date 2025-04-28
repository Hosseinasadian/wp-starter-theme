<?php
namespace ALMA\SMS\Drivers;

use ALMA\SMS\SMSGatewayInterface;

class FarazSMS implements SMSGatewayInterface{
    protected $username;

	protected $password;

    public function __construct($username,$password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	public function sendSMS($recipient, $message,$from='', $options = []){
		if(!$from){
			$from = get_option('farazsms_sender_number','');
		}
		if(!$from){
			throw new \Exception("FarazSMS Gateway Didn't Configure correctly!");
		}
		$this->send($recipient,$from,$message);
	}

    protected function send($to,$from,$text){
        $url = "https://ippanel.com/services.jspd";

		$rcpt_nm = array($to);
		$param = [
			'uname'=>$this->username,
			'pass'=>$this->password,
			'from'=>$from,
			'message'=>$text,
			'to'=>json_encode($rcpt_nm),
			'op'=>'send'
		];

		$handler = curl_init($url);
		curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handler);

		$curl_errno   = curl_errno($handler);

		$curl_error   = curl_error($handler);

		if ($curl_errno) {

			throw new \Exception($curl_error);

		}

        curl_close($handler);

		$decode_response = json_decode($response);
		$res_code = $decode_response[0];

		if($res_code != "0"){
			throw new \Exception('Sms Send Failed! code: ' . $res_code);
		}
    }

	public function sendPatterns($to,$pattern_code,$input_data,$from=''){
        $username = $this->username;
        $password = $this->password;

		if(!$from){
			$from = get_option('farazsms_sender_number','');
		}
		if(!$from){
			throw new \Exception("FarazSMS Gateway Didn't Configure correctly!");
		}

        $to = array($to);
        $url = "https://ippanel.com/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pattern_code";

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($handler);

        $code         = curl_getinfo($handler, CURLINFO_HTTP_CODE);

		$curl_errno   = curl_errno($handler);

		$curl_error   = curl_error($handler);

		if ($curl_errno) {

			throw new \Exception($curl_error);

		}

        curl_close($handler);

        return $response;
    }
}
