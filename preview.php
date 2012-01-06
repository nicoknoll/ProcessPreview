<?php

include './index.php'; // add "./" before index.php to ensure it's not picking up another from PHP's path

if(!wire('user')->isLoggedin()) throw new Wire404Exception(); 

$page = wire('pages')->get((int) $_GET['id']); // typecast to (int)
 
if(!$page || !$page->id) throw new Wire404Exception(); // check that it exists
if(!$page->editable()) throw new WirePermissionException("You don't have access to edit that page"); // check for edit permission 

foreach(wire('input')->get as $key => $value) { // change from $_GET to wire('input')->get
    $key = wire('sanitizer')->name($key); 
    
    if(!isset($key)) continue; // skip over invalid field name

    if(!$page->fields->getField($key)) continue; // skip over field that this page doesn't have
    $page->setFieldValue($key, $value, false); // add the extra 'false' for optimization: prevents PW from loading previous value
}

echo $page->setOutputFormatting(true)->render();

?>