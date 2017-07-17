<?php
/**
 * button-class
 * Used to create a Bootstrap-Button.
 *
 * @category	Style
 * @package		button
 * @author		Lucas Schäf <lucas.schaef@gmail.com>
 * @copyright	Copyright (c) 2014
 * @licence		http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version		0.1 (beta)
 **/
class button {
	/**
	 * write
	 * Method to return the HTML of a Bootstrap-Button
	 *
	 * @param string $link		The URL of the page that the button should refer to.
	 * @param string $text		Text within the button.
	 * @param string $vlass		This should be a Bootstrap-Button-class
	 * @param string $fa		The name of a Font-Awesome icon, which will be added to the button
	 * @param boolean $disabled	If true, the button will not be clickable and look disabled.
	 *
	 * @return string			Returns the HTML of a button
	 **/
	public static function write($link, $text, $class = "btn btn-default", $fa = "external-link-sqaure", $disabled = false) {
		return '<a href="'.$link.'" class="'.$class.($disabled ? ' disabled' : '').'" role="button"><i class="fa fa-'.$fa.'"></i> '.$text.'</a>';
	}
}