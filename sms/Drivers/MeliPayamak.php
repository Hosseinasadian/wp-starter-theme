<?php
namespace ALMA\SMS\Drivers;

use ALMA\SMS\SMSGatewayInterface;

class MeliPayamak implements SMSGatewayInterface{
    const PATH = "https://rest.payamak-panel.com/api/SendSMS/%s";

    protected $username;

	protected $password;


	public function __construct($username,$password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	public function sendSMS($recipient, $message,$from='', $options = []){
		if(!$from){
			$from = get_option('melipayamak_sender_number','');
		}
		if(!$from){
			throw new \Exception("MeliPayamak Gateway Didn't Configure correctly!");
		}
		$this->send($recipient,$from,$message);
	}

    protected function getPath($path,$method)
	{
		return sprintf($path, $method);
	}

    protected function execute($url, $data = null){
		$fields_string = "";

		if (!is_null($data)) {

			$fields_string = http_build_query($data);

		}

		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);

		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($handle, CURLOPT_POST, true);

		curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);


		$response     = curl_exec($handle);

		$code         = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		$curl_errno   = curl_errno($handle);

		$curl_error   = curl_error($handle);

		if ($curl_errno) {

			throw new \Exception($curl_error);

		}

		curl_close($handle);

		return $response;
    }

    protected function send($to,$from,$text,$isFlash=false)
	{

		$url = $this->getPath(self::PATH,'SendSMS');

		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'to' => $to,
		'from' => $from,
		'text' => $text,
		'isflash' => $isFlash
		];

		return $this->execute($url,$data);

	}

	public function sendByBaseNumber($text,$to,$bodyId)
	{

		$url = $this->getPath(self::PATH,'BaseServiceNumber');

		$data = [
		'username' => $this->username,
		'password' => $this->password,
		'text' => implode(';',$text),
		'to' => $to,
		'bodyId' => $bodyId
		];

		return $this->execute($url,$data);
	}
}
