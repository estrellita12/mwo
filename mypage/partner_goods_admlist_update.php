<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if($_POST['act_button'] == "선택상품감춤")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$gs = get_goods($_POST['gs_id'][$k], 'use_hide');

		$res_mb_id = set_items_array_add($gs['use_hide'], $member['id']);

		$sql = " update shop_goods set use_hide = '$res_mb_id' where index_no = '{$_POST['gs_id'][$k]}'";
		sql_query($sql);
	}
}
else if($_POST['act_button'] == "선택상품노출")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$gs = get_goods($_POST['gs_id'][$k], 'use_hide');

		$res_mb_id = set_items_array_del($gs['use_hide'], $member['id']);

		$sql = " update shop_goods set use_hide = '$res_mb_id' where index_no = '{$_POST['gs_id'][$k]}'";
		sql_query($sql);
	}
}

goto_url(TB_MYPAGE_URL."/page.php?$q1&page=$page");
?>