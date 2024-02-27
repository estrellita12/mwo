<?php
include_once("./_common.php");

// GET 데이터 처리
$code = $_GET['code'];

$xml = array(
    'SABANG_GOODS_PROP_CODE_INFO_LIST'=> array(
        'HEADER'=> array(
            'SEND_COMPAYNY_ID' => $com_id,
            'SEND_AUTH_KEY' => $auth_key,
            'SEND_DATE' => $today
        ),
        'DATA'=> array(
            'PROP1_CD' => $code
        )
    )
);
header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo array_xml($xml);
?>
