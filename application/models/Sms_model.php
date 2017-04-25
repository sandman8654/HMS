<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	function send_sms($message = '' , $reciever_phone = '') {
		echo 'in sms model';
		exit();

		//$to = "[\"<$reciever_phone>\"]";
		/*$to = $reciever_phone;
		$text = $message;
		$authToken = "ZaD9vMp5S3imW39pM77PEg==";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://api.clickatell.com/rest/message");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\":\"$text\",\"to\":$to}");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"X-Version: 1",
			"Content-Type: application/json",
			"Accept: application/json",
			"Authorization: Bearer $authToken"
		));

		$result = curl_exec ($ch);

		echo $result;*/
	}
} 