<?php
/**
 * Created by PhpStorm.
 * User: kevin.price-ward
 * Date: 26/07/2018
 * Time: 16:34
 */

namespace LinimexAddressLookup\Utils;


class enqueuing {
	protected static $root_file;
	public function __construct($file)
	{
		self::$root_file = $file;
		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
	}
	public function enqueue(){
		wp_enqueue_script( 'lmx_front_script', plugin_dir_url(self::$root_file) . 'scripts/lmx-front.js', ['jquery'], null, true );
		wp_localize_script( 'lmx_front_script', 'the_ajax_script', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' =>  wp_create_nonce('my_nonce')
		) );
	}
}