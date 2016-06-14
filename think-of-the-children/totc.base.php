<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of totcbase
 *
 * @author Greg
 */
class totcbase {

	//All the default settings that are used when none are stored in wp_options
	public static $defaultSettings = array(
		"totc-version" => "0.2.0",
	);

	/**
	 * Kind of an abstracted get_option, using the defaults above
	 */
	public static function setting( $key = '' )
	{
		return get_option($key,totcbase::$defaultSettings[$key]);
	}
}
?>
