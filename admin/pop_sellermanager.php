<?php
define('_NEWWIN_', true);
include_once('./_common.php');
include_once('./_head.php');
include_once(TB_ADMIN_PATH."/admin_access.php");

$tb['title'] = "공급사정보수정";
include_once(TB_ADMIN_PATH."/admin_head.php");

$mb = get_member($mb_id);
$sr = get_seller($mb_id);

//출력파일 형식 체크 Allowed 리스트
$allowed_list = array("application/pdf", "application/vnd.ms-office", "image/png");
?>

<form name="fsellerform" id="fsellerform" action="./pop_sellermanagerupdate.php" method="post">
<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
<input type="hidden" name="seller_code" value="<?php echo $sr['seller_code']; ?>">

<div id="sellerform_pop" class="new_win">
	<h1><?php echo $tb['title']; ?></h1>

	<section class="new_win_desc marb50">

	<?php echo mb_pg_anchor($mb_id); ?>

	<h3 class="anc_tit mart30">담당자 정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">담당자명</th>
			<td><input type="text" name="info_name" value="<?php echo $sr['info_name']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 핸드폰</th>
			<td><input type="text" name="info_tel" value="<?php echo $sr['info_tel']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 이메일</th>
			<td><input type="text" name="info_email" value="<?php echo $sr['info_email']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 네이트온ID</th>
			<td><input type="text" name="info_nateon" value="<?php echo $sr['info_nateon']; ?>" class="frm_input" size="30"></td>
		</tr>
		</tbody>
		</table>
	</div>
	<h3 class="anc_tit mart30">정산 담당자 정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">담당자명</th>
			<td><input type="text" name="info_name2" value="<?php echo $sr['info_name2']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 핸드폰</th>
			<td><input type="text" name="info_tel2" value="<?php echo $sr['info_tel2']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 이메일</th>
			<td><input type="text" name="info_email2" value="<?php echo $sr['info_email2']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 네이트온ID</th>
			<td><input type="text" name="info_nateon2" value="<?php echo $sr['info_nateon2']; ?>" class="frm_input" size="30"></td>
		</tr>
		</tbody>
		</table>
	</div>
	<h3 class="anc_tit mart30">CS 담당자 정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">담당자명</th>
			<td><input type="text" name="info_name3" value="<?php echo $sr['info_name3']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 핸드폰</th>
			<td><input type="text" name="info_tel3" value="<?php echo $sr['info_tel3']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 이메일</th>
			<td><input type="text" name="info_email3" value="<?php echo $sr['info_email3']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 네이트온ID</th>
			<td><input type="text" name="info_nateon3" value="<?php echo $sr['info_nateon3']; ?>" class="frm_input" size="30"></td>
		</tr>
		</tbody>
		</table>
	</div>
	<h3 class="anc_tit mart30">배송 담당자 정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">담당자명</th>
			<td><input type="text" name="info_name4" value="<?php echo $sr['info_name4']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 핸드폰</th>
			<td><input type="text" name="info_tel4" value="<?php echo $sr['info_tel4']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 이메일</th>
			<td><input type="text" name="info_email4" value="<?php echo $sr['info_email4']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 네이트온ID</th>
			<td><input type="text" name="info_nateon4" value="<?php echo $sr['info_nateon4']; ?>" class="frm_input" size="30"></td>
		</tr>
		</tbody>
		</table>
	</div>
	
	<div class="btn_confirm">
		<input type="submit" value="저장" class="btn_medium" accesskey="s">
		<button type="button" class="btn_medium bx-white" onclick="window.close();">닫기</button>
	</div>
	</section>
</div>
</form>

<?php
include_once(TB_ADMIN_PATH."/admin_tail.sub.php");
?>
