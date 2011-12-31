<?php

include 'index.php';

if(wire('user')->isLoggedin()) {
	$return = wire('pages')->get($_GET['id']);
	
	foreach($_GET as $key => $value) {
		$return->setFieldValue($key, $value);
	}
	
	echo $return->setOutputFormatting(true)->render();
}

?>