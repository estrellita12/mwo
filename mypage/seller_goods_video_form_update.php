<?php
include_once("./_common.php");
include_once('../lib/xml.lib.php');

ajax_check_demo();
//ajax_admin_token();

// input vars 체크
check_input_vars();

if( empty($_POST['gs_id']) ){
    echo "false";
    exit;
}
if( empty($_FILES['gs_video']) ){
    echo "false";
    exit;
}

$gs_id = $_POST['gs_id'];

$file_name = $_FILES["gs_video"]['name'];
$file_type_extension = explode("/",$_FILES["gs_video"]['type']);
$file_type = $file_extension[0];
$file_extension = $file_extension[1];
$extension_str = ".mp4";

$tmp_file_path = $_FILES["gs_video"]["tmp_name"];
$uploaded_file_path = "/home/mwo/public_html/data/video/mwo_{$gs_id}_".date("md_His", TB_SERVER_TIME).$extension_str;
move_uploaded_file($tmp_file_path, $uploaded_file_path);
exec("python3 ../selenium/charlla.py {$uploaded_file_path}", $arr);
if( $arr[0] != "1" ){
    echo "false";
    exit;
}

$value = [];
$value['simg_video'] = $arr[1];
update("shop_goods", $value," where index_no = '{$gs_id}'");
echo "1";

/*
// 2022-02-16
if($sbflag){
    sb_goods_update($gs_id, get_session('ss_mb_id') );
}
if($w == "")
    goto_url(TB_MYPAGE_URL."/page.php?code=seller_goods_form&w=u&gs_id=$gs_id");
else if($w == "u")
    goto_url(TB_MYPAGE_URL."/page.php?code=seller_goods_form&w=u&gs_id=$gs_id$q1&page=$page&bak=$bak");

*/
?>
