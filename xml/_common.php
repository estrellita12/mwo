<?php
$tb_path = array("path"=>"/home/mwo/public_html","url"=>"https://mwo.kr");
include_once($tb_path['path'].'/config.php');   // 설정 파일

$dbconfig_file = TB_DATA_PATH.'/'.TB_DBCONFIG_FILE;
if(file_exists($dbconfig_file)) {
    include_once($dbconfig_file);
    include_once(TB_LIB_PATH."/global.lib.php"); // PC+모바일 공통 라이브러리
    include_once(TB_LIB_PATH."/common.lib.php"); // PC전용 라이브러리

    $connect_db = sql_connect(TB_MYSQL_HOST, TB_MYSQL_USER, TB_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
    $select_db  = sql_select_db(TB_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');

    // mysql connect resource $tb 배열에 저장 - 명랑폐인님 제안
    $tb['connect_db'] = $connect_db;

    sql_set_charset('utf8', $connect_db);
    if(defined('TB_MYSQL_SET_MODE') && TB_MYSQL_SET_MODE) sql_query("SET SESSION sql_mode = ''");
    if(defined(TB_TIMEZONE)) sql_query(" set time_zone = '".TB_TIMEZONE."'");
} else {
    header('Content-Type: text/html; charset=utf-8');
    die($dbconfig_file.' 파일을 찾을 수 없습니다.');
}

//include_once('../common.php');  // 해당 파일 전체 include 대신 위의 코드로 치환
include_once('../lib/goodsinfo.lib.php');
include_once('../lib/xml.lib.php');

function array_xml($arr, $num_prefix = "num_") {
    if(!is_array($arr)) return $arr;
    $result = '';
    foreach($arr as $key => $val) {
        $key = (is_numeric($key)? $num_prefix.$key : $key);
        $result .= '<'.$key.'>'.array_xml($val, $num_prefix).'</'.$key.'>';
    }
    return $result;
}

function get_ctg( $ctg ) {
    // 카테고리 추가시 변경 필수
    $res = array('1','01','008');
    $c1 = substr($ctg,0,3);
    $c2 = substr($ctg,3,3);
    $c3 = substr($ctg,6,3);

    // 골프클럽 카테고리 001
    if($c1=='001') $res[2] = '010';

    // 골프패션 카테고리 002
    if($c1=='002'){
        switch($c2){
            case '001':$res[2] = '005'; break;
            case '002':$res[2] = '005'; break;
            case '003':$res[2] = '001'; break;
            case '004':$res[2] = '002'; break;
            case '005':$res[2] = '008'; break;
        }
    }

    // 골프용품 카테고리 003
    if($c1=='003'){
        switch($c2){
            case '001':$res[2] = '004'; break;
            case '002':$res[2] = '003'; break;
            case '003':$res[2] = '006'; break;
            case '004':$res[2] = '008'; break;
            case '005':$res[2] = '008'; break;
            case '006':$res[2] = '008'; break;
        }
    }

    // 식품 카테고리 011
    if($c1=="011"){
        $res = array('2','206','');
        switch($c2){
            case '001':$res[1] = '201'; break;
            case '002':$res[1] = '206'; break;
            case '003':$res[1] = '203'; break;
            case '004':$res[1] = '204'; break;
        }
    }

    // 홈데코 카테고리 016
    if($c1=="016"){
        $res = array('3','305','');
        switch($c2){
            case '001':$res = array('5','504',''); break;
            case '002':$res = array('5','504',''); break;
            case '003':$res = array('5','504',''); break;
            case '004':$res = array('5','504',''); break;
            case '005':$res = array('3','305',''); break;
            case '006':$res = array('3','309',''); break;
        }
    }

    // 가전/자동차 카테고리 019
    if($c1=="019"){
        $res = array('9','902','');
        switch($c2){
            case '001':$res = array('9','902',''); break;
            case '002':$res = array('9','903',''); break;
            case '003':$res = array('9','901',''); break;
            case '004':$res = array('9','902',''); break;
            case '005':$res = array('9','904',''); break;
            case '006':$res = array('9','902',''); break;
            case '007':$res = array('8','804',''); break;
        }
    }

    return $res;
}

function array_conv($arr) {
    if(!is_array($arr)) return $arr;

    foreach($arr as $key => $val) {
        if( is_array($arr[$key]) ){
            $arr[$key] = array_conv( $arr[$key] );
        }else{
            //if($key=='memo') continue;
            //$arr[$key] = iconv("UTF-8", "EUC-KR", $val);
            $tmp =  mb_convert_encoding($val,"EUC-KR","UTF-8");
            if( !empty($tmp) ) $arr[$key] = $tmp;
        }
    }   
    return $arr;
}
?>
