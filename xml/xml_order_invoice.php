<?php
include_once("./_common.php");

// GET 데이터 처리
$od_no = $_GET['od_no'];
$sql = " select * from shop_order where od_no='".$od_no."'";
$row = sql_fetch( $sql );
$xml = array(
    'SABANG_INV_REGI'=> array(
        'HEADER'=> array(
            'SEND_COMPAYNY_ID' => $com_id,
            'SEND_AUTH_KEY' => $auth_key,
            'SEND_DATE' => $today,
            'SEND_INV_EDIT_YN' => 'Y',
            'RESULT_TYPE' => 'XML'
        ),
        'DATA'=> array(
            'SABANGNET_IDX' => '<![CDATA['.$row['od_id'].']]>',
            'TAK_CODE' => '<![CDATA['.$xml_delivery[$row['delivery']].']]>',
            'TAK_INVOICE' => '<![CDATA['.$row['delivery_no'].']]>',
            'DELV_HOPE_DATE' => '<![CDATA['.''.']]>'
        )
    )
);
header('Content-type: text/xml');
echo "<?xml version='1.0'?>\n";
echo array_xml($xml);
?>
