<?php
if(!defined('_TUBEWEB_')) exit;

$pg_title = "스킨관리_skin1";
include_once("./admin_head.sub.php");

$pname_run = 0;
for($i=0; $i<count($gw_menu); $i++) {
	$seq = ($i+1);
	if(!$partner['de_pname_'.$seq]) {
		$pname_run++;
	}
}

if($pname_run) {
	for($i=0; $i<count($gw_menu); $i++) {
		$seq = ($i+1);
		$partner['de_pname_'.$seq] = $default['de_pname_'.$seq];
	}
}

if(!$partner['de_skin1_menu']) $partner['de_skin1_menu'] = $default['de_skin1_menu'];
if(!$partner['de_skin1_best']) $partner['de_skin1_best'] = $default['de_skin1_best'];
if(!$partner['de_skin1_name']) $partner['de_skin1_name'] = $default['de_skin1_name'];
?>

<form name="fregform" method="post" action="./partner_skin1_form_update.php">
<input type="hidden" name="token" value="">

<h2>상단 메뉴바</h2>
<div class="tbl_head01">
	<table class="tablef">
	<colgroup>
		<col class="w80">
		<col class="w180">
		<col>
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">메뉴</th>
		<th scope="col">PC URL</th>
		<th scope="col">모바일 URL</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$list = unserialize(base64_decode($partner['de_skin1_menu']));
	for($i=0; $i<10; $i++) {
	?>
	<tr>
		<td class="list1">메뉴<?php echo ($i+1); ?></td>
		<td><input type="text" name="menu_subj[]" value="<?php echo $list[$i]['subj']; ?>" class="frm_input" placeholder="메뉴명"></td>
		<td><input type="text" name="menu_href[]" value="<?php echo $list[$i]['href']; ?>" class="frm_input" placeholder="PC URL"></td>
		<td><input type="text" name="menu_mobile_href[]" value="<?php echo $list[$i]['mobile_href']; ?>" class="frm_input" placeholder="모바일 URL"></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<h2>기본 메뉴명</h2>
<div class="tbl_head01">
	<table class="tablef">
	<colgroup>
		<col class="w80">
		<col class="w180">
		<col>
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">메뉴</th>
		<th scope="col">PC URL</th>
		<th scope="col">모바일 URL</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="th_bg" rowspan="8">기본메뉴</td>
		<td class="tal"><input type="text" name="de_pname_1" value="<?php echo $partner['de_pname_1']; ?>" class="frm_input" placeholder="쇼핑특가"></td>
		<td class="tal url"><a href="/shop/listtype.php?type=1" target="_blank">/shop/listtype.php?type=1</a></td>
		<td class="tal url"><a href="/m/shop/listtype.php?type=1" target="_blank">/m/shop/listtype.php?type=1</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_2" value="<?php echo $partner['de_pname_2']; ?>" class="frm_input" placeholder="베스트셀러"></td>
		<td class="tal url"><a href="/shop/listtype.php?type=2" target="_blank">/shop/listtype.php?type=2</a></td>
		<td class="tal url"><a href="/m/shop/listtype.php?type=2" target="_blank">/m/shop/listtype.php?type=2</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_3" value="<?php echo $partner['de_pname_3']; ?>" class="frm_input" placeholder="신상품"></td>
		<td class="tal url"><a href="/shop/listtype.php?type=3" target="_blank">/shop/listtype.php?type=3</a></td>
		<td class="tal url"><a href="/m/shop/listtype.php?type=3" target="_blank">/m/shop/listtype.php?type=3</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_4" value="<?php echo $partner['de_pname_4']; ?>" class="frm_input" placeholder="인기상품"></td>
		<td class="tal url"><a href="/shop/listtype.php?type=4" target="_blank">/shop/listtype.php?type=4</a></td>
		<td class="tal url"><a href="/m/shop/listtype.php?type=4" target="_blank">/m/shop/listtype.php?type=4</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_5" value="<?php echo $partner['de_pname_5']; ?>" class="frm_input" placeholder="추천상품"></td>
		<td class="tal url"><a href="/shop/listtype.php?type=5" target="_blank">/shop/listtype.php?type=5</a></td>
		<td class="tal url"><a href="/m/shop/listtype.php?type=5" target="_blank">/m/shop/listtype.php?type=5</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_6" value="<?php echo $partner['de_pname_6']; ?>" class="frm_input" placeholder="브랜드샵"></td>
		<td class="tal url"><a href="/shop/brand.php" target="_blank">/shop/brand.php</a></td>
		<td class="tal url"><a href="/m/shop/brand.php" target="_blank">/m/shop/brand.php</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_7" value="<?php echo $partner['de_pname_7']; ?>" class="frm_input" placeholder="기획전"></td>
		<td class="tal url"><a href="/shop/plan.php" target="_blank">/shop/plan.php</a></td>
		<td class="tal url"><a href="/m/shop/plan.php" target="_blank">/m/shop/plan.php</a></td>
	</tr>
	<tr>
		<td class="tal"><input type="text" name="de_pname_8" value="<?php echo $partner['de_pname_8']; ?>" class="frm_input" placeholder="타임세일"></td>
		<td class="tal url"><a href="/shop/timesale.php" target="_blank">/shop/timesale.php</a></td>
		<td class="tal url"><a href="/m/shop/timesale.php" target="_blank">/m/shop/timesale.php</a></td>
	</tr>
	</tbody>
	</table>
</div>

<h2>제품별 베스트</h2>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col width="80px">
		<col width="230px">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">명칭</th>
		<th scope="col">상품코드</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td class="list1">타이틀명</td>
		<td><input type="text" name="de_skin1_name" value="<?php echo $partner['de_skin1_name']; ?>" class="frm_input" placeholder="최상위 타이틀명"></td>
		<td></td>
	</tr>
	<?php
	$list = unserialize(base64_decode($partner['de_skin1_best']));
	for($i=0; $i<10; $i++) {
	?>
	<tr>
		<td class="list1">탭메뉴 <?php echo ($i+1); ?></td>
		<td><input type="text" name="item_subj[]" value="<?php echo $list[$i]['subj']; ?>" class="frm_input" placeholder="탭메뉴명"></td>
		<td><input type="text" name="item_code[]" value="<?php echo $list[$i]['code']; ?>" class="frm_input" placeholder="상품코드 입력 콤마(,)로 구분하세요."></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>

<?php
include_once("./admin_tail.sub.php");
?>