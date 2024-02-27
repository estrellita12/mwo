<?php
// 주문상태
// MWO      1:입금대기, 2:결제완료, 3:배송준비, 4:배송중, 5:배송완료, 6: 취소완료, 7:반품완료, 8:교환완료, 9:환불완료, 10:반품접수, 12:교환접수, 14:환불접수
// 사방넷   신규주문, 주문확인, 출고대기, 출고완료, 배송보류, 취소접수, 교환접수, 반품접수, 취소완료, 교환완료, 반품완료
$xml_dan = array(
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
$xml_tax = array(
    '0' => '2',
    '1' => '1'
);

// 배송 구분
// MWO      0:공통설정, 1:무료배송, 2:조건부무료배송, 3:유료배송 
// 사방넷   1:무료, 2:착불, 3:선결제, 4:착불/선결제
$xml_sc_type = array(
    "0" =>"1",
    "1" =>"1",
    "2" =>"4",
    "3" =>"4",
);

// 옵션 상태
// MWO      0:미사용, 1:사용 
// 사방넷   002:공급중, 004:품절, 005:미사용
$xml_io_use = array(
    //"0" =>"005",
    "0" =>"004",
    "1" =>"002"
);

/*
// 택배사 코드
$xml_delivery = array(
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
$xml_delivery = array(
    "CJ대한통운|https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no="=>"001",
    "한진택배|https://www.hanjin.co.kr/kor/CMS/DeliveryMgr/WaybillResult.do?mCode=MN038&schLang=KR&wblnum="=>"004",
    "KG로지스|http://www.kglogis.co.kr/contents/waybill.jsp?item_no="=>"104",
    "KGB택배|http://www.kgbls.co.kr/sub5/trace.asp?f_slipno="=>"005",
    "KG옐로우캡택배|http://www.yellowcap.co.kr/custom/inquiry_result.asp?invoice_no="=>"008",
    "CVSnet편의점택배|http://was.cvsnet.co.kr/_ver2/board/ctod_status.jsp?invoice_no="=>"114",
    "롯데택배|https://www.lotteglogis.com/home/reservation/tracking/invoiceView?InvNo="=>"002",
    "이노지스택배|http://www.innogis.co.kr/tracking_view.asp?invoice="=>"023",
    "우체국|http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1="=>"009",
    "로젠택배|http://www.ilogen.com/web/personal/trace/"=>"007",
    "동부택배|http://www.dongbups.com/delivery/delivery_search_view.jsp?item_no="=>"006",
    "대신택배|http://home.daesinlogistics.co.kr/daesin/jsp/d_freight_chase/d_general_process2.jsp?billno1="=>"037",
    "경동택배|http://www.kdexp.com/sub3_shipping.asp?stype=1&p_item="=>"013",
    "기타택배|"=>"999"
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

$timestamp = strtotime("-14 days");
$d_2week = date("Ymd", $timestamp);

function convertArray($object){
    return json_decode( json_encode( $object ), 1 );
}

function empty_check( $arr ) {
    foreach($arr as $key=>$value){
        if(empty($value)) $arr[$key]='';
    }
    return $arr;
}

function post_xml($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    $response = curl_exec($ch);
    //var_dump($response);
    curl_close($ch);

    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA) or die("Error: Cannot create object");
    $xmlArr = convertArray($xml);
    return $xmlArr;
}

// 상품등록&수정
//  상품등록/수정시 동작하는 함수
//  --> 동작 결과를 sb_check column에 저장 : 0(반영실패), 1(반영성공)
function xml_goods_info($gs_id){
    $xml = "http://mwo.kr/xml/xml_goods_info.php?gs_id=$gs_id";
    $url = "https://sbadmin14.sabangnet.co.kr/RTL_API/xml_goods_info.html?xml_url=".$xml;
    $xmlArr = post_xml($url);
    return $xmlArr['DATA'];
}


function sb_goods_update($gs_id, $login_id ){
    $sbres = xml_goods_info($gs_id);
    $sbres2 = xml_goods_info2($gs_id);

    if( $sbres['RESULT']=='SUCCESS' && $sbres2['RESULT']=='SUCCESS' ){
        $msg = $sbres['RESULT']." : ".$sbres['MODE'];
        $sql = "update shop_goods set sb_check = 1, sbcode = '{$sbres['PRODUCT_ID']}' where index_no='{$gs_id}' ";
        sql_query($sql);
    }else{
        $msg = "";
        if($sbres['RESULT']!='SUCCESS'){
            $msg .= $sbres['RESULT']." : ".$sbres['RESULT_MSG']."<br>";
        }
        if($sbres2['RESULT']!='SUCCESS'){
            $msg .= $sbres2['RESULT']." : ".$sbres2['RESULT_MSG'];
        }
    }

    $sql = "insert into shop_goods_log set gs_id='{$gs_id}', mb_id='{$login_id}', update_time='".TB_TIME_YMDHIS."', memo='사방넷 상품 송신', sb_result='{$msg}' ";
    sql_query($sql);
}

// 상품요약수정
function xml_goods_info2($gs_id){
    $xml = "http://mwo.kr/xml/xml_goods_info2.php?gs_id=$gs_id";
    $url = "https://sbadmin14.sabangnet.co.kr/RTL_API/xml_goods_info2.html?xml_url=".$xml;
    $xmlArr = post_xml($url);
    return $xmlArr['DATA'];
}

// 주문수집
// 001:신규주문, 002:주문확인
function xml_order_info($dan){
    global $xml_dan;
    global $xml_delivery;

    $xml = "http://mwo.kr/xml/xml_order_info.php?dan=$dan";
    $url = "https://sbadmin14.sabangnet.co.kr/RTL_API/xml_order_info.html?xml_url=".$xml;
    $tmpArr = post_xml($url);
    print_r($tmpArr['HEADER']);

    $xmlArr['DATA'] = array();
    if($tmpArr['HEADER']['TOTAL_COUNT']==0) return;
    else if($tmpArr['HEADER']['TOTAL_COUNT']==1) $xmlArr['DATA'][0] = $tmpArr['DATA'];
    else $xmlArr['DATA'] = $tmpArr['DATA'];

    foreach($xmlArr['DATA'] as $data){
        $sql = " select od_id from shop_order where od_id='{$data['IDX']}' ";
        $row = sql_fetch( $sql );
        if( !empty($row['od_id']) ) continue;

        $data = empty_check( $data );   // 비어있는 데이터 삭제 

        $columns = get_columns("shop_goods");
        $columns = array_diff($columns, array("info_value", "info_gubun", "memo", "admin_memo","certno","avlst_dm","avled_dm","issuedate","certdate","cert_agency","certfield","material","make_year","make_dm","season","sex","model_no","sb_check","sbcode"));
        $gcode = substr($data['COMPAYNY_GOODS_CD'],2);  // 앞에 붙은 JS를 제외 시킨다
        $sql = " select ".implode(",",$columns)." from shop_goods where gcode ='{$gcode}'";
        $gs = sql_fetch( $sql );
        $od_goods = serialize($gs);

        // 상품에 설정된 판매가가 각 직송업체의 공급가.
        // 상품에 설정된 공급가는 각 직송업체의 판매가에서 수수료만큼 인하된 가격이라 의미 없음
        $goods_price = $data['SALE_COST']*$data['SALE_CNT'];  // 상품가
        $supply_price = $data['WON_COST']*$data['SALE_CNT'];  // 공급가
        $goods_price = $supply_price; // 2022-12-14 판매금액 수집 안함
        $use_price = $goods_price+$data['DELV_COST'];  // 결제금액
        $data['REG_DATE'] = '20'.date("y-m-d H:i:s",strtotime($data['REG_DATE']));
        $data['ORD_CONFIRM_DATE'] = '20'.date("y-m-d H:i:s",strtotime($data['ORD_CONFIRM_DATE']));
        $memo = '쇼핑몰명 : '.$data['MALL_ID'].', 쇼핑몰 주문번호 : '.$data['ORDER_ID'];  

        unset($cart); unset($order);
        $cart['gs_id'] = $gs['index_no'];
        $cart['ct_time'] = $data['ORDER_DATE'];             // 등록일시               
        $cart['ct_price'] = $gs['goods_price'];             // 1개 상품에 대한 가격
        $cart['ct_supply_price'] = $gs['supply_price'];     // 1개 상품에 대한 가격
        $cart['ct_qty'] = $data['SALE_CNT'];
        $cart['io_id'] = $data['P_SKU_VALUE'];
        $cart['io_type'] = '0';
        $cart['ct_option'] = str_replace(":"," ",$data['P_SKU_VALUE']);
        $cart['ct_send_cost'] = $data['DELIVERY_METHOD_STR'];
        $cart['od_id'] = $data['IDX'];
        $cart['od_no'] = date("Ymd", TB_SERVER_TIME).$data['IDX'];
        $cart['ct_select'] = '1';

        $order['dan'] = $xml_dan[$data['ORDER_STATUS']];
        $order['delivery'] = array_search( $data['DELIVERY_ID'], $xml_delivery );
        $order['delivery_no'] = $data['INVOICE_NO'];
        $order['od_id'] = $data['IDX']; 
        $order['od_no'] = date("Ymd", TB_SERVER_TIME).$data['IDX'];
        $order['name'] = $data['RECEIVE_NAME'];
        $order['cellphone'] = $data['RECEIVE_CEL'];
        $order['telephone'] = $data['RECEIVE_TEL'];
        $order['email'] = $data['RECEIVE_EMAIL'];
        $order['zip'] = $data['RECEIVE_ZIPCODE'];
        $order['addr1'] = $data['RECEIVE_ADDR'];
        $order['b_name'] = $data['RECEIVE_NAME'];
        $order['b_cellphone'] = $data['RECEIVE_CEL'];
        $order['b_telephone'] = $data['RECEIVE_TEL'];
        $order['b_zip'] = $data['RECEIVE_ZIPCODE'];
        $order['b_addr1'] = $data['RECEIVE_ADDR'];
        $order['memo'] = $data['DELV_MSG'];
        $order['gs_id'] = $gs['index_no'];
        $order['goods_price'] = $goods_price;           // 구매한 상품의 총 상품 가격
        $order['supply_price'] = $supply_price;         // 구매한 상품의 총 공급 가격
        $order['sum_qty'] = $data['SALE_CNT'];      
        $order['use_price'] = $use_price;               // 배송비를 포함한 실결제금액 
        $order['baesong_price'] = $data['DELV_COST'];   // 배송비
        $order['seller_id'] = $gs['mb_id'];
        $order['od_goods'] = $od_goods;
        $order['od_time'] = $data['ORDER_DATE'];
        $order['receipt_time'] = $data['REG_DATE'];
        $order['paymethod'] = '-';
        $order['od_pwd'] = $data['ORDER_ID'];
        //$order['shop_memo'] = $memo;
        $order['rcent_time'] = TB_TIME_YMDHIS;

        if($data['MALL_ID']=='사방넷직송') $order['od_ip'] = '판매대행';
        else $order['od_ip'] = $data['MALL_ID'];
        $order['pt_id'] = 'admin';

        insert("shop_cart",$cart);
        insert("shop_order",$order);

        //2022-03-23 주문 수집 log 추가
        unset($order_log);
        $order_log['od_no'] = $data['IDX'] ? date("Ymd", TB_SERVER_TIME).$data['IDX'] : '';
        $order_log['mb_id'] = $data['MALL_ID'] && $data['MALL_ID']=='사방넷직송' ? 'sabangnetApi' : 'admin';
        $order_log['memo'] = '사방넷 주문서 수집';
        $order_log['update_time'] = TB_TIME_YMDHIS;
        insert("shop_order_log",$order_log);
        //2022-03-23 주문 수집 log 추가        
    }
}

// 송장등록
function xml_order_invoice($od_no){
    $xml = "http://mwo.kr/xml/xml_order_invoice.php?od_no=$od_no";
    $url = "https://sbadmin14.sabangnet.co.kr/RTL_API/xml_order_invoice.html?xml_url=".$xml;
    $xmlArr = post_xml($url);
    /*
        Array ( 
            [HEADER] => Array ( 
                [SEND_COMPAYNY_ID] => majorgolf 
                [SEND_DATE] => 20220216 
                [TOTAL_COUNT] => 1 
            ) 
            [DATA] => Array ( 
                [RESULT] => SUCCESS 
                [SABANGNET_IDX] => 17117400 
            ) 
        )
     */
    return $xmlArr['DATA'];
}

// 송장등록
function sb_baesong_update($od_no){
    $sbres = xml_order_invoice($od_no);

    if( $sbres['RESULT']=='SUCCESS' ){
        //$msg = '\n송장등록일시 : '.TB_TIME_YMDHIS;
        //$sql = "update shop_order set shop_memo=concat(shop_memo,'{$msg}') where od_no='{$od_no}' ";
        //sql_query($sql);

        //2022-12-06
        $order_log['od_no'] = $od_no;
        $order_log['mb_id'] = 'sabangnetApi';
        $order_log['memo'] = '송장 송신 성공';
        $order_log['update_time'] = TB_TIME_YMDHIS;
        insert("shop_order_log",$order_log);
    }else{
        //2022-12-06
        $order_log['od_no'] = $od_no;
        $order_log['mb_id'] = 'sabangnetApi';
        $order_log['memo'] = '송장 송신 실패';
        $order_log['update_time'] = TB_TIME_YMDHIS;
        insert("shop_order_log",$order_log);
    }
}

// 클레임수집
//  자동 수집건에서만 동작
function xml_clm_info(){
    $xml = "http://mwo.kr/xml/xml_clm_info.php";
    $url = "https://sbadmin14.sabangnet.co.kr/RTL_API/xml_clm_info.html?xml_url=".$xml;
    $xmlArr = post_xml($url);
    print_r($xmlArr['HEADER']); echo "<br>";
    foreach($xmlArr['DATA'] as $data){
        print_r($data);
    }
}

// 주문수집
// 001:신규주문, 002:주문확인, 003:출고대기, ..
function xml_order_clm_info($dan){
    global $xml_dan;
    global $xml_delivery;

    $xml = "http://mwo.kr/xml/xml_order_clm_info.php?dan=$dan";
    $url = "https://sbadmin14.sabangnet.co.kr/RTL_API/xml_order_info.html?xml_url=".$xml;
    $tmpArr = post_xml($url);
    print_r($tmpArr['HEADER']);

    $xmlArr['DATA'] = array();
    if($tmpArr['HEADER']['TOTAL_COUNT']==0) return;
    else if($tmpArr['HEADER']['TOTAL_COUNT']==1) $xmlArr['DATA'][0] = $tmpArr['DATA'];
    else $xmlArr['DATA'] = $tmpArr['DATA'];

    foreach($xmlArr['DATA'] as $data){
        $data = empty_check( $data );   // 비어있는 데이터 삭제 
        unset($order);
        $order['dan'] = $xml_dan[$data['ORDER_STATUS']];
        $order['delivery_date'] = $data['DELIVERY_CONFIRM_DATE'];
        $order['invoice_date'] = '';
        $order['change_date'] = $data['CHNG_DT'];
        $order['return_date'] = $data['CANCEL_DT'];
        //$order['refund_date'] = $data['RTN_DT'];
        $order['refund_date'] = TB_TIME_YMDHIS;
        $order['delivery'] = array_search( $data['DELIVERY_ID'], $xml_delivery );
        $order['delivery_no'] = $data['INVOICE_NO'];

        $sql = " select od_id,dan from shop_order where od_id='{$data['IDX']}' ";
        $row = sql_fetch( $sql );
        if( empty($row['od_id']) || $row['dan']==$order['dan'] ) continue;
        update("shop_order",$order," where od_id='{$data['IDX']}' ");
    }
}


?>
