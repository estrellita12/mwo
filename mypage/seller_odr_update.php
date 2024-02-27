<?php
include_once("./_common.php");
include_once("../lib/xml.lib.php");

//check_demo();

//check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

// 2022-05-26
$file = "/home/mwo/public_html/log/debug_".TB_TIME_YMD.".txt";
$arr['DATE'] = TB_TIME_YHS;
$arr['VALUE'] = $_POST;
error_log(print_r($arr,true) ,3, $file);


if($_POST['act_button'] == "배송준비")
{
    for($i=0; $i<$count; $i++)
    {
        // 실제 번호를 넘김
        $k     = $_POST['chk'][$i];
        $od_no = $_POST['od_no'][$k];
        
        $od = get_order($od_no);
        if($od['dan'] != 2) continue;
        change_order_status_3($od_no);
    }
}
else if($_POST['act_button'] == "배송중")
{

    for($i=0; $i<$count; $i++)
    {
        // 실제 번호를 넘김
        $k			 = $_POST['chk'][$i];
        $od_no		 = $_POST['od_no'][$k];
        $delivery	 = $_POST['delivery'][$k];
        $delivery_no = $_POST['delivery_no'][$k];

        $od = get_order($od_no);
        if($od['dan'] != 3) continue;

        change_order_status_4($od_no, $delivery, $delivery_no);

        // 2022-02-16
        sb_baesong_update($od_no);

        $od_sms_baesong[$od['od_id']] = $od['cellphone'];
    }
    foreach($od_sms_baesong as $key=>$recv) {
        $q = get_order($key, 'pt_id');
        icode_order_sms_send($q['pt_id'], $recv, $key, 4);
    }
}
else if($_POST['act_button'] == "배송완료")
{
    for($i=0; $i<$count; $i++)
    {
        // 실제 번호를 넘김
        $k			 = $_POST['chk'][$i];
        $od_no		 = $_POST['od_no'][$k];
        $delivery	 = $_POST['delivery'][$k];
        $delivery_no = $_POST['delivery_no'][$k];

        $od = get_order($od_no);
        if($od['dan'] != 4) continue;

        change_order_status_5($od_no, $delivery, $delivery_no);

        $od_sms_delivered[$od['od_id']] = $od['cellphone'];
    }

    foreach($od_sms_delivered as $key=>$recv) {
        $q = get_order($key, 'pt_id');
        icode_order_sms_send($q['pt_id'], $recv, $key, 6);
    }
}
else if($_POST['act_button'] == "교환중")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];
		$od = get_order($od_id);
        $od_no = $od['od_no'];
		if($od['dan'] != 12) continue;
		change_order_status_13($od_no);
	}
}
else if($_POST['act_button'] == "반품중")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];
        $od = get_order($od_id);
        $od_no = $od['od_no'];
		if($od['dan'] != 10) continue;
		change_order_status_11($od_no);
	}
}
else if($_POST['act_button'] == "교환완료")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];
		$od = get_order($od_id);
        $od_no = $od['od_no'];
		if($od['dan'] != 13) continue;
		change_order_status_8($od_no);
	}
}
else if($_POST['act_button'] == "반품완료")
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k     = $_POST['chk'][$i];
		$od_id = $_POST['od_id'][$k];
		$od = get_order($od_id);
        $od_no = $od['od_no'];
		if($od['dan'] != 11) continue;
		change_order_status_7($od_no);
	}
}
else if($_POST['act_button'] == "운송장번호수정")
{
    for($i=0; $i<$count; $i++)
    {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];

        $sql = " update shop_order
            set delivery	= '{$_POST['delivery'][$k]}'
            , delivery_no = '{$_POST['delivery_no'][$k]}'
            where od_no = '{$_POST['od_no'][$k]}' ";
        sql_query($sql);

        // 2022-02-16
        sb_baesong_update($_POST['od_no'][$k]);
    }
} else {
    alert();
}

goto_url(TB_MYPAGE_URL."/page.php?$q1&page=$page");
?>
