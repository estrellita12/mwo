<?php
include_once("./_common.php");
header('Content-type: text/xml; charset=euc-kr');

// GET 데이터 처리
$gs_id = $_GET['gs_id'];
$sql = " select * from shop_goods where index_no=".$gs_id;
$gs = sql_fetch( $sql );
if( $gs['simg_type']==0 ){
    if( !empty($gs['simg1']) ) $gs['simg1'] = "https://mwo.kr/data/goods/".$gs['simg1'];
    if( !empty($gs['simg2']) ) $gs['simg2'] = "https://mwo.kr/data/goods/".$gs['simg2'];
    if( !empty($gs['simg3']) ) $gs['simg3'] = "https://mwo.kr/data/goods/".$gs['simg3'];
    if( !empty($gs['simg4']) ) $gs['simg4'] = "https://mwo.kr/data/goods/".$gs['simg4'];
    if( !empty($gs['simg5']) ) $gs['simg5'] = "https://mwo.kr/data/goods/".$gs['simg5'];
    if( !empty($gs['simg6']) ) $gs['simg6'] = "https://mwo.kr/data/goods/".$gs['simg6'];
}
$gs['ca_id'] = get_ctg($gs['ca_id']);
$info_value_tmp = unserialize($gs['info_value']);
$gs['info_value'] = array_values($info_value_tmp);

// 공급사명 포함 2023-12-21 수정
$mb_id = $gs['mb_id'];
$sql = " select * from shop_seller where seller_code='".$mb_id."'";
$sel_info = sql_fetch( $sql );
$sel_nm =  mb_convert_encoding($sel_info['company_name'],"EUC-KR","UTF-8");

/*
foreach($gs['info_value'] as &$infoV){
    $infoV = iconv("UTF-8", "EUC-KR", $infoV);
}
*/

//정보고시값 0번 인코딩 추가 2022-10-20 > 2023-01-9 삭제 (array_conv 통합)
//$gs['info_value'][0] = iconv("UTF-8", "EUC-KR", $gs['info_value'][0]);
//$gs['info_value'][0] = mb_convert_encoding($gs['info_value'][0],"EUC-KR","UTF-8");

//상세정보 값 인코딩 방식 변경 EUC-KR 데이터로 교체 작업
//if(!empty($gs['memo_euc_kr'])) $gs['memo'] = $gs['memo_euc_kr'];
// 2023-01-09 삭제 > array_conv 통합
//$gs_memo = iconv("UTF-8", "EUC-KR", $gs['memo']);
//$gs_memo = mb_convert_encoding($gs['memo'],"EUC-KR","UTF-8");
//if( !empty($gs_memo) )  $gs['memo'] = $gs_memo;

$gs['opt_subject'] = explode(",",$gs['opt_subject']);
//$gs['opt_subject'] = array("선택","");
//$char_1_nm =  iconv("UTF-8", "EUC-KR", $gs['opt_subject'][0]);
$char_1_nm =  mb_convert_encoding($gs['opt_subject'][0],"EUC-KR","UTF-8");
$gs['char_1_val'] = '';
$gs['char_2_val'] = '';

$gs = array_conv($gs);
/*
$tmpFile = "/home/mwo/public_html/log/debug_tmp_".TB_TIME_YMD.".txt";
$tmpArr['DATE'] = TB_TIME_YHS;
$tmpArr['VALUE'] = $gs;
error_log(print_r($tmpArr,true) ,3, $tmpFile);
*/

$sql = " select * from shop_goods_option where gs_id=".$gs_id." order by io_no";
$res = sql_query($sql);
$tmp = "";
$opt1Arr = array();
$opt2Arr = array();
for($i=0;$row=sql_fetch_array( $res );$i++){
    $row = array_conv($row);
    $opt_id = $row['io_id'];
/*
    if($i!=0){
        $gs['char_1_val'] .= ",";
    }
    $opt_val = str_replace(chr(30)," ", $opt_id);
    $gs['char_1_val'] .= $opt_val;
    $gs['char_1_val'] .= "^^";
    $gs['char_1_val'] .= $row['io_stock_qty'];  // 재고
    $gs['char_1_val'] .= "^^";
    $gs['char_1_val'] .= $row['io_price'];      // 추가 금액
    $gs['char_1_val'] .= "^^";
    $gs['char_1_val'] .= "";
    $gs['char_1_val'] .= "^^";
    //$gs['char_1_val'] .= 'EA';
    $gs['char_1_val'] .= "^^";
    $gs['char_1_val'] .= $xml_io_use[$row['io_use']];
 */

    $opt_val = explode(chr(30),$opt_id);  
    if( !in_array($opt_val[0],$opt1Arr) ){
        array_push($opt1Arr,$opt_val[0]);

        if($i!=0){
            $gs['char_1_val'] .= ",";
        }

        $gs['char_1_val'] .= $opt_val[0];
        $gs['char_1_val'] .= "^^";
        $gs['char_1_val'] .= $row['io_stock_qty'];  // 재고
        $gs['char_1_val'] .= "^^";
        $gs['char_1_val'] .= $row['io_price'];      // 추가 금액
        $gs['char_1_val'] .= "^^";
        $gs['char_1_val'] .= "";
        $gs['char_1_val'] .= "^^";
        //$gs['char_1_val'] .= 'EA';
        $gs['char_1_val'] .= "^^";
        $gs['char_1_val'] .= $xml_io_use[$row['io_use']];
    }

    if( !in_array($opt_val[1],$opt2Arr) ){
        array_push($opt2Arr,$opt_val[1]);
        if(!empty($opt_val[1])){
            if($i!=0){
                $gs['char_2_val'] .= ",";
            }
            $gs['char_2_val'] .= $opt_val[1];
        }
    }
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
            'GOODS_KEYWORD' => '<![CDATA['.$gs['explan'].']]>',
            'MODEL_NM' => '<![CDATA['.$gs['model'].']]>',
            'MODEL_NO' => '<![CDATA['.$gs['model_no'].']]>',
            'BRAND_NM' => '<![CDATA['.$gs['brand_nm'].']]>',
            'COMPAYNY_GOODS_CD' => '<![CDATA[JS'.$gs['gcode'].']]>',
            //'GOODS_SEARCH' => '<![CDATA['.$gs['keywords'].']]>',
            'GOODS_GUBUN' => '1',
            'CLASS_CD1' => '<![CDATA['.$gs['ca_id'][0].']]>',
            'CLASS_CD2' => '<![CDATA['.$gs['ca_id'][1].']]>',
            'CLASS_CD3' => '<![CDATA['.$gs['ca_id'][2].']]>',
            'CLASS_CD4' => '<![CDATA['.''.']]>',
            'PARTNER_ID' => '<![CDATA['.'ncnature'.']]>',
            //'DPARTNER_ID' => '<![CDATA['.'direct1'.']]>',
            //'MAKER' => '<![CDATA['.$gs['maker'].']]>',
            'MAKER' => '<![CDATA['.$sel_nm.']]>',
            'ORIGIN' => '<![CDATA['.$gs['origin'].']]>',
            'MAKE_YEAR' => '<![CDATA['.$gs['make_year'].']]>',
            'MAKE_DM' => '<![CDATA['.$gs['make_dm'].']]>',
            'GOODS_SEASON' => $gs['season'],
            'SEX' => $gs['sex'],
            'STATUS' => $xml_isopen[$gs['isopen']],
            'DELIV_ABLE_REGION' => '1',
            'TAX_YN' => $xml_tax[$gs['notax']],
            'DELV_TYPE' => $xml_sc_type[$gs['sc_type']],
            'DELV_COST' => $gs['sc_amt'],
            'BANPUM_AREA' => '',
            'GOODS_COST' => $gs['supply_price'],
            'GOODS_PRICE' => $gs['normal_price'],
            'GOODS_CONSUMER_PRICE' => $gs['normal_price'],
            'CHAR_1_NM' => '<![CDATA['.$char_1_nm.']]>',
            'CHAR_1_VAL' => '<![CDATA['.$gs['char_1_val'].']]>',
            'CHAR_2_NM' => '<![CDATA['.$gs['opt_subject'][1].']]>',
            'CHAR_2_VAL' => '<![CDATA['.$gs['char_2_val'].']]>',
            'IMG_PATH' => '<![CDATA['.$gs['simg1'].']]>',
            'IMG_PATH1' => '<![CDATA['.$gs['simg2'].']]>',
            'IMG_PATH2' => '<![CDATA['.$gs['simg3'].']]>',
            'IMG_PATH3' => '<![CDATA['.$gs['simg4'].']]>',
            'IMG_PATH4' => '<![CDATA['.$gs['simg5'].']]>',
            'IMG_PATH5' => '<![CDATA['.$gs['simg6'].']]>',
            'IMG_PATH6' => '<![CDATA['.''.']]>',
            'IMG_PATH7' => '<![CDATA['.''.']]>',
            'IMG_PATH8' => '<![CDATA['.''.']]>',
            'IMG_PATH9' => '<![CDATA['.''.']]>',
            'IMG_PATH10' => '<![CDATA['.''.']]>',
            'IMG_PATH11' => '<![CDATA['.$gs['simg1'].']]>',
            'IMG_PATH12' => '<![CDATA['.''.']]>',
            'IMG_PATH13' => '<![CDATA['.''.']]>',
            'IMG_PATH14' => '<![CDATA['.''.']]>',
            'IMG_PATH15' => '<![CDATA['.''.']]>',
            'IMG_PATH16' => '<![CDATA['.''.']]>',
            'IMG_PATH17' => '<![CDATA['.$gs['simg1'].']]>',
            'IMG_PATH18' => '<![CDATA['.''.']]>',
            'IMG_PATH19' => '<![CDATA['.''.']]>',
            'IMG_PATH20' => '<![CDATA['.''.']]>',
            'IMG_PATH21' => '<![CDATA['.''.']]>',
            'IMG_PATH22' => '<![CDATA['.''.']]>',
            'IMG_PATH23' => '<![CDATA['.''.']]>',
            'IMG_PATH24' => '<![CDATA['.''.']]>',
            'GOODS_REMARKS' => '<![CDATA['.$gs['memo'].']]>',
            'CERTNO' => '<![CDATA['.$gs['certno'].']]>',
            'AVLST_DM' => $gs['avlst_dm'],
            'AVLED_DM' => $gs['avled_dm'],
            'ISSUEDATE' => $gs['issuedate'],
            'CERTDATE' => $gs['certdate'],
            'CERT_AGENCY' => '<![CDATA['.$gs['cert_agency'].']]>',
            'CERTFIELD' => '<![CDATA['.$gs['certfield'].']]>',
            'MATERIAL' => $gs['material'],
            'STOCK_USE_YN' => '<![CDATA['.'N'.']]>',
            'OPT_TYPE' => '<![CDATA['.'2'.']]>',
            'PROP_EDIT_YN' => 'Y',
            'PROP1_CD' => $item_info[$gs['info_gubun']]['code'],
            'PROP_VAL1' => '<![CDATA['.$gs['info_value'][0].']]>',
            'PROP_VAL2' => '<![CDATA['.$gs['info_value'][1].']]>',
            'PROP_VAL3' => '<![CDATA['.$gs['info_value'][2].']]>',
            'PROP_VAL4' => '<![CDATA['.$gs['info_value'][3].']]>',
            'PROP_VAL5' => '<![CDATA['.$gs['info_value'][4].']]>',
            'PROP_VAL6' => '<![CDATA['.$gs['info_value'][5].']]>',
            'PROP_VAL7' => '<![CDATA['.$gs['info_value'][6].']]>',
            'PROP_VAL8' => '<![CDATA['.$gs['info_value'][7].']]>',
            'PROP_VAL9' => '<![CDATA['.$gs['info_value'][8].']]>',
            'PROP_VAL10' => '<![CDATA['.$gs['info_value'][9].']]>',
            'PROP_VAL11' => '<![CDATA['.$gs['info_value'][10].']]>',
            'PROP_VAL12' => '<![CDATA['.$gs['info_value'][11].']]>',
            'PROP_VAL13' => '<![CDATA['.$gs['info_value'][12].']]>',
            'PROP_VAL14' => '<![CDATA['.$gs['info_value'][13].']]>',
            'PROP_VAL15' => '<![CDATA['.$gs['info_value'][14].']]>',
            'PROP_VAL16' => '<![CDATA['.$gs['info_value'][15].']]>',
            'PROP_VAL17' => '<![CDATA['.$gs['info_value'][16].']]>',
            'PROP_VAL18' => '<![CDATA['.$gs['info_value'][17].']]>',
            'PROP_VAL19' => '<![CDATA['.$gs['info_value'][18].']]>',
            'PROP_VAL20' => '<![CDATA['.$gs['info_value'][19].']]>',
            'PROP_VAL21' => '<![CDATA['.$gs['info_value'][20].']]>',
            'PROP_VAL22' => '<![CDATA['.$gs['info_value'][21].']]>',
            'PROP_VAL23' => '<![CDATA['.$gs['info_value'][22].']]>',
            'PROP_VAL24' => '<![CDATA['.$gs['info_value'][23].']]>',
            'PROP_VAL25' => '<![CDATA['.$gs['info_value'][24].']]>',
            'PROP_VAL26' => '<![CDATA['.$gs['info_value'][25].']]>',
            'PROP_VAL27' => '<![CDATA['.$gs['info_value'][26].']]>',
            'PROP_VAL28' => '<![CDATA['.$gs['info_value'][27].']]>',
            'PACK_CODE_STR' => '<![CDATA['.''.']]>',
            'GOODS_NM_EN' => '<![CDATA['.''.']]>',
            'GOODS_NM_PR' => '<![CDATA['.''.']]>',
            'GOODS_REMARKS2' => '<![CDATA['.''.']]>',
            'GOODS_REMARKS3' => '<![CDATA['.''.']]>',
            'GOODS_REMARKS4' => '<![CDATA['.''.']]>',
            'IMPORTNO' => '<![CDATA['.''.']]>',
            'GOODS_COST2' => '<![CDATA['.''.']]>',
            'ORIGIN2' => '<![CDATA['.''.']]>',
            'EXPIRE_DM' => '<![CDATA['.''.']]>',
            'SUPPLY_SAVE_YN' => '<![CDATA['.''.']]>',
            'DESCRITION' => '<![CDATA['.''.']]>'
        )
    )
);

// 2023-09-20 초기 등록시에만 카테고리 설정하고, 그후엔 변경 안함
if( !empty($gs['sbcode']) ){
    $xml['SABANG_GOODS_REGI']['DATA']['CLASS_CD1'] = '<![CDATA['.''.']]>';
    $xml['SABANG_GOODS_REGI']['DATA']['CLASS_CD2'] = '<![CDATA['.''.']]>';
    $xml['SABANG_GOODS_REGI']['DATA']['CLASS_CD3'] = '<![CDATA['.''.']]>';
    $xml['SABANG_GOODS_REGI']['DATA']['CLASS_CD4'] = '<![CDATA['.''.']]>';
}

header('Content-type: text/xml');
echo "<?xml version='1.0' encoding='euc-kr' ?>\n";
echo array_xml($xml);
?>
