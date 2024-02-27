<?php
include_once("./_common.php");
include_once('../lib/xml.lib.php');

check_demo();

check_admin_token();

// input vars 체크
check_input_vars();

// 2022-05-13
$file = "/home/mwo/public_html/log/debug_".TB_TIME_YMD.".txt";
$arr['DATE'] = TB_TIME_YHS;
$arr['VALUE'] = $_POST;
error_log(print_r($arr,true) ,3, $file);

$upl_dir = TB_DATA_PATH."/goods";
$upl = new upload_files($upl_dir);

if($_POST['gname'] == "") {
	alert("상품명을 입력하세요.");
}

if($_POST['ca_id'] == "") {
	alert("카테고리를 하나이상 선택하세요.");
}

// 2022-11-18 옵션 없을 시 등록 불가
if(empty(count($_POST['opt_id']))){
    alert("옵션 정보가 입력되지 않았습니다.");
}

// 관련상품을 우선 삭제함
sql_query(" delete from shop_goods_relation where gs_id = '$gs_id' ");

// 관련상품의 반대도 삭제
sql_query(" delete from shop_goods_relation where gs_id2 = '$gs_id' ");

// 관련상품 등록
$gs_id2 = explode(",", $gs_list);
for($i=0; $i<count($gs_id2); $i++)
{
	if(trim($gs_id2[$i]))
	{
		$sql = " insert into shop_goods_relation
					set gs_id  = '$gs_id',
						gs_id2 = '$gs_id2[$i]',
						ir_no = '$i' ";
		sql_query($sql, false);

		// 관련상품의 반대로도 등록
		$sql = " insert into shop_goods_relation
					set gs_id  = '$gs_id2[$i]',
						gs_id2 = '$gs_id',
						ir_no = '$i' ";
		sql_query($sql, false);
	}
}

// 2024-01-22
if($w=="u"){
    $pre_opt_sql = " SELECT group_concat(io_id order by io_id) as opt_li FROM shop_goods_option WHERE io_type = '0' and gs_id='$gs_id' group by gs_id";
    $pre_opt_row = sql_fetch($pre_opt_sql);
}

// 기존 선택옵션삭제
sql_query(" delete from shop_goods_option where io_type = '0' and gs_id = '$gs_id' ");

$option_count = count($_POST['opt_id']);
if($option_count) {
    // 옵션명
    $opt1_cnt = $opt2_cnt = $opt3_cnt = 0;
    for($i=0; $i<$option_count; $i++) {
        $opt_val = explode(chr(30), $_POST['opt_id'][$i]);
        if($opt_val[0])
            $opt1_cnt++;
        if($opt_val[1])
            $opt2_cnt++;
        if($opt_val[2])
            $opt3_cnt++;
    }

    if($opt1_subject && $opt1_cnt) {
        $it_option_subject = $opt1_subject;
        if($opt2_subject && $opt2_cnt)
            $it_option_subject .= ','.$opt2_subject;
        if($opt3_subject && $opt3_cnt)
            $it_option_subject .= ','.$opt3_subject;
    }
}

// 기존 추가옵션삭제
sql_query(" delete from shop_goods_option where io_type = '1' and gs_id = '$gs_id' ");

$supply_count = count($_POST['spl_id']);
if($supply_count) {
    // 추가옵션명
    $arr_spl = array();
    for($i=0; $i<$supply_count; $i++) {
        $spl_val = explode(chr(30), $_POST['spl_id'][$i]);
        if(!in_array($spl_val[0], $arr_spl))
            $arr_spl[] = $spl_val[0];
    }

    $it_supply_subject = implode(',', $arr_spl);
}

// 상품 정보제공
$value_array = array();
for($i=0; $i<count($_POST['ii_article']); $i++) {
    $key = $_POST['ii_article'][$i];
    $val = $_POST['ii_value'][$i];
    $value_array[$key] = $val;
}
$it_info_value = addslashes(serialize($value_array));

unset($value);
if($_POST['simg_type']) { // URL 입력
	$value['simg1'] = $_POST['simg1'];
	$value['simg2'] = $_POST['simg2'];
	$value['simg3'] = $_POST['simg3'];
	$value['simg4'] = $_POST['simg4'];
	$value['simg5'] = $_POST['simg5'];
	$value['simg6'] = $_POST['simg6'];
} else {
	for($i=1; $i<=6; $i++) {
		if($img = $_FILES['simg'.$i]['name']) {
			if(!preg_match("/\.(gif|jpg|png)$/i", $img)) {
				alert("이미지가 gif, jpg, png 파일이 아닙니다.");
			}
		}
		if($_POST['simg'.$i.'_del']) {
			$upl->del($_POST['simg'.$i.'_del']);
			$value['simg'.$i] = '';
		}
		if($_FILES['simg'.$i]['name']) {
			$value['simg'.$i] = $upl->upload($_FILES['simg'.$i]);
		}
	}
}

//$_POST['gname'] = html_entity_decode($_POST['gname']);

$value['use_aff']		= 0; //본사상품으로 설정
$value['ca_id']			= $_POST['ca_id']; //대표카테고리
$value['ca_id2']		= $_POST['ca_id2']; //추가카테고리2
$value['ca_id3']		= $_POST['ca_id3']; //추가카테고리3
$value['mb_id']			= $_POST['mb_id']; //업체코드
$value['gname']			= $_POST['gname']; //상품명
$value['isopen']		= $_POST['isopen']; //진열상태
$value['explan']		= $_POST['explan']; //짧은설명
$value['keywords']		= $_POST['keywords']; //키워드
$value['admin_memo']	= $_POST['admin_memo']; //관리자메모
$value['memo']			= $_POST['memo']; //상품설명
//$value['memo_euc_kr']	= $_POST['memo']; //상품설명
$value['goods_price']	= conv_number($_POST['goods_price']); //판매가격
$value['supply_price']	= conv_number($_POST['supply_price']); //공급가격
//$value['supply_price']	= conv_number($_POST['goods_price']); //공급가격
$value['normal_price']	= conv_number($_POST['normal_price']); //시중가격
$value['gpoint']		= get_gpoint($value['goods_price'],$_POST['marper'],$_POST['gpoint']);
$value['maker']			= $_POST['maker']; //제조사
$value['make_year']	    = $_POST['make_year']; //생산연도
$value['make_dm']		= $_POST['make_dm']; //제조일자
$value['origin']		= $_POST['origin']; //원산지
$value['model']			= $_POST['model']; //모델명
$value['opt_subject']	= $it_option_subject; //상품 선택옵션
$value['spl_subject']	= $it_supply_subject; //상품 추가옵션
$value['stock_qty']		= conv_number($_POST['stock_qty']); //재고수량
$value['noti_qty']		= conv_number($_POST['noti_qty']); //재고 통보수량
//$value['brand_uid']		= $_POST['brand_uid']; //브랜드주키
//$value['brand_nm']		= get_brand($_POST['brand_uid']); //브랜드명
$value['brand_nm']		= $_POST['brand_nm']; //브랜드명
$value['notax']			= $_POST['notax']; //과세구분
$value['zone']			= $_POST['zone']; //판매가능지역
$value['zone_msg']		= $_POST['zone_msg']; //판매가능지역 추가설명
$value['sc_type']		= $_POST['sc_type']; //배송비 유형	0:공통설정, 1:무료, 2:조건부 무료, 3:유료
$value['sc_method']		= $_POST['sc_method']; //배송비 결제	0:선불, 1:착불, 2:사용자선택
$value['sc_amt']		= conv_number($_POST['sc_amt']); //기본 배송비
$value['sc_minimum']	= conv_number($_POST['sc_minimum']);	//조건 배송비
$value['sc_each_use']	= $_POST['sc_each_use']; //묶음배송불가
$value['info_gubun']	= $_POST['info_gubun']; //상품정보제공 구분
$value['info_value']	= $it_info_value; //상품정보제공 값
$value['price_msg']		= $_POST['price_msg']; //가격 대체문구
$value['stock_mod']		= $_POST['stock_mod']; //수량형식
$value['odr_min']		= conv_number($_POST['odr_min']); //최소 주문한도
$value['odr_max']		= conv_number($_POST['odr_max']); //최대 주문한도
$value['buy_level']		= $_POST['buy_level']; //구매가능 레벨
$value['buy_only']		= $_POST['buy_only']; //가격공개 여부
$value['simg_type']		= $_POST['simg_type']; //이미지 등록방식
$value['sb_date']		= $_POST['sb_date']; //판매 시작일
$value['eb_date']		= $_POST['eb_date']; //판매 종료일
$value['update_time']	= TB_TIME_YMDHIS; //수정일시
$value['sb_check']		= '0'; // 사방넷 송신 확인
$sbflag = false;

// 2023-02-01 출고안내 이미지 자동삽입
if( strpos($value['memo'],"majorworld.godohosting.com/main/delivery_notice_19.jpg") === false ){
	$value['memo'] = "<center><img src=\"http://majorworld.godohosting.com/main/delivery_notice_19.jpg\"></center>".$value['memo'];
}

if($w == "") {
	$value['shop_state'] = $config['seller_reg_auto']; //자동승인여부
	$value['gcode'] = $_POST['gcode']; //상품코드
	$value['reg_time'] = TB_TIME_YMDHIS; //등록일시
	insert("shop_goods", $value);
	$gs_id = sql_insert_id();
    $sbflag = true;
} else if($w == "u") {
    // 2024-01-22
    /*
    $presql = " SELECT supply_price,goods_price,shop_state FROM shop_goods WHERE index_no='$gs_id' ";
    $prerow = sql_fetch($presql);

    if ( ($value['supply_price'] != $prerow['supply_price']) ||  ($value['goods_price'] != $prerow['goods_price']) ) {
        $logmsg = "[공급가격] (".number_format($prerow['supply_price']).")=> (".number_format($value['supply_price']).")로 변경 <br>";
        $logmsg .= "[판매가격] (".number_format($prerow['goods_price']).")=> (".number_format($value['goods_price']).")로 변경 <br>";
        $logsql = "insert into shop_goods_log set gs_id='{$gs_id}', mb_id='".get_session('ss_mb_id')."', update_time='".TB_TIME_YMDHIS."', memo='{$logmsg}' ";
        sql_query($logsql);
	    $value['shop_state'] = $config['seller_mod_auto']; //자동승인여부
    }else{
        if( $prerow['shop_state']==0 ){
            $sbflag = true;
        }
    }
	update("shop_goods", $value," where index_no = '$gs_id'");
    */
    $pre_sql = " SELECT gname,isopen,memo,supply_price,goods_price,shop_state,state_msg FROM shop_goods WHERE index_no='$gs_id' ";
    $pre_row = sql_fetch($pre_sql);
    //$value['shop_state'] = $config['seller_mod_auto']; //자동승인여부
    update("shop_goods", $value," where index_no = '$gs_id'");
}

// 선택옵션등록
if($option_count) {
    $comma = '';
    $sql = " insert into shop_goods_option
                    ( `io_id`, `io_type`, `gs_id`, `io_supply_price`, `io_price`, `io_stock_qty`, `io_noti_qty`, `io_use` )
                VALUES ";
    for($i=0; $i<$option_count; $i++) {
        $sql .= $comma . " ( '{$_POST['opt_id'][$i]}', '0', '$gs_id', '{$_POST['opt_supply_price'][$i]}', '{$_POST['opt_price'][$i]}', '{$_POST['opt_stock_qty'][$i]}', '{$_POST['opt_noti_qty'][$i]}', '{$_POST['opt_use'][$i]}' )";
        $comma = ' , ';
    }
    sql_query($sql);
}

// 2022-06-22
$optsql = " SELECT count(*) as cnt FROM shop_goods_option WHERE io_stock_qty > 0 and io_type = '0'  and gs_id='$gs_id' ";
$optrow = sql_fetch($optsql);
if($optrow['cnt'] <= 0){
    unset($value);
    $value['isopen']		= "2";
	update("shop_goods", $value," where index_no = '$gs_id'");
}


// 추가옵션등록
if($supply_count) {
    $comma = '';
    $sql = " insert into shop_goods_option
                    ( `io_id`, `io_type`, `gs_id`, `io_supply_price`, `io_price`, `io_stock_qty`, `io_noti_qty`, `io_use` )
                VALUES ";
    for($i=0; $i<$supply_count; $i++) {
        $sql .= $comma . " ( '{$_POST['spl_id'][$i]}', '1', '$gs_id', '{$_POST['spl_supply_price'][$i]}', '{$_POST['spl_price'][$i]}', '{$_POST['spl_stock_qty'][$i]}', '{$_POST['spl_noti_qty'][$i]}', '{$_POST['spl_use'][$i]}' )";
        $comma = ' , ';
    }
    sql_query($sql);
}

// 2024-01-22
if($w=="u"){
    $current_sql = " SELECT gname,isopen,memo,supply_price,goods_price,shop_state,state_msg FROM shop_goods WHERE index_no='$gs_id' ";
    $current_row = sql_fetch($current_sql);

    $im_data_change_flsg = false;
    $change_data_list = array();
    $log_msg_list = array();
    if( $pre_row['gname'] != $current_row['gname'] ){
        $logmsg = "[상품명] ({$pre_row['gname']})=> ({$current_row['gname']})로 변경";
        array_push($log_msg_list,$logmsg);
        array_push($change_data_list,"상품명");
        $im_data_change_flag = true;
    }
    if( $current_row['isopen'] != $pre_row['isopen'] && $current_row['isopen'] == 1  ){    
        $logmsg = "[진열상태] ({$gw_isopen[$pre_row['isopen']]})=> ({$gw_isopen[$current_row['isopen']]})로 변경";
        array_push($log_msg_list,$logmsg);
        array_push($change_data_list,"진열상태");
        $im_data_change_flag = true;
    }
    if ( $current_row['supply_price'] != $pre_row['supply_price'] ) {
        $logmsg = "[공급가격] (".number_format($pre_row['supply_price']).")=> (".number_format($current_row['supply_price']).")로 변경";
        array_push($log_msg_list,$logmsg);
        array_push($change_data_list,"공급가");
        $im_data_change_flag = true;
    }
    if ( $current_row['goods_price'] != $pre_row['goods_price'] ) {
        $logmsg = "[판매가격] (".number_format($pre_row['goods_price']).")=> (".number_format($current_row['goods_price']).")로 변경";
        array_push($log_msg_list,$logmsg);
        array_push($change_data_list,"판매가");
        $im_data_change_flag = true;
    }
    if( str_replace(array(" ","\\"),"",$current_row['memo']) != str_replace(array(" ","\\"),"",$pre_row['memo'])  ){
        $logmsg = "[상품상세] 내용 변경";
        array_push($log_msg_list,$logmsg);
        array_push($change_data_list,"상품상세");
        $im_data_change_flag = true;
    }

    $current_opt_sql = " SELECT group_concat(io_id order by io_id) as opt_li FROM shop_goods_option WHERE io_type = '0' and gs_id='$gs_id' group by gs_id";
    $current_opt_row = sql_fetch($current_opt_sql);
    if ( $current_opt_row['opt_li'] != $pre_opt_row['opt_li'] ) {
        $logmsg = "[상품옵션] ({$pre_opt_row['opt_li']})=> ({$current_opt_row['opt_li']})로 변경";
        array_push($log_msg_list,$logmsg);
        array_push($change_data_list,"상품옵션");
        $im_data_change_flag = true;
    }

    if( $im_data_change_flag ){
        unset($value);
        $change_msg = "[".TB_TIME_YMDHIS."] ".implode($change_data_list,",")." 변경";
        if( !empty($pre_row['state_msg']) ){
            $change_msg .= "<br>";
            $change_msg .= $pre_row['state_msg'];
        }

        $value["state_msg"] = $change_msg;
        $value['shop_state'] = $config['seller_mod_auto']; //자동승인여부
        update("shop_goods", $value," where index_no = '$gs_id'");

        for($i=0;$i<count($log_msg_list);$i++){
            $logsql = "insert into shop_goods_log ( gs_id, mb_id, update_time, memo ) values ( '{$gs_id}','".get_session('ss_mb_id')."','".TB_TIME_YMDHIS."','{$log_msg_list[$i]}' )";
            sql_query($logsql);
        }
    }
}

$stt_sql = " SELECT shop_state FROM shop_goods WHERE index_no='$gs_id' ";
$stt_row = sql_fetch($stt_sql);
if( $stt_row['shop_state'] == 0 ){
    $sbflag = true;
}

// 2022-02-16
if($sbflag){
    sb_goods_update($gs_id, get_session('ss_mb_id') );
}
if($w == "")
    goto_url(TB_MYPAGE_URL."/page.php?code=seller_goods_form&w=u&gs_id=$gs_id");
else if($w == "u")
    goto_url(TB_MYPAGE_URL."/page.php?code=seller_goods_form&w=u&gs_id=$gs_id$q1&page=$page&bak=$bak");
?>
