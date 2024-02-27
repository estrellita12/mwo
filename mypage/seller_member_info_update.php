<?php
include_once("./_common.php");

check_demo();
check_admin_token();

unset($value);
$value['passwd']            = $_POST['mb_password']; //비밀번호
update("shop_member",$value,"where id='$member[id]'");

//goto_url(TB_MYPAGE_URL.'/page.php?code=seller_member_info');
alert("비밀번호가 변경되었습니다.",TB_MYPAGE_URL.'/page.php?code=seller_member_info');
?>

