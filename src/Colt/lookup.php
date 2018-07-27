<?php
/**
 * Created by PhpStorm.
 * User: kevin.price-ward
 * Date: 27/07/2018
 * Time: 12:03
 */

namespace LinimexAddressLookup\Colt;


class lookup {
	private static $api_url = 'https://demo.ondemand.colt.net/api/';
	public static $locations;


	public function __construct($token, $params)
	{
		$ch = curl_init();
		$parameters = http_build_query($params);
		$url = self::$api_url . 'global_directory?' . $parameters;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('auth-token: ' . $token));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$urlResponse = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($urlResponse);
		self::$locations = $response;
	}

	public static function get_locations()
	{
		return self::$locations;
	}
}