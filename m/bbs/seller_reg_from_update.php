<?php
include_once("./_common.php");
include_once(TB_LIB_PATH."/mailer.lib.php");

check_demo();

if(!$config['seller_reg_yes']) {
	alert('서비스가 일시 중단 되었습니다.', TB_MURL);
}

if($_POST["token"] && get_session("ss_token") == $_POST["token"]) {
	// 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
	set_session("ss_token", "");
} else {
	alert("잘못된 접근 입니다.");
	exit;
}

if(!$is_member) {
	if(!$_POST['mb_id']) {
		alert('회원아이디가 없습니다. 올바른 방법으로 이용해 주십시오.');
	}

	$sql = " select count(*) as cnt from shop_member where id = '{$_POST['mb_id']}' ";
	$row = sql_fetch($sql);
	if($row['cnt'])
		alert("이미 사용중인 회원아이디 입니다.");

	unset($value);
	$value['id']				= $_POST['mb_id']; //회원아이디
	$value['passwd']			= $_POST['mb_password']; //비밀번호
	$value['name']				= $_POST['company_name']; //회원명
	$value['email']				= $_POST['info_email']; //이메일
	$value['cellphone']			= $_POST['info_tel']; //핸드폰
	$value['telephone']			= $_POST['company_tel']; //전화번호
	$value['zip']				= $_POST['company_zip']; //우편번호
	$value['addr1']				= $_POST['company_addr1']; //주소
	$value['addr2']				= $_POST['company_addr2']; //상세주소
	$value['addr3']				= $_POST['company_addr3']; //참고항목
	$value['addr_jibeon']		= $_POST['company_addr_jibeon']; //지번주소
	$value['gender']			= "M"; //성별
	$value['mailser']			= 'Y'; //E-Mail을 수신
	$value['smsser']			= 'Y'; //SMS를 수신
	$value['pt_id']				= 'admin'; //추천인
	$value['grade']				= '9'; //레벨
	$value['mb_ip']				= $_SERVER['REMOTE_ADDR']; //IP
	$value['login_ip']			= $_SERVER['REMOTE_ADDR']; //최근 로그인IP
	$value['today_login']		= TB_TIME_YMDHIS; //최근 로그인일시
	$value['reg_time']			= TB_TIME_YMDHIS; //가입일
	insert("shop_member", $value);
	$mb_no = sql_insert_id();

	$member = get_member_no($mb_no);

	// 회원아이디 세션 생성
	set_session('ss_mb_id', $member['id']);
}

unset($value);
$value['seller_code']			= code_uniqid();
$value['mb_id']					= $member['id'];
$value['seller_item']			= $_POST['seller_item'];
$value['company_name']			= $_POST['company_name'];
$value['company_saupja_no']		= $_POST['company_saupja_no'];
$value['company_item']			= $_POST['company_item'];
$value['company_service']		= $_POST['company_service'];
$value['company_owner']			= $_POST['company_owner'];
$value['company_tel']			= $_POST['company_tel'];
$value['company_fax']			= $_POST['company_fax'];
$value['company_zip']			= $_POST['company_zip'];
$value['company_addr1']			= $_POST['company_addr1'];
$value['company_addr2']			= $_POST['company_addr2'];
$value['company_addr3']			= $_POST['company_addr3'];
$value['company_addr_jibeon']	= $_POST['company_addr_jibeon'];
$value['company_hompage']		= $_POST['company_hompage'];
$value['info_name']				= $_POST['info_name'];
$value['info_email']			= $_POST['info_email'];
$value['info_tel']				= $_POST['info_tel'];
$value['bank_name']				= $_POST['bank_name'];
$value['bank_account']			= $_POST['bank_account'];
$value['bank_holder']			= $_POST['bank_holder'];
$value['memo']					= $_POST['memo'];
$value['reg_time']				= TB_TIME_YMDHIS;
$value['update_time']			= TB_TIME_YMDHIS;
insert("shop_seller", $value);

$wr_content = conv_content(conv_unescape_nl(stripslashes($_POST['memo'])), 0);
$wr_name = get_text($member['name']);
$subject = '['.$company_name.'] '.$wr_name.'님께서 입점신청을 하셨습니다.';

if($member['email']) {
	ob_start();
	include_once(TB_BBS_PATH.'/seller_reg_from_update_mail.php');
	$content = ob_get_contents();
	ob_end_clean();

	mailer($member['name'], $member['email'], $super['email'], $subject, $content, 1);
}

// 최고 관리자에게 문자전송
icode_direct_sms_send('admin', $super_hp, $subject);

alert('정상적으로 신청 되었습니다.', TB_MBBS_URL.'/seller_reg_from.php');
?>