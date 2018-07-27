<?php
/**
 * Created by PhpStorm.
 * User: kevin.price-ward
 * Date: 27/07/2018
 * Time: 10:51
 */

namespace LinimexAddressLookup\Utils;


use LinimexAddressLookup\Colt;

class ajax {
	private static $token;

	public function __construct()
	{
		add_action('wp_ajax_address_lookup', [$this, 'address_lookup']);
		add_action('wp_ajax_nopriv_address_lookup', [$this, 'address_lookup']);
	}
	public function address_lookup()
	{
		//Get inputs
		$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
		$street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
		$postcode = filter_var($_POST['postcode'], FILTER_SANITIZE_STRING);

		//Attempt to connect
		if(!isset(self::$token)){
			$connection = new Colt\connect();
			self::$token = $connection::get_token();
		}

		if(self::$token !== false){
			$lookup = new Colt\lookup(self::$token, [
				'city' => $city,
				'street_name' => $street,
				'post_code' => $postcode,
				'country' => 'united kingdom'
			]);
			$locations = $lookup::get_locations();

			$response_a = [
				'found' => count($locations),
				'locations' => $locations,
				'status' => 'OK',
				'token' => self::$token
			];
		}else{
			$response_a = [
				'status' => 'error',
				'message' => 'token was not retrieved'
			];
		}

		echo json_encode($response_a);

		die();
	}
	public function get_token()
	{
		return self::$token;
	}
}