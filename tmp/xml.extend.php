<?php
// 주문상태
// MWO      1:입금대기, 2:결제완료, 3:배송준비, 4:배송중, 5:배송완료, 6: 취소완료, 7:반품완료, 8:교환완료, 9:환불완료, 10:반품접수, 12:교환접수, 14:환불접수
// 사방넷   신규주문, 주문확인, 출고대기, 출고완료, 배송보류, 취소접수, 교환접수, 반품접수, 취소완료, 교환완료, 반품완료
$gw_dan = array(
    "신규주문"=>"2",
    "주문확인"=>"2",
    "출고대기"=>"3",
    "출고완료"=>"4",
    "배송보류"=>"3",
    "취소접수"=>"9",
    "취소완료"=>"9",
    "교환접수"=>"12",
    "교환발송준비"=>"13",
    "교환발송완료"=>"13",
    "교환회수준비"=>"13",
    "교환회수완료"=>"13",
    "교환완료"=>"8",
    "반품접수"=>"10",
    "반품회수준비"=>"11",
    "반품회수완료"=>"11",
    "반품완료"=>"7"
);

// 상품진열상태
// MWO      1:진열, 2:품절, 3:단종, 4:중지 
// 사방넷   1:대기중, 2:공급중, 3:일시중지, 4:완전품절, 5:미사용, 6:삭제
$xml_isopen = array(
    "1"=>"2",
    "2"=>"3",
    "3"=>"4",
    "4"=>"3",
);

// 세금구분
// MWO      0:면세, 1:과세
// 사방넷   1:과세, 2:면세, 3:자료없음, 4:비과세
$gw_tax = array(
    '0' => '2',
    '1' => '1'
);

// 배송 구분
// MWO      0:공통설정, 1:무료배송, 2:조건부무료배송, 3:유료배송 
// 사방넷   1:무료, 2:착불, 3:선결제, 4:착불/선결제
$gw_sc_type = array(
    "1" =>"1",
    "2" =>"4",
    "3" =>"4",
);

// 옵션 상태
// MWO      0:미사용, 1:사용 
// 사방넷   002:공급중, 004:품절, 005:미사용
$gw_io_use = array(
    "0" =>"005",
    "1" =>"002"
);

/*
// 택배사 코드
$gw_delivery = array(
    "CJ대한통운"=>"001",
    "한진택배"=>"004",
    "KG로지스"=>"104",
    "KGB택배"=>"005",
    "KG옐로우캡택배"=>"008",
    "CVSnet편의점택배"=>"114",
    "롯데택배(구현대택배)"=>"002",
    "이노지스택배"=>"023",
    "우체국"=>"009",
    "로젠택배"=>"007",
    "동부택배"=>"006",
    "대신택배"=>"037",
    "경동택배"=>"013"
);
*/

// 택배사 코드
$gw_delivery = array(
    "CJ대한통운|https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no="=>"001",
    "한진택배|https://www.hanjin.co.kr/kor/CMS/DeliveryMgr/WaybillResult.do?mCode=MN038&schLang=KR&wblnumText=&wblnum="=>"004",
    "KG로지스|http://www.kglogis.co.kr/contents/waybill.jsp?item_no="=>"104",
    "KGB택배|http://www.kgbls.co.kr/sub5/trace.asp?f_slipno="=>"005",
    "KG옐로우캡택배|http://www.yellowcap.co.kr/custom/inquiry_result.asp?invoice_no="=>"008",
    "CVSnet편의점택배|http://was.cvsnet.co.kr/_ver2/board/ctod_status.jsp?invoice_no="=>"114",
    "롯데택배(구현대택배)|https://www.lotteglogis.com/home/reservation/tracking/invoiceView?InvNo="=>"002",
    "이노지스택배|http://www.innogis.co.kr/tracking_view.asp?invoice="=>"023",
    "우체국|http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1="=>"009",
    "로젠택배|https://www.ilogen.com/web/personal/trace/"=>"007",
    "동부택배|http://www.dongbups.com/delivery/delivery_search_view.jsp?item_no="=>"006",
    "대신택배|http://home.daesinlogistics.co.kr/daesin/jsp/d_freight_chase/d_general_process2.jsp?billno1="=>"037",
    "경동택배|http://www.kdexp.com/sub3_shipping.asp?stype=1&p_item="=>"013"
);



$com_id = 'majorgolf';
$auth_key = 'dZudbGruSGZbNS6rWKdSdH8BNMT5F7SPb7';

$timestamp = strtotime("Now");
$today = date("Ymd", $timestamp);

$timestamp = strtotime("-1 days");
$d_one = date("Ymd", $timestamp);

$timestamp = strtotime("-2 days");
$d_two = date("Ymd", $timestamp);

$timestamp = strtotime("-3 days");
$d_three = date("Ymd", $timestamp);

?>
