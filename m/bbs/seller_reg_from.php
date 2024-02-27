<?php
include_once("./_common.php");

if(!$config['seller_reg_yes']) {
	alert('서비스가 일시 중단 되었습니다.', TB_MURL);
}

if(is_seller($member['id'])) {
	alert('이미 승인 완료된 공급사 입니다.', TB_MURL);
}

$tb['title'] = '온라인 입점신청';
include_once("./_head.php");

add_javascript(TB_POSTCODE_JS, 0); //다음 주소 js

if($seller['mb_id'] && !$seller['state']) {
	include_once(TB_MTHEME_PATH.'/seller_reg_result.skin.php');
} else {
	$token = md5(uniqid(rand(), true));
	set_session("ss_token", $token);

	$config['seller_reg_agree'] = preg_replace("/\\\/", "", $config['seller_reg_agree']);

	$from_action_url = TB_HTTPS_MBBS_URL.'/seller_reg_from_update.php';
	include_once(TB_MTHEME_PATH.'/seller_reg_from.skin.php');
}

include_once("./_tail.php");
?>