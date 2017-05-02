<?php

define('ROOT',$_SERVER['DOCUMENT_ROOT']);
require(ROOT.'\wp-load.php');

$input = "дизельные генераторы";

$url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20170502T013301Z.2d3aaf1c1b3bcb09.40add3fea3a66daf108b94a88e00aa8edc99cc8b&text=$input&lang=ru-en";

$response = wp_remote_get( $url )

?>
<pre>
<?php print_r( json_decode($response['body'])->text[0]); ?>
</pre>
