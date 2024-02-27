<?php
if(!defined('_TUBEWEB_')) exit;
?>

<script src="<?php echo TB_JS_URL; ?>/jquery.register_form.js"></script>

<h2 class="pg_tit">
    <span><?php echo $tb['title']?></span>
    <p class="pg_nav">온라인 입점 신청<i class="ionicons ion-ios-arrow-right"></i>정보 입력</p>
</h2>
<div class="seller_reg_bx">
    <ul>
        <li>입점 안내 및 약관 동의</li>
        <li class="selected">정보 입력</li>
        <li>입점 신청 완료</li>
    </ul>
</div>


<form name="fsellerform" id="fsellerform" action="<?php echo $from_action_url; ?>" enctype="MULTIPART/FORM-DATA" onsubmit="return fsellerform_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<?php if(!$is_member) { ?>
<h3 class="anc_tit mart30">서비스 이용정보 입력</h3>
<div class="tbl_frm01">
	<table class="tablef">
	<colgroup>
		<col class="w170">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_mb_id">아이디 <span style="color:#f33e31">(*)</span></label></th>
		<td>
			<input type="text" name="mb_id" id="reg_mb_id" required memberid itemname="아이디" class="required frm_input" size="30" minlength="3" maxlength="20">
			<span id="msg_mb_id"></span><em>영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</em>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_password">비밀번호 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="password" name="mb_password" id="reg_mb_password" required itemname="비밀번호" class="required frm_input" size="30" minlength="4" maxlength="20"><em> 4자 이상의 영문 및 숫자</em></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_password_re">비밀번호확인 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="password" name="mb_password_re" id="reg_mb_password_re" required itemname="비밀번호확인" class="required frm_input" size="30" minlength="4" maxlength="20"></td>
	</tr>
	</tbody>
	</table>
</div>
<?php } ?>

<h3 class="anc_tit mart30">사업자정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w170">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_seller_item">제공상품 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="seller_item" id="reg_seller_item" required itemname="제공상품" class="required frm_input" size="30" placeholder="예) 가전제품"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_name">업체(법인)명 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="company_name" id="reg_company_name" required itemname="업체(법인)명" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_owner">대표자명 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="company_owner" id="reg_company_owner" required itemname="대표자명" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_saupja_no">사업자등록번호 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="company_saupja_no" id="reg_company_saupja_no" required itemname="사업자등록번호" class="required frm_input" size="30" placeholder="예) 206-23-12552"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_saupja_file">사업자등록증 사본 <span style="color:#f33e31">(*)</span></label></th>
        <td>
            <input type="file" name="company_saupja_file" id="reg_company_saupja_file" required>
            <?php echo help('이미지 파일 및 pdf 파일만 업로드 가능하며,용량이 1MB를 넘는 경우 업로드가 실패 될 수 있습니다.','fc_084'); ?>        
        </td>
	</tr>
           
	<tr>
		<th scope="row"><label for="reg_company_item">업태 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="company_item" id="reg_company_item" required itemname="업태" class="required frm_input" size="30" placeholder="예) 서비스업"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_service">종목 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="company_service" id="reg_company_service" required itemname="종목" class="required frm_input" size="30" placeholder="예) 전자상거래업"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_tel">전화번호</label></th>
		<td><input type="text" name="company_tel" id="reg_company_tel" class="frm_input" size="30" placeholder="예) 02-1234-5678"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_fax">팩스번호</label></th>
		<td><input type="text" name="company_fax" id="reg_company_fax" class="frm_input" size="30" placeholder="예) 02-1234-5678"></td>
	</tr>
	<tr>
		<th scope="row">사업장주소 <span style="color:#f33e31">(*)</span></th>
		<td>
			<label for="reg_company_zip" class="sound_only">우편번호</label>
			<input type="text" name="company_zip" id="reg_company_zip" required itemname="우편번호" class="required frm_input" size="8" maxlength="5" readonly>
			<button type="button" class="btn_small grey" onclick="win_zip('fsellerform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');">주소검색</button><br>

			<label for="reg_company_addr1" class="sound_only">주소</label>
			<input type="text" name="company_addr1" id="reg_company_addr1" required itemname="기본주소" class="required frm_input frm_address" size="60" readonly> 기본주소<br>

			<label for="reg_company_addr2" class="sound_only">상세주소</label>
			<input type="text" name="company_addr2" id="reg_company_addr2" class="frm_input frm_address" size="60"> 상세주소<br>

			<label for="reg_company_addr3" class="sound_only">참고항목</label>
			<input type="text" name="company_addr3" id="reg_company_addr3" class="frm_input frm_address" size="60" readonly> 참고항목
			<input type="hidden" name="company_addr_jibeon" value="">
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_report_file">통신판매업 신고증 사본</label></th>
        <td>
            <input type="file" name="company_report_file" id="reg_company_report_file">
            <?php echo help('이미지 파일 및 pdf 파일만 업로드 가능하며,용량이 1MB를 넘는 경우 업로드가 실패 될 수 있습니다.','fc_084'); ?>        
        </td>
	</tr>

	<tr>
		<th scope="row"><label for="reg_company_hompage">홈페이지</label></th>
		<td><input type="text" name="company_hompage" id="reg_company_hompage" class="frm_input" size="30" placeholder="예) http://homepage.com"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_memo">전달사항</label></th>
		<td><textarea name="memo" id="reg_memo" rows="10" class="frm_textbox wfull h60"></textarea></td>
	</tr>
	</tbody>
	</table>
</div>

<h3 class="anc_tit mart30">입금계좌정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w170">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_bank_name">은행명 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="bank_name" id="reg_bank_name" class="frm_input required" size="30" required></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_bank_account">계좌번호 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="bank_account" id="reg_bank_account" class="frm_input required" size="30" required></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_bank_holder">예금주명 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="bank_holder" id="reg_bank_holder" class="frm_input required" size="30" required></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_company_bank_file">통장 사본 <span style="color:#f33e31">(*)</span></label></th>
        <td>
            <input type="file" name="company_bank_file" id="reg_company_bank_file" required>
            <?php echo help('이미지 파일 및 pdf 파일만 업로드 가능하며,용량이 1MB를 넘는 경우 업로드가 실패 될 수 있습니다.','fc_084'); ?>        
        </td>        
	</tr>

	</tbody>
	</table>
</div>

<h3 class="anc_tit mart30">담당자정보 입력</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w170">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_info_name">담당자명 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="info_name" id="reg_info_name" required itemname="담당자명" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_info_tel">담당자 핸드폰 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="info_tel" id="reg_info_tel" required itemname="담당자 핸드폰" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_info_email">담당자 이메일 <span style="color:#f33e31">(*)</span></label></th>
		<td><input type="text" name="info_email" id="reg_info_email" required email itemname="담당자 이메일" class="required frm_input" size="30"></td>
	</tr>
    <tr>
		<th scope="row"><label for="goods_link">대표 상품 정보 확인 링크(URL) <span style="color:#f33e31">(*)</span></label></th>
		<td>
            <input type="text" name="goods_link" id="goods_link" class="required frm_input" size="50">
        </td>
	</tr>    
    <!--
	<tr>
		<th scope="row"><label for="reg_company_proposal_file">상품 위탁판매 제안서 양식 <span style="color:#f33e31">(*)</span></label></th>
        <td>
            <input type="file" name="company_proposal_file" id="reg_company_proposal_file" required>
            <a href="/seller_download.xlsx" class="btn_small">위탁판매 제안서 양식_(업체명) 샘플 다운로드</a>
            <?php echo help('*.xls, *.xlsx 엑셀 형식만 업로드 가능하며, 용량이 1MB를 넘는 경우 업로드가 실패 될 수 있습니다.','fc_084'); ?>        
        </td>
	</tr>    
    --> 
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="신청하기" id="btn_submit" class="btn_large wset" accesskey="s">
	<a href="<?php echo TB_URL; ?>" class="btn_large bx-white">취소</a>
</div>
</form>

<!--2023-12-12 임시 로딩창 구현 시작 (js/wrest.js 파일 내 onsubmit 로직에서 작동)-->
<div 
	id="sellerSubmitLoading" 
	style="
		display:none;
		position:absolute; 
		left:0; 
		top:-200px;
		width:100%; 
		height:140%; 
		background:rgb(0,0,0,0.5);
		text-align:center;
		padding-top:1300px;
		z-index:1000;
	"
>
	<div 
		style="
			display: inline-block;
			width: 50px;
			height: 50px;
			border: 4px solid rgba(0, 0, 0, 0.2);
			border-top-color: white;
			border-radius: 50%;
			animation: custom_spin 1s ease-in-out infinite;	
		"
	>
	</div>
	<div
		style="
			line-height:100px;
			color:white;
			font-weight:bold;
			font-size:25px;
			vertical-align:middle;
		"
	>
		작업을 처리 중입니다. 잠시만 기다려 주세요...
	</div>
</div>
<!--2023-12-12 임시 로딩창 구현 끝-->

<script>
function fsellerform_submit(f) {
/*
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
*/
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