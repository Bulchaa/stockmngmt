<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Geezsms
{
	private $CI;
	private $api_token;
	private $shortcode_id;
	private $api_url = 'https://api.geezsms.com/api/v1/sms/send';
	private $enabled = false;

	public $last_response = false;

	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// Reads settings from config (geezsms.php) - can be overridden
		// dynamically at runtime via $this->config->set_item()
		$this->enabled = false;
	}

	private function refresh_settings()
	{
		$enabled = $this->CI->config->item('geezsms_enabled');
		$this->enabled = ($enabled == '1' || $enabled === true || $enabled === 1) ? true : false;

		$this->api_token = $this->CI->config->item('geezsms_token');
		$this->shortcode_id = $this->CI->config->item('geezsms_shortcode');
		$this->api_url = $this->CI->config->item('geezsms_api_url');
		if(empty($this->api_url)) {
			$this->api_url = 'https://api.geezsms.com/api/v1/sms/send';
		}
	}

	/*
	* Sends an SMS message to a phone number.
	* $phone must be in Ethiopian international format (e.g. 251911234567).
	* Returns true on success, false on failure.
	*/
	public function send($phone, $message)
	{
		$this->refresh_settings();

		if($this->enabled != true) {
			return false;
		}

		if(empty($this->api_token)) {
			return false;
		}

		$phone = $this->normalize_phone($phone);
		if(empty($phone)) {
			return false;
		}

		$post_fields = array(
			'token' => $this->api_token,
			'phone' => $phone,
			'msg'   => substr($message, 0, 334)
		);

		if(!empty($this->shortcode_id)) {
			$post_fields['shortcode_id'] = $this->shortcode_id;
		}

		$response = $this->post_to_api($post_fields);

		if(isset($response['message_status']) && $response['message_status'] == 'success') {
			return true;
		}

		return false;
	}

	/*
	* Converts a phone number into Ethiopian international format (2519...).
	* Accepts formats like 0911223344, 0111223344, 2519111223344 or +2519111223344.
	*/
	public function normalize_phone($phone)
	{
		$phone = trim($phone);

		if(empty($phone)) {
			return false;
		}

		$phone = preg_replace('/[^0-9+]/', '', $phone);

		if(strpos($phone, '+') === 0) {
			$phone = substr($phone, 1);
		}

		if(strlen($phone) == 12 && substr($phone, 0, 3) == '251') {
			// already in international format
			return $phone;
		}

		if(strlen($phone) == 10 && substr($phone, 0, 1) == '9') {
			return '251' . $phone;
		}

		if(strlen($phone) == 9 && substr($phone, 0, 1) == '9') {
			return '2519' . substr($phone, 1);
		}

		return false;
	}

	private function post_to_api($post_fields)
	{
		$response = false;
		$result = false;

		if(function_exists('curl_init')) {
			$ch = curl_init($this->api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		else {
			$context = stream_context_create(array(
				'http' => array(
					'method' => 'POST',
					'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
					'content' => http_build_query($post_fields),
					'timeout' => 30
				)
			));
			$result = file_get_contents($this->api_url, false, $context);
		}

		if($result) {
			$decoded = json_decode($result, true);
			if(is_array($decoded)) {
				$response = $decoded;
			}
			else {
				$response = array('raw' => $result);
			}
		}

		$this->last_response = $response;

		return $response;
	}
}