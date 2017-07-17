<?php

$f_pos = Session::get('feedback_positive');
$f_neg = Session::get('feedback_negative');
$f_neu = Session::get('feedback_info');
$f_war = Session::get('feedback_warning');

if(isset($f_neu)) {
	foreach($f_neu as $f) {
		if(is_array($f)) {
			Alert::info($f[0], $f[1], $f[2], $f[3], $f[4]);
		} else {
			Alert::info($f);
		}
	}
}

if(isset($f_war)) {
	foreach($f_war as $f) {
		if(is_array($f)) {
			Alert::warning($f[0], $f[1], $f[2], $f[3], $f[4]);
		} else {
			Alert::warning($f);
		}
	}
}

if(isset($f_pos)) {
	foreach($f_pos as $f) {
		if(is_array($f)) {
			Alert::success($f[0], $f[1], $f[2], $f[3], $f[4]);
		} else {
			Alert::success($f);
		}
	}
}

if(isset($f_neg)) {
	foreach($f_neg as $f) {
		if(is_array($f)) {
			Alert::error($f[0], $f[1], $f[2], $f[3], $f[4]);
		} else {
			Alert::error($f);
		}
	}
}

?>