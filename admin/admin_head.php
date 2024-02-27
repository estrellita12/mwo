<?php
if(!defined('_TUBEWEB_')) exit;

if(!$tb['title'])
    $tb['title'] = '관리자 페이지';

$tb['lo_location'] = addslashes($tb['title']);
if(!$tb['lo_location'])
    $tb['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$tb['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));



?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><?php echo $tb['title']; ?></title>
<link rel="stylesheet" href="<?php echo TB_ADMIN_URL; ?>/css/admin.css?ver=<?php echo TB_CSS_VER; ?>">
<?php if($ico = display_logo_url('favicon_ico')) { // 파비콘 ?>
<link rel="shortcut icon" href="<?php echo $ico; ?>" type="image/x-icon">
<?php } ?>
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var tb_url		 = "<?php echo TB_URL; ?>";
var tb_bbs_url	 = "<?php echo TB_BBS_URL; ?>";
var tb_shop_url  = "<?php echo TB_SHOP_URL; ?>";
var tb_admin_url = "<?php echo TB_ADMIN_URL; ?>";
</script>
<script src="<?php echo TB_JS_URL; ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo TB_JS_URL; ?>/jquery-ui-1.10.3.custom.js"></script>
<script src="<?php echo TB_JS_URL; ?>/common.js?ver=<?php echo TB_JS_VER; ?>"></script>
<script src="<?php echo TB_JS_URL; ?>/categorylist.js?ver=<?php echo TB_JS_VER; ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.jquery.min.js" integrity="sha512-MbDx1x0iTEQCAUPl8rkCL5QKfPGVRgxZWodQm1+dJ936z/MHayw4L9p/M0kpD3xpvtb/lYEFRUuQnInmwiKTmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function(){	
    $('.smartSelect').chosen({ //해당 클래스 selectbox에 검색기능 추가
        no_results_text: "검색 결과가 없습니다",
        search_contains : true,
    });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.css" integrity="sha512-cm7yvgAX8av8cXybw6ZxVdmC0L6dOBwdszHDOBEFCntm1LuaSZyDeIeL261f2jm1jolnA6N5P+2NGakEHrgC7Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
