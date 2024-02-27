<?php
include_once('../common.php');
include_once('../lib/goodsinfo.lib.php');
include_once('../lib/xml.lib.php');

/*
echo  "====상품 관리 >  상품 등록&수정 시작====<br>";
$sbnet = xml_goods_info('3');        // 상품 번호
print_r($sbnet);
echo  "====상품 관리 >  상품 등록&수정 종료====<br>";
*/

/*
echo  "====상품 관리 >  상품 요약 수정 시작====<br>";
xml_goods_info('3');        // 상품 번호
echo  "====상품 관리 >  상품 요약 수정 종료====<br>";
*/


echo  "====주문 관리 >  주문서 수집 시작====<br>";
xml_order_info('002');      // 주문확인
xml_order_info('003');      // 출고대기
//xml_order_info('004');      // 출고완료
echo  "====주문 관리 >  주문서 수집 종료====<br>";


/*
echo  "====주문 관리 >  송장 등록 시작====<br>";
xml_order_invoice('17071800');
echo  "====주문 관리 >  송장 등록 종료====<br>";
*/

/*
echo  "====클레임 관리 >  클레임 수집 시작====<br>";
//xml_clm_info();
xml_clm_order_info('007');      // 주문 상태
echo  "====클레임 관리 >  클레임 수집 종료====<br>";
*/

?>
