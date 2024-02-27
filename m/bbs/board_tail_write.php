<?php
include_once("./_common.php");

check_demo();

if($_POST["token"] && get_session("ss_token") == $_POST["token"]) {
	// 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
	set_session("ss_token", "");
} else {
	alert("잘못된 접근 입니다.");
	exit;
}

$_POST = array_map('trim', $_POST);

if(substr_count($_POST['memo'], "&#") > 50) {
    alert("내용에 올바르지 않은 코드가 다수 포함되어 있습니다.");
    exit;
}

if(!$_POST['writer_s']) { alert("작성자명은 필수 입니다."); }

if($is_member)
	$writer = $member['index_no'];
else
	$writer = 0;

if($_POST['mode'] == 'w') {
	$sql = " insert into shop_board_{$boardid}_tail
				set board_index = '$index_no',
					writer      = '$writer',
					writer_s    = '$writer_s',
					memo        = '$memo',
					wdate       = '".TB_SERVER_TIME."',
					wip         = '{$_SERVER['REMOTE_ADDR']}',
					passwd      = '$passwd' ";
	sql_query($sql);

	sql_query("update shop_board_{$boardid} set tailcount=tailcount + 1 where index_no='$index_no'");
}

goto_url(TB_MBBS_URL."/board_read.php?index_no=$index_no&boardid=$boardid$qstr&page=$page");
?>