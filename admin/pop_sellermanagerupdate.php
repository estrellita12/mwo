<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$value['info_name']			  = $_POST['info_name'];
$value['info_tel']			  = $_POST['info_tel'];
$value['info_email']		  = $_POST['info_email'];	
$value['info_nateon']		  = $_POST['info_nateon'];	

$value['info_name2']			  = $_POST['info_name2'];
$value['info_tel2']			  = $_POST['info_tel2'];
$value['info_email2']		  = $_POST['info_email2'];	
$value['info_nateon2']		  = $_POST['info_nateon2'];	

$value['info_name3']			  = $_POST['info_name3'];
$value['info_tel3']			  = $_POST['info_tel3'];
$value['info_email3']		  = $_POST['info_email3'];	
$value['info_nateon3']		  = $_POST['info_nateon3'];	

$value['info_name4']			  = $_POST['info_name4'];
$value['info_tel4']			  = $_POST['info_tel4'];
$value['info_email4']		  = $_POST['info_email4'];	
$value['info_nateon4']		  = $_POST['info_nateon4'];	

$value['update_time']		  = TB_TIME_YMDHIS;
update("shop_seller", $value," where mb_id='$mb_id'");

//unset($value);
//$value['isopen'] = $_POST['seller_open'];
//update("shop_goods", $value," where mb_id='{$_POST['seller_code']}' ");

goto_url(TB_ADMIN_URL.'/pop_sellermanager.php?mb_id='.$mb_id);
?>
