<?php
if(!defined('_TUBEWEB_')) exit;
?>

<script src="<?php echo TB_JS_URL; ?>/jquery.register_form.js"></script>

<form name="fsellerform" id="fsellerform" action="<?php echo $from_action_url; ?>" onsubmit="return fsellerform_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<div class="fsellerform_term">
	<h2>공급사 이용약관</h2>
	<textarea readonly><?php echo $config['seller_reg_agree']; ?></textarea>
	<fieldset class="fsellerform_agree">
		<input type="checkbox" name="agree" value="1" id="agree11" class="css-checkbox">
		<label for="agree11" class="css-label">위 내용을 읽었으며 약관에 동의합니다.</label>
	</fieldset>
</div>

<div class="fsellerform_term">
	<h2>개인정보 수집 및 이용</h2>
	<textarea readonly><?php echo $config['shop_private']; ?></textarea>
	<fieldset class="fsellerform_agree">
		<input type="checkbox" name="agree3" value="1" id="agree31" class="css-checkbox">
		<label for="agree31" class="css-label">개인정보 수집 및 이용 내용에 동의합니다.</label>
	</fieldset>
</div>

<div class="fsellerform_agree2">
	<input type="checkbox" name="chk_all" value="1" id="chk_all" class="css-checkbox">
	<label for="chk_all" class="css-label">모든 약관을 확인하고 전체 동의합니다.</label>
</div>

<?php if(!$is_member) { ?>
<h3 class="anc_tit">사이트 이용정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_mb_id">아이디</label></th>
		<td>
			<input type="text" name="mb_id" id="reg_mb_id" required memberid itemname="아이디" class="required frm_input" size="20" minlength="3" maxlength="20">
			<span class="frm_info" id="msg_mb_id">최소 3자이상의 영문자, 숫자, _ 만 입력</span>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_password">비밀번호</label></th>
		<td>
			<input type="password" name="mb_password" id="reg_mb_password" required itemname="비밀번호" class="required frm_input" size="20" minlength="4" maxlength="20">
			<span class="frm_info">4자 이상의 영문 및 숫자</span>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_password_re">비밀번호확인</label></th>
		<td><input type="password" name="mb_password_re" id="reg_mb_password_re" required itemname="비밀번호확인" class="required frm_input" size="20" minlength="4" maxlength="20"></td>
	</tr>
	</tbody>
	</table>
</div>
<?php } ?>

<h3 class="anc_tit">사업자정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_seller_item">제공상품</label></th>
		<td><input type="text" name="seller_item" id="reg_seller_item" required itemname="제공상품" class="required frm_input" size="20" placeholder="예) 가전제품"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_name">업체(법인)명</label></th>
		<td><input type="text" name="company_name" id="reg_company_name" required itemname="업체(법인)명" class="required frm_input" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_owner">대표자명</label></th>
		<td><input type="text" name="company_owner" id="reg_company_owner" required itemname="대표자명" class="required frm_input" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_saupja_no">사업자등록번호</label></th>
		<td><input type="text" name="company_saupja_no" id="reg_company_saupja_no" required itemname="사업자등록번호" class="required frm_input" size="20" placeholder="예) 206-23-12552"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_item">업태</label></th>
		<td><input type="text" name="company_item" id="reg_company_item" required itemname="업태" class="required frm_input" size="20" placeholder="예) 서비스업"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_service">종목</label></th>
		<td><input type="text" name="company_service" id="reg_company_service" required itemname="종목" class="required frm_input" size="20" placeholder="예) 전자상거래업"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_tel">전화번호</label></th>
		<td><input type="text" name="company_tel" id="reg_company_tel" class="frm_input" size="20" placeholder="예) 02-1234-5678"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_fax">팩스번호</label></th>
		<td><input type="text" name="company_fax" id="reg_company_fax" class="frm_input" size="20" placeholder="예) 02-1234-5678"></td>
	</tr>
	<tr>
		<th scope="row">사업장주소</th>
		<td>
			<label for="reg_company_zip" class="sound_only">우편번호</label>
			<input type="text" name="company_zip" id="reg_company_zip" required itemname="우편번호" class="required frm_input" size="5" maxlength="5" readonly>
			<button type="button" class="btn_small grey" onclick="win_zip('fsellerform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');">주소검색</button><br>

			<label for="reg_company_addr1" class="sound_only">주소</label>
			<input type="text" name="company_addr1" id="reg_company_addr1" required itemname="기본주소" class="required frm_input frm_address" readonly><br>

			<label for="reg_company_addr2" class="sound_only">상세주소</label>
			<input type="text" name="company_addr2" id="reg_company_addr2" class="frm_input frm_address"><br>

			<label for="reg_company_addr3" class="sound_only">참고항목</label>
			<input type="text" name="company_addr3" id="reg_company_addr3" class="frm_input frm_address" readonly>
			<input type="hidden" name="company_addr_jibeon" value="">
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_hompage">홈페이지</label></th>
		<td><input type="text" name="company_hompage" id="reg_company_hompage" class="frm_input" size="20" placeholder="예) http://homepage.com"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_memo">전달사항</label></th>
		<td><textarea name="memo" id="reg_memo" rows="10" class="frm_textbox h60"></textarea></td>
	</tr>
	</tbody>
	</table>
</div>

<h3 class="anc_tit">입금계좌정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_bank_name">은행명</label></th>
		<td><input type="text" name="bank_name" id="reg_bank_name" class="frm_input" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_bank_account">계좌번호</label></th>
		<td><input type="text" name="bank_account" id="reg_bank_account" class="frm_input" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_bank_holder">예금주명</label></th>
		<td><input type="text" name="bank_holder" id="reg_bank_holder" class="frm_input" size="20"></td>
	</tr>
	</tbody>
	</table>
</div>

<h3 class="anc_tit">담당자정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_info_name">담당자명</label></th>
		<td><input type="text" name="info_name" id="reg_info_name" required itemname="담당자명" class="required frm_input" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_info_tel">담당자 핸드폰</label></th>
		<td><input type="text" name="info_tel" id="reg_info_tel" required itemname="담당자 핸드폰" class="required frm_input" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_info_email">담당자 이메일</label></th>
		<td><input type="text" name="info_email" id="reg_info_email" required email itemname="담당자 이메일" class="required frm_input" size="20"></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="신청하기" id="btn_submit" class="btn_medium wset" accesskey="s">
	<a href="<?php echo TB_URL; ?>" class="btn_medium bx-white">취소</a>
</div>
</form>

<script>
function fsellerform_submit(f) {
	if(!f.agree.checked) {
		alert("공급사 이용약관 내용에 동의하셔야 신청 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}
	if(!f.agree3.checked) {
		alert("개인정보 수집 및 이용 내용에 동의하셔야 신청 하실 수 있습니다.");
		f.agree3.focus();
		return false;
	}

	<?php if(!$is_member) { // 비회원인가? ?>
	// 회원아이디 검사
	var msg = reg_mb_id_check();
	if(msg) {
		alert(msg);
		f.mb_id.select();
		return false;
	}

	if(f.mb_password.value.length < 4) {
		alert("비밀번호를 4글자 이상 입력하십시오.");
		f.mb_password.focus();
		return false;
	}

	if(f.mb_password.value != f.mb_password_re.value) {
		alert("비밀번호가 같지 않습니다.");
		f.mb_password_re.focus();
		return false;
	}

	if(f.mb_password.value.length > 0) {
		if(f.mb_password_re.value.length < 4) {
			alert("비밀번호를 4글자 이상 입력하십시오.");
			f.mb_password_re.focus();
			return false;
		}
	}
	<?php } ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}

jQuery(function($){
	// 모두선택
	$("input[name=chk_all]").click(function() {
		if ($(this).prop('checked')) {
			$("input[name^=agree]").prop('checked', true);
		} else {
			$("input[name^=agree]").prop("checked", false);
		}
	});

	$("input[name^=agree]").click(function() {
		$("input[name=chk_all]").prop("checked", false);
	});
});
</script>
