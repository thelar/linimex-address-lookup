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
		<h2>Can I get XFibre?</h2>
		<form id="lmx-address-lookup">
			<div class="form-group">
				<label for="city">Town/City *</label>
				<select id="city" class="form-control" required>
					<option value="">-- Select --</option>
					<option value="London">London</option>
					<option value="Birmingham">Birmingham</option>
					<option value="Manchester">Manchester</option>
				</select>
			</div>
			<div class="form-group">
				<label for="street">Street *</label>
				<input id="street" class="form-control" type="text" value="" placeholder="E.g. Curzon Street" required/>
			</div>
			<div class="form-group">
				<label for="postcode">Postcode</label>
				<input id="postcode" class="form-control" type="text" value="" placeholder="E.g. E1 6EG"/>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>';
		return $form_html;
	}
}