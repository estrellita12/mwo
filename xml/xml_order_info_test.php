<?php
include_once("./_common.php");

// GET 데이터 처리
$dan        = '009'; 
$partner    = 'ncnature';

$xml = array(
    'SABANG_ORDER_LIST'=> array(
        'HEADER'=> array(
            'SEND_COMPAYNY_ID' => $com_id,
            'SEND_AUTH_KEY' => $auth_key,
            'SEND_DATE' => $today
        ),
        'DATA'=> array(
            'ORD_ST_DATE' => $d_2week,
            'ORD_ED_DATE' => $today,
            'ORD_FIELD' => '<![CDATA[IDX|ORDER_ID|MALL_ID|RECEIVE_NAME|RECEIVE_TEL|RECEIVE_CEL|RECEIVE_EMAIL|RECEIVE_ZIPCODE|RECEIVE_ADDR|DELV_MSG|COMPAYNY_GOODS_CD|MALL_PRODUCT_ID|PRODUCT_ID|P_PRODUCT_NAME|P_SKU_VALUE|SALE_CNT|DELIVERY_METHOD_STR|DELV_COST|ORDER_STATUS|REG_DATE|CANCEL_DT|COPY_IDX|ORDER_DATE|DELIVERY_ID|INVOICE_NO|WON_COST|COPY_IDX]]>',
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
