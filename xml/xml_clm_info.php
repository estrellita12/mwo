<?php
include_once("./_common.php");
// 클레임 수집
/*
도그도그말// GET 데이터 처리
$xml = array(
    'SABANG_ORDER_LIST'=> array(
        'HEADER'=> array(
            'SEND_COMPAYNY_ID' => $com_id,
            'SEND_AUTH_KEY' => $auth_key,
            'SEND_DATE' => $today
        ),
        'DATA'=> array(
            'CLM_ST_DATE' => $d_three,
            'CLM_ED_DATE' => $today,
            'CLM_FIELD' => '<![CDATA[IDX|ORDER_ID|MALL_ID|MALL_USER_ID|CLAME_STATUS_GUBUN|CLAME_CONTENT]]>',
        )
    )
);
header('Content-type: text/xml');
echo "<?xml version='1.0'?>\n";
echo array_xml($xml);
*/

// 주문수집
// GET 데이터 처리
$dan        = $_GET['dan'];    // 002
$partner    = '';

$xml = array(
    'SABANG_ORDER_LIST'=> array(
        'HEADER'=> array(
            'SEND_COMPAYNY_ID' => $com_id,
            'SEND_AUTH_KEY' => $auth_key,
            'SEND_DATE' => $today
        ),
        'DATA'=> array(
            'ORD_ST_DATE' => $d_one,
            'ORD_ED_DATE' => $today,
            'ORD_FIELD' => '<![CDATA[IDX|ORDER_ID|MALL_ID|mall_USER_ID|RECEIVE_NAME|RECEIVE_TEL|RECEIVE_CEL|RECEIVE_EMAIL|RECEIVE_ZIPCODE|RECEIVE_ADDR|DELV_MSG|COMPAYNY_GOODS_CD|MALL_PRODUCT_ID|PRODUCT_ID|P_PRODUCT_NAME|P_SKU_VALUE|SALE_CNT|DELIVERY_METHOD_STR|DELV_COST|ORDER_GUBUN|ORDER_STATUS|REG_DATE|ORD_CONFIRM_DATE|RTN_DT|CHNG_DT|DELIVERY_CONFIRM_DATE|CANCEL_DT|COPY_IDX|ORDER_DATE|DELIVERY_ID|INVOICE_NO]]>',
            'JUNG_CHK_YN2' => '',
            'ORDER_ID' => '',
            'MALL_ID' => '',
            'ORDER_STATUS' => $dan,
            'LANG' => 'UTF-8',
            'PARTNER_ID' => $partner,
            'MALL_USER_ID' => '',
            'DPARTNER_ID' => ''
        )
    )
);
header('Content-type: text/xml;');
echo "<?xml version='1.0'?>\n";
echo array_xml($xml);

?>
