<?php
include_once("./_common.php");

if(TB_IS_MOBILE) {
	goto_url(TB_MBBS_URL.'/seller_reg_from.php');
}

if(!$config['seller_reg_yes']) {
	alert('서비스가 일시 중단 되었습니다.', TB_URL);
}

if(is_seller($member['id'])) {
	goto_url(TB_MYPAGE_URL.'/page.php?code=seller_main');
}

$tb['title'] = '온라인 입점 신청';
include_once("./_head.php");

if($seller['mb_id'] && !$seller['state']) {
	include_once(TB_THEME_PATH.'/seller_reg_result.skin.php');
} else {
	$token = md5(uniqid(rand(), true));
	set_session("ss_token", $token);

	$config['seller_reg_agree'] = preg_replace("/\\\/", "", $config['seller_reg_agree']);

	$from_action_url = TB_HTTPS_BBS_URL.'/seller_reg_from_update.php';
	include_once(TB_THEME_PATH.'/seller_reg_from.skin.php');
}

include_once("./_tail.php");
?>
