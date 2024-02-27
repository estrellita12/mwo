<?php
if(!defined('TB_SET_TIME_LIMIT')) define('TB_SET_TIME_LIMIT', 0);
@set_time_limit(TB_SET_TIME_LIMIT);

include_once('/home/mwo/public_html/config.php');   // 설정 파일
$dbconfig_file = '/home/mwo/public_html/data/dbconfig.php';
if(file_exists($dbconfig_file)) {
    include_once($dbconfig_file);
    include_once("/home/mwo/public_html/lib/global.lib.php"); // PC+모바일 공통 라이브러리
    include_once("/home/mwo/public_html/lib/common.lib.php"); // PC전용 라이브러리

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
include_once('/home/mwo/public_html/lib/goodsinfo.lib.php');
include_once("/home/mwo/public_html/lib/xml.lib.php"); // PC전용 라이브러리

?>
