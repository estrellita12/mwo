<?php
if(!defined('_TUBEWEB_')) exit;

$tb['lo_location'] = addslashes("공급사 페이지");
if(!$tb['lo_location'])
    $tb['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$tb['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));

?>

<div class="breadcrumb">
	<span>HOME</span> <i class="ionicons ion-ios-arrow-right"></i>
	<?php echo $pg_navi; ?> <i class="ionicons ion-ios-arrow-right"></i>
	<?php echo $pg_title; ?>
</div>

<div class="s_wrap">
	<h1><?php echo $pg_title; ?></h1>
