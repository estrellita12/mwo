<?php
if(!defined('_TUBEWEB_')) exit; // 개별 페이지 접근 불가

if($default['de_card_test']) {
	$merchantID  = 'nicepay00m';
	$merchantKey = 'EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg==';
	$merchantPwd = '123456';
} else {
	$merchantID  = $default['de_nicepay_mid'];
	$merchantKey = $default['de_nicepay_key'];
	$merchantPwd = $default['de_nicepay_pwd'];
}

$g_conf_home_dir = TB_SHOP_PATH.'/nicepay';
$ReturnURL = TB_MSHOP_URL.'/nicepay/nicepay_result.php';
?>