<?php
/**
 * Function to create a unique ID.
 * Note: This may be a little bit over the top, but it works fine and is secure.
 */
function uniqueID($length = 29, $chars_per_section = 5, $checkUnique = false, Database $db = NULL, $table = NULL) {
	// Minimum requireies are set here (Min. id-size of 20 chars, max of 255 chars)
	if($length > 255) {
		$length = 255;
	} elseif($length < 20) {
		$length = 20;	
	}
	
	if($chars_per_section > $length) {
		$chars_per_section = 5;
	}
	
	$sections = $length / $chars_per_section;
	$last = $length % $chars_per_section;
	
	
}

function createID($length, $chars_per_section) {
	// First we calculate the number of sections
	$sections = $length / $chars_per_section;
	// .. and now, how long the last part is
	$last = $length % $chars_per_section;
	
	for($i=0;$i<$sections;$i++) {
		// Create random data
		if(function_exists("openssl_random_pseudo_bytes")) {
			$data = openssl_random_pseudo_bytes($length);	
		} else {
			$data = mcrypt_create_iv($length);	
		}
		
		// Select "random" algorithm
		$algos = hash_algos();
		$algo = $algos[mt_rand(0, (count($algos)-1))];
		
		// Create ID-Section
		$id[] = substr(hash($algo, $data), 0, $chars_per_section);
	}
	
	// So, if the $last is zero, we don't need the last element of the array, but just a single additional character
	if($last == 0) {
		array_pop($id);
		
		if(function_exists("openssl_random_pseudo_bytes")) {
			$data = openssl_random_pseudo_bytes($length);	
		} else {
			$data = mcrypt_create_iv($length);	
		}
		
		// Select "random" algorithm
		$algos = hash_algos();
		$algo = $algos[mt_rand(0, (count($algos)-1))];
		
		// Create ID-Section
		$add = substr(hash($algo, $data), 0, 1);
	}
	
	// Now we glue the ID sections togehter:
	$id = implode('-', $id).((isset($add)) ? $add : '');
	return $id; 
}
?>