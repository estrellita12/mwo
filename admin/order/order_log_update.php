<?php
define('_NEWWIN_', true);
include_once('./_common.php');

$sql = " select * from shop_order where od_id = '$od_id' ";
$od = sql_fetch($sql);
if(!$od['od_id']) {
    alert_close("주문서가 존재하지 않습니다.");
}

insert('shop_order_log',array('od_no'=>$od['od_no'], 'mb_id'=>$member['id'], "memo"=>$_POST['memo'], "update_time"=>TB_TIME_YMDHIS));
//alert_close("기록이 추가되었습니다.");
alert("기록이 추가되었습니다.","replace");

?>
