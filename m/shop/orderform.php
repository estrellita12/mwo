<?php
include_once("./_common.php");

$ss_cart_id = get_session('ss_cart_id');
if(!$ss_cart_id)
	alert("주문하실 상품이 없습니다.");

set_session('tot_price', '');
set_session('use_point', '');

// 새로운 주문번호 생성
$od_id = get_uniqid();
set_session('ss_order_id', $od_id);

$tb['title'] = '주문서작성';
include_once("./_head.php");

if(!$is_member)
	$member['point'] = 0;

// 가맹점 판매수수료 적립 대상
$mb_recommend = set_item_commission_id($pt_id);

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(TB_POSTCODE_JS, 0);    //다음 주소 js

$order_action_url = TB_HTTPS_MSHOP_URL.'/orderformupdate.php';
include_once(TB_MTHEME_PATH."/orderform.skin.php");

include_once("./_tail.php");
?>