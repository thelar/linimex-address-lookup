<?php
/**
 * Created by PhpStorm.
 * User: kevin.price-ward
 * Date: 26/07/2018
 * Time: 16:43
 */

namespace LinimexAddressLookup\Utils;

class init {
	public $ajax;

	public function init($file){
		$enq = new enqueuing($file);
		$short = new shortcode();
		$ajax = new ajax();
	}
}