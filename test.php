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

/*
function get_columns($tablename){
	$columns = array();
    $res = sql_query("SHOW COLUMNS FROM {$tablename}");
    while($row=sql_fetch_array($res)) {
        $columns[] = $row["Field"];
    }
    return $columns;
}
*/

// 특정필드는 제외
$columns = get_columns("shop_goods");
$columns = array_diff($columns, array("info_value", "info_gubun", "memo", "admin_memo","certno","avlst_dm","avled_dm","issuedate","certdate","cert_agency","certfield","material","make_year","make_dm","season","sex","model_no","sb_check","sbcode"));
$sql = " select ".implode(",",$columns)." from shop_goods where index_no='3971'";
$gs = sql_fetch( $sql );
$od_goods = serialize($gs);
print_r($od_goods);

?>
