<?php
/**
 * Created by PhpStorm.
 * User: kevin.price-ward
 * Date: 26/07/2018
 * Time: 16:20
 */

namespace LinimexAddressLookup\Utils;

class shortcode {
    public function __construct()
    {
        add_shortcode('lmx-lookup', [$this, 'add_shortcode']);
    }

    /**
     * @param $attr
     *
     * @return string
     */
    public function add_shortcode($attr){
        $form_html = '
		<div class="d-flex flex-row justify-content-between">
			<div class="text">
				<h2 class="block-title">Can I get XFibre?</h2>
				<h3 class="block-sub-title">Enter your address below</h3>
			</div>
			<div class="icon ml-2 ml-lg-4"></div>
		</div>
		
		<form id="lmx-address-lookup">
			<div class="form-group mt-4">
				<input id="autocomplete" class="form-control" type="text" value="" placeholder="Start typing your address"/>
			</div>
			<button type="submit" class="btn btn-primary"><div class="d-none" id="lmx-address-lookup-loader"><i class="fas fa-spinner fa-pulse loader"></i></div> Submit</button>
		</form>';
        return $form_html;
    }
}