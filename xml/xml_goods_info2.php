<?php
include_once("./_common.php");
header('Content-type: text/xml; charset=euc-kr');

// GET 데이터 처리
$gs_id = $_GET['gs_id'];
$sql = " select * from shop_goods where index_no=".$gs_id;
$gs = sql_fetch( $sql );
$gs['opt_subject'] = explode(",",$gs['opt_subject']);
$gs = array_conv($gs);

$sql = " select * from shop_goods_option where gs_id=".$gs_id;
$res = sql_query($sql);
$$opt_val = "";
for($i=0;$row=sql_fetch_array( $res );$i++){
    $row = array_conv($row);
    $opt_val .= "<SKU_VALUE>";
    $opt_val .= str_replace(chr(30),":", $row['io_id']);
    $opt_val .= "^^";
    $opt_val .= $row['io_stock_qty'];
    $opt_val .= "^^";
    $opt_val .= $row['io_price'];
    $opt_val .= "^^";
    //$opt_val .= '별칭';
    $opt_val .= "^^";
    //$opt_val .= 'EA';
    $opt_val .= "^^";
    if($row['io_stock_qty'] <= 0) $row['io_use'] = 0;
    $opt_val .= $xml_io_use[$row['io_use']];
    $opt_val .= "</SKU_VALUE>";
}

$xml = array(
    'SABANG_GOODS_REGI'=> array(
        'HEADER'=> array(
            'SEND_COMPAYNY_ID' => $com_id,
            'SEND_AUTH_KEY' => $auth_key,
            'SEND_DATE' => $today,
            'SEND_GOODS_CD_RT' => 'Y',
            'RESULT_TYPE' => 'XML'
        ),
        'DATA'=> array(
            'GOODS_NM' => '<![CDATA['.$gs['gname'].']]>',
            'COMPAYNY_GOODS_CD' => '<![CDATA[JS'.$gs['gcode'].']]>',
            'STATUS' => $xml_isopen[$gs['isopen']],
            'GOODS_COST' => $gs['supply_price'],
            'GOODS_PRICE' => $gs['normal_price'],
            'GOODS_CONSUMER_PRICE' => $gs['normal_price'],
            'SKU_INFO'=> $opt_val
        )
    )
);

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='euc-kr' ?>\n";
echo array_xml($xml);
?>
