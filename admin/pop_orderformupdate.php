<?php
include_once("./_common.php");

check_demo();

check_admin_token();

// 입금계좌
if($_POST['mod_type'] == 'receipt') {
	unset($value);
	$value['bank']			= $_POST['bank'];
	$value['pt_id']			= $_POST['pt_id'];
	$value['deposit_name']	= $_POST['deposit_name'];
	$value['baesong_price2']	= $_POST['baesong2'];
	$value['cancel_price']	= $_POST['cancel'];

    //2023-01-18 금액변경 추가
    if(!empty($_POST['changePrice'] && is_numeric($_POST['changePrice']))){
        $value['goods_price']	= $_POST['changePrice'];
        $value['supply_price']	= $_POST['changePrice'];
        $value['use_price']	= $_POST['changePrice'];
    }

	update("shop_order", $value, "where od_id='$od_id'");
}

// 관리자메모
if($_POST['mod_type'] == 'memo') {
	unset($value);
	$value['shop_memo']		= $_POST['shop_memo'];
	update("shop_order", $value, "where od_id='$od_id'");
}

// 주문자/배송지 정보
if($_POST['mod_type'] == 'info') {
	unset($value);
	$value['name']			= $_POST['name'];
	$value['telephone']		= $_POST['telephone'];
	$value['cellphone']		= $_POST['cellphone'];
	$value['zip']			= $_POST['zip'];
	$value['addr1']			= $_POST['addr1'];
	$value['addr2']			= $_POST['addr2'];
	$value['addr3']			= $_POST['addr3'];
	$value['addr_jibeon']	= $_POST['addr_jibeon'];
	$value['email']			= $_POST['email'];
	$value['b_name']		= $_POST['b_name'];
	$value['b_telephone']	= $_POST['b_telephone'];
	$value['b_cellphone']	= $_POST['b_cellphone'];
	$value['b_zip']			= $_POST['b_zip'];
	$value['b_addr1']		= $_POST['b_addr1'];
	$value['b_addr2']		= $_POST['b_addr2'];
	$value['b_addr3']		= $_POST['b_addr3'];
	$value['b_addr_jibeon']	= $_POST['b_addr_jibeon'];
	update("shop_order", $value, "where od_id='$od_id'");
}

goto_url(TB_ADMIN_URL."/pop_orderform.php?od_id=$od_id");
?>
