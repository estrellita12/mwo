<?php
include_once("./_common.php");
include_once(TB_ADMIN_PATH."/admin_access.php");
include_once(TB_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU6;
$pg_num = 6;
$snb_icon = "<i class=\"ionicons ion-clipboard\"></i>";

if($member['id'] != 'admin' && !$member['auth_'.$pg_num]) {
	alert("접근권한이 없습니다.");
}

if($code == "list")				$pg_title2 = ADMIN_MENU6_01;
if($code == "1")				$pg_title2 = ADMIN_MENU6_02;
if($code == "2")				$pg_title2 = ADMIN_MENU6_03;
if($code == "3")				$pg_title2 = ADMIN_MENU6_04;
if($code == "4")				$pg_title2 = ADMIN_MENU6_05;
if($code == "5")				$pg_title2 = ADMIN_MENU6_06;
if($code == "delivery")			$pg_title2 = ADMIN_MENU6_07;
if($code == "delivery_update")	$pg_title2 = ADMIN_MENU6_07;
if($code == "6")				$pg_title2 = ADMIN_MENU6_08;
if($code == "9")				$pg_title2 = ADMIN_MENU6_09;
if($code == "7")				$pg_title2 = ADMIN_MENU6_10;
if($code == "8")				$pg_title2 = ADMIN_MENU6_11;
if($code == "10")               $pg_title2 = ADMIN_MENU6_13;
if($code == "11")               $pg_title2 = ADMIN_MENU6_14;
if($code == "12")               $pg_title2 = ADMIN_MENU6_15;
if($code == "13")               $pg_title2 = ADMIN_MENU6_16;
if($code == "memo")				$pg_title2 = ADMIN_MENU6_12;

include_once(TB_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
    <?php echo help('※ MWO는 (09:00 ~ 16:00) 10분에 메이저월드 사방넷에서 주문 정보를 수집해 옵니다.'); ?>
    <?php echo help('※ 메이저월드 사방넷에서 주문 정보를 수집해 오기 때문에 사방넷에 존재하지 않는 정보(주문시간, 주문자 정보, 쇼핑몰 정보 등..) 들은 수집이 불가합니다.'); ?>
<br>
	<h1><?php echo $pg_title2; ?></h1>
	<?php
	include_once(TB_ADMIN_PATH."/order/order_{$code}.php");
	?>
</div>

<?php
include_once(TB_ADMIN_PATH."/admin_tail.php");
?>
