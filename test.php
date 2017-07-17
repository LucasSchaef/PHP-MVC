<?php
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
	}
	
	// Now we glue the ID sections togehter:
	$id = implode('-', $id);
	
	// It still is possible, that the ID is too long or too short. So we check that here and edit the last section:
	if(strlen($id)<$length) {
		if(function_exists("openssl_random_pseudo_bytes")) {
			$data = openssl_random_pseudo_bytes($length);	
		} else {
			$data = mcrypt_create_iv($length);	
		}
		
		// Select "random" algorithm
		$algos = hash_algos();
		$algo = $algos[mt_rand(0, (count($algos)-1))];
		
		$size = $length-strlen($id);
		
		if($size > 1) {
			$size--;
		}
		
		$add = substr(hash($algo, $data),0,$size);
		
		if($size > 1) {
			$add = "-".$add;
		}
		
		$id = $id.$add;
	} elseif(strlen($id)>$length) {
		$id = substr($id, 0, $length);
	}
	
	return $id; 
}

echo createID(30, 2).'<br />';
echo strlen(createID(30,2));
?>