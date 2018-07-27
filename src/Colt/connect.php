<?php
/**
 * Created by PhpStorm.
 * User: kevin.price-ward
 * Date: 27/07/2018
 * Time: 10:55
 */

namespace LinimexAddressLookup\Colt;


class connect {
	private static $api_url = 'https://demo.ondemand.colt.net/api/';
	private static $email = 'neil.lonergan@coltpartner.net';
	private static $pass = 'Neil2017';

	public static $token;

	public function __construct()
	{
		self::$token = $this->connect();
		return true;
	}

	private function connect()
	{
		$fields = [
			'email' => self::$email,
			'password' => self::$pass
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::$api_url . 'login');
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$urlResponse = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($urlResponse);
		if(isset($response->token)){
			return $response->token;
		}

		return false;
	}

	public static function get_token()
	{
		return self::$token;
	}
}