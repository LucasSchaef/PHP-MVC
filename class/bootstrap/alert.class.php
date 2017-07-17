<?php
/**
 * Alert Class
 * Used to create Bootstrap-Alerts (See http://getbootstrap.com/components/#alerts for details)
 *
 * @category	Style
 * @package 	Alert
 * @author		Lucas Schäf <lucas.schaef@gmail.com>
 * @copyright	Copytight (c) 2014
 * @licence		http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version		0.1 (beta)
 */
class Alert {
	/**
	 * writeAlert
	 * Method to echo the HTML
	 *
	 * @param string $text 	The text to be displayed inside the alert
	 * @param string $shout	Somewhat of a alert-heading. However, it is only displayed bold at the beginning of the alert
	 * @param string $type	Usually one of the four Bootstrap-Alerts ("danger", "success", "info" or "warning"). This is not checked, so you can  easily add own alert types.
	 * @param string $fa	An icon name from Font-Awesome, that will be displayed at the beginning of an alert.
	 **/
	public static function writeAlert($text, $shout, $type, $fa = NULL, $dissmissable = true) {
		echo '<div class="alert alert-'.$type.(($dissmissable) ? ' alert-dissmissable' : '').'" role="alert">';
		if($dissmissable)
			echo '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>';
		// If $fa is not null, add an icon from font-awesome.
		if(!is_null($fa)) {
			echo '<i class="fa fa-'.$fa.'"></i> ';
		}
		echo '<strong>'.$shout.'</strong> '.$text.'</div>';
	}
	
	/**
	 * error
	 * Method to create and write an alert of the type "danger"
	 *
	 * @uses Alert::writeAlert()
	 *
	 * @param string $text	The text to be displayed inside the alert
	 * @param string $shout	Somewhat of a alert-heading. However, it is only displayed bold at the beginning of the alert
	 * @param string $type	Usually one of the four Bootstrap-Alerts ("danger", "success", "info" or "warning"). This is not checked, so you can  easily add own alert types.
	 * @param string $fa	An icon name from Font-Awesome, that will be displayed at the beginning of an alert.
	 **/
	public static function error($text, $shout = 'Error!', $type = 'danger', $fa = 'times', $dm = true) {
		self::writeAlert($text, $shout, $type, $fa, $dm);
	}
	
	/**
	 * warning
	 * Method to create and write an alert of the type "warning"
	 *
	 * @uses Alert::writeAlert()
	 *
	 * @param string $text	The text to be displayed inside the alert
	 * @param string $shout	Somewhat of a alert-heading. However, it is only displayed bold at the beginning of the alert
	 * @param string $type	Usually one of the four Bootstrap-Alerts ("danger", "success", "info" or "warning"). This is not checked, so you can  easily add own alert types.
	 * @param string $fa	An icon name from Font-Awesome, that will be displayed at the beginning of an alert.
	 **/
	public static function warning($text, $shout = 'Warning!', $type = 'warning', $fa = 'exclamation-triangle', $dm = true) {
		self::writeAlert($text, $shout, $type, $fa, $dm);
	}
	
	/**
	 * success
	 * Method to create and write an alert of the type "success"
	 *
	 * @uses Alert::writeAlert()
	 *
	 * @param string $text	The text to be displayed inside the alert
	 * @param string $shout	Somewhat of a alert-heading. However, it is only displayed bold at the beginning of the alert
	 * @param string $type	Usually one of the four Bootstrap-Alerts ("danger", "success", "info" or "warning"). This is not checked, so you can  easily add own alert types.
	 * @param string $fa	An icon name from Font-Awesome, that will be displayed at the beginning of an alert.
	 **/
	public static function success($text, $shout = 'Success!', $type = 'success', $fa = 'check', $dm = true) {
		self::writeAlert($text, $shout, $type, $fa, $dm);
	}
	
	/**
	 * info
	 * Method to create and write an alert of the type "info"
	 *
	 * @uses Alert::writeAlert()
	 *
	 * @param string $text	The text to be displayed inside the alert
	 * @param string $shout	Somewhat of a alert-heading. However, it is only displayed bold at the beginning of the alert
	 * @param string $type	Usually one of the four Bootstrap-Alerts ("danger", "success", "info" or "warning"). This is not checked, so you can  easily add own alert types.
	 * @param string $fa	An icon name from Font-Awesome, that will be displayed at the beginning of an alert.
	 **/
	public static function info($text, $shout = 'Note:', $type = 'info', $fa = 'info', $dm = true) {
		self::writeAlert($text, $shout, $type, $fa, $dm);
	}	
}