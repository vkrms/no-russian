<?php
/*
Plugin Name: No Russian
Plugin URI:
Description: Removes non-roman chars from slugs because translit sucks.
Version: 1.1
Author: vkrms
Author URI: vkrms.github.com
*/

function no_russian($title) {
	$str = preg_replace('/[^\00-\255]+/u', '', $title);
	return $str;
}
add_filter('sanitize_title','no_russian',9);

?>
