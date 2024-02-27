<?php
include_once("./_common.php");

check_demo();

if(!$is_member)
	alert('로그인 후 이용하여 주십시오.');

$index_no  = conv_number($_GET['index_no']);
$tailindex = conv_number($_GET['tailindex']);
$boardid   = conv_number($_GET['boardid']);

if(!$index_no || !$tailindex || !$boardid)
	alert("제대로 된 값이 넘어오지 않았습니다.");

$comment = sql_fetch("select * from shop_board_{$boardid}_tail where index_no='$tailindex'");

if($comment['writer']) {
	if(!is_admin()) {
		if($comment['writer'] != $mb_no) {
			alert('삭제할 권한이 없습니다.');
		}
	}

	sql_query("delete from shop_board_{$boardid}_tail where index_no='$tailindex'");
	sql_query("update shop_board_{$boardid} set tailcount=tailcount-1 where index_no='$index_no'");
}

goto_url(TB_MBBS_URL."/board_read.php?index_no=$index_no&boardid=$boardid$qstr&page=$page");
?>