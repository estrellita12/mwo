<?php
include_once("./_common.php");

if(TB_IS_MOBILE) {
	goto_url(TB_MBBS_URL.'/seller_reg.php');
}

if(!$config['seller_reg_yes']) {
	alert('서비스가 일시 중단 되었습니다.', TB_URL);
}

$tb['title'] = '온라인 입점 신청';
include_once("./_head.php");
include_once(TB_THEME_PATH.'/seller_reg.skin.php');
include_once("./_tail.php");
?>
