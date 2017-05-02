<?php
/*
Plugin Name: No Russian
Plugin URI: 
Description: Removes non-roman chars from slugs because translit sucks.
Version: 1.1
Author: vkrms
Author URI: vkrms.github.com
*/

add_action('admin_enqueue_scripts','fnr_load_stuff');

function fnr_load_stuff() {

	wp_enqueue_style('fnr-style',plugin_dir_url(__FILE__) . 'no-russian.css');

	wp_enqueue_script('fnr-scripts', plugin_dir_url(__FILE__) . 'no-russian.js',['jquery'],'0.1.0',true);
	//
	// $data = array(
	// 	// 'upload_url'  => admin_url('async-upload.php'), // as in tutorial
	// 	'upload_url'  => plugin_dir_url(__FILE__).'api.php',
	// 	'ajax_url'		=> admin_url('admin-ajax.php'),
	// 	'nonce'				=> wp_create_nonce('media-form')
	// );
	//
	// wp_localize_script('csv-form-js','fcsv_config', $data );
}

add_action('admin_menu','fnr_menu');

function fnr_menu(){
	add_submenu_page('tools.php','No Russian by Flake','Flake\'s No Russian','manage_options','no-russian','fnr_init');
}

function fnr_init(){

	add_option('fnr-api-key', null, null, 'no');

	if($_POST)
		if (update_option('fnr-api-key',$_POST['api-key']))
			echo `
			<div class="updated">
				<p>
					API Key updated!
				</p>
			</div>
			`;

	?>

	<h1>Настройки No Russian</h1>

	<form method="post" class="fnr-form">
		<input type="text" name="api-key" id="fnr-api-input" class="" required placeholder="yandex translate api key" value="<?php echo get_option('fnr-api-key') ?>"/>
		<input type="submit" value="Save"/>
	</form>

	<?php
}

function no_russian($title) {

		$key = get_option('fnr-api-key');

		$url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=$key&text=$title&lang=ru-en";

		$response = wp_remote_get( $url );

		// if ($credit != false) {
		// 	echo "<p>Переведено сервисом <a href='http://translate.yandex.ru/' target='_blank'>«Яндекс.Переводчик»:</a></p>";
		// }

		$rep = str_replace(' ','-',json_decode($response['body'])->text[0]);

		return $rep;

}


add_filter('wp_unique_post_slug','no_russian',9);
add_filter('wp_unique_term_slug','no_russian',9);

// add_filter('sanitize_title','no_russian',9);

// add_action('edit_terms','no_russian_filter');
// function no_russian_filter(){
// }

?>
