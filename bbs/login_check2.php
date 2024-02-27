<?php
define('_PURENESS_', true);
include_once("./_common.php");

$mb_id = strtolower(trim($_POST['mb_id']));
$mb_password = trim($_POST['mb_password']);

if(!$mb_id || !$mb_password)
    alert('회원아이디나 비밀번호가 공백이면 안됩니다.');

$mb = get_member($mb_id);

// 가입된 회원이 아니다. 패스워드가 틀리다. 라는 메세지를 따로 보여주지 않는 이유는
// 회원아이디를 입력해 보고 맞으면 또 패스워드를 입력해보는 경우를 방지하기 위해서입니다.
// 불법사용자의 경우 회원아이디가 틀린지, 패스워드가 틀린지를 알기까지는 많은 시간이 소요되기 때문입니다.
if(!$mb['id'] || !check_password($mb_password, $mb['passwd'])) {
    alert('가입된 회원아이디가 아니거나 비밀번호가 틀립니다.\\n비밀번호는 대소문자를 구분합니다.');
}

// 차단된 아이디인가?
if($mb['intercept_date'] && $mb['intercept_date'] <= date("Ymd", TB_SERVER_TIME)) {
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb['intercept_date']);
    alert('회원님의 아이디는 접근이 금지되어 있습니다.\\n처리일 : '.$date);
}

// 승인된 공급사인가?
if(!is_seller($mb['id'])) {
	alert("승인 된 공급사만 로그인 가능합니다.");
}

// 회원아이디 세션 생성
set_session('ss_mb_id', $mb['id']);

// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb['reg_time'] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));

// 포인트 체크
$sum_point = get_point_sum($mb['id']);

$sql= " update shop_member set point = '$sum_point' where id = '{$mb['id']}' ";
sql_query($sql);

goto_url(TB_MYPAGE_URL.'/page.php?code=seller_main');
?>