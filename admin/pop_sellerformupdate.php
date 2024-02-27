<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$common_dir = TB_DATA_PATH."/common";
$upl = new upload_files($common_dir);

unset($value);

$sl = sql_fetch("select * from shop_seller where mb_id = '$mb_id'");
if($_POST['company_saupja_file_del']) {
    $upl->del($sl['company_saupja_file']);
    $value['company_saupja_file'] = '';
}
if($_POST['company_report_file_del']) {
    $upl->del($sl['company_report_file']);
    $value['company_report_file'] = '';
}
if($_POST['company_bank_file_del']) {
    $upl->del($sl['company_bank_file']);
    $value['company_bank_file'] = '';
}
if($_POST['company_proposal_file_del']) {
    $upl->del($sl['company_proposal_file']);
    $value['company_proposal_file'] = '';
}

if($_FILES['company_saupja_file']['name']) {
    $value['company_saupja_file'] = $upl->upload($_FILES['company_saupja_file']);
}
if($_FILES['company_report_file']['name']) {
    $value['company_report_file'] = $upl->upload($_FILES['company_report_file']);
}
if($_FILES['company_bank_file']['name']) {
    $value['company_bank_file'] = $upl->upload($_FILES['company_bank_file']);
}
if($_FILES['company_proposal_file']['name']) {
    $value['company_proposal_file'] = $upl->upload($_FILES['company_proposal_file']);
}

$value['seller_open']		  = $_POST['seller_open'];
$value['seller_item']		  = $_POST['seller_item'];
$value['company_name']		  = $_POST['company_name'];
$value['company_saupja_no']	  = $_POST['company_saupja_no'];
$value['company_tel']		  = $_POST['company_tel'];
$value['company_fax']		  = $_POST['company_fax'];
$value['company_zip']		  = $_POST['company_zip'];
$value['company_addr1']		  = $_POST['company_addr1'];
$value['company_addr2']		  = $_POST['company_addr2'];
$value['company_addr3']		  = $_POST['company_addr3'];
$value['company_addr_jibeon'] = $_POST['company_addr_jibeon'];
$value['company_service']	  = $_POST['company_service'];
$value['company_item']		  = $_POST['company_item'];
$value['company_owner']		  = $_POST['company_owner'];
$value['company_hompage']	  = $_POST['company_hompage'];
$value['seller_comm']	      = $_POST['seller_comm'];
/*
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
*/
$value['bank_name']			  = $_POST['bank_name'];
$value['bank_account']		  = $_POST['bank_account'];
$value['bank_holder']		  = $_POST['bank_holder'];
$value['memo']				  = $_POST['memo'];
$value['state']				  = $_POST['state'];	
$value['update_time']		  = TB_TIME_YMDHIS;
update("shop_seller", $value," where mb_id='$mb_id'");

if( $_POST['state'] == 1 ){
    sql_query("update shop_seller set state='1', seller_open='1', app_time='".TB_TIME_YMDHIS."' where mb_id='$mb_id'");
    sql_query("update shop_member set supply='Y', use_app='1' where id='$mb_id'");	
}

//unset($value);
//$value['isopen'] = $_POST['seller_open'];
//update("shop_goods", $value," where mb_id='{$_POST['seller_code']}' ");

goto_url(TB_ADMIN_URL.'/pop_sellerform.php?mb_id='.$mb_id);
?>
