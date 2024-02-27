<?php
if(!defined('_TUBEWEB_')) exit;

$pg_title = "업체 정보관리";
include_once("./admin_head.sub.php");
?>

<form name="fregform" method="post" action="./seller_info_update.php">
<input type="hidden" name="token" value="">
<h2>사업자 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tr>
		<th scope="row">업체코드</th>
		<td><?php echo $seller['seller_code']; ?></td>
	</tr>
    <tr>
        <th scope="row">제공상품</th>
        <td><input type="text" name="seller_item" value="<?php echo $seller['seller_item']; ?>" required itemname="제공상품" class="required frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">업체(법인)명</th>
        <td><input type="text" name="company_name" value="<?php echo $seller['company_name']; ?>" required itemname="업체(법인)명" class="required frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">대표자명</th>
        <td><input type="text" name="company_owner" value="<?php echo $seller['company_owner']; ?>" required itemname="대표자명" class="required frm_input" size="30"></td>
    </tr>
	<tr>
		<th scope="row">사업자등록번호</th>
		<td><?php echo $seller['company_saupja_no']; ?></td>
	</tr>
    <tr>
        <th scope="row">업태</th>
        <td><input type="text" name="company_item" value="<?php echo $seller['company_item']; ?>" required itemname="업태" class="required frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">종목</th>
        <td><input type="text" name="company_service" value="<?php echo $seller['company_service']; ?>" required itemname="종목" class="required frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">전화번호</th>
        <td><input type="text" name="company_tel" value="<?php echo $seller['company_tel']; ?>" required itemname="전화번호" class="required frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">팩스번호</th>
        <td><input type="text" name="company_fax" value="<?php echo $seller['company_fax']; ?>" class="frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">사업장주소</th>
        <td>
            <p><input type="text" name="company_zip" value="<?php echo $seller['company_zip']; ?>" class="frm_input" size="8" maxlength="5"> <a href="javascript:win_zip('fregform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');" class="btn_small grey">주소검색</a></p>
            <p class="mart3"><input type="text" name="company_addr1" value="<?php echo $seller['company_addr1']; ?>" class="frm_input" size="60"> 기본주소</p>
            <p class="mart3"><input type="text" name="company_addr2" value="<?php echo $seller['company_addr2']; ?>" class="frm_input" size="60"> 상세주소</p>
            <p class="mart3"><input type="text" name="company_addr3" value="<?php echo $seller['company_addr3']; ?>" class="frm_input" size="60"> 참고항목
            <input type="hidden" name="company_addr_jibeon" value="<?php echo $seller['company_addr_jibeon']; ?>"></p>
        </td>
    </tr>
    <tr>
        <th scope="row">홈페이지</th>
        <td>
            <input type="text" name="company_hompage" value="<?php echo $seller['company_hompage']; ?>" class="frm_input" size="30">
            <?php echo help('http://를 포함하여 입력하세요'); ?>
        </td>
    </tr>
	</tbody>
	</table>
</div>

<h2>정산계좌 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
    <tr>
        <th scope="row">은행명</th>
        <td><input type="text" name="bank_name" value="<?php echo $seller['bank_name']; ?>" class="frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">계좌번호</th>
        <td><input type="text" name="bank_account" value="<?php echo $seller['bank_account']; ?>" class="frm_input" size="30"></td>
    </tr>
    <tr>
        <th scope="row">예금주명</th>
        <td><input type="text" name="bank_holder" value="<?php echo $seller['bank_holder']; ?>" class="frm_input" size="30"></td>
    </tr>
	</tbody>
	</table>
</div>

<h2>담당자 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명</th>
		<td><input type="text" name="info_name" value="<?php echo $seller['info_name']; ?>" itemname="담당자명"class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><input type="text" name="info_tel" value="<?php echo $seller['info_tel']; ?>" itemname="담당자 핸드폰" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일</th>
		<td><input type="text" name="info_email" value="<?php echo $seller['info_email']; ?>" email itemname="담당자 이메일" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">네이트온ID(선택)</th>
		<td><input type="text" name="info_nateon" value="<?php echo $seller['info_nateon']; ?>" itemname="담당자 네이트온" class="frm_input" size="30"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>

<h2>정산 담당자 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명  </th>
		<td><input type="text" name="info_name2" value="<?php echo $seller['info_name2']; ?>" itemname="담당자명"class="frm_input" size="30">
<input type="checkbox" id="info2" class="marl5"><label for="info2" class="marl5">담당자 정보와 동일</label>
</td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><input type="text" name="info_tel2" value="<?php echo $seller['info_tel2']; ?>" itemname="담당자 핸드폰" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일 </th>
		<td><input type="text" name="info_email2" value="<?php echo $seller['info_email2']; ?>" email itemname="담당자 이메일" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">네이트온ID(선택)</th>
		<td><input type="text" name="info_nateon2" value="<?php echo $seller['info_nateon2']; ?>" itemname="담당자 네이트온" class="frm_input" size="30"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>

<h2>CS 담당자 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명  </th>
		<td><input type="text" name="info_name3" value="<?php echo $seller['info_name3']; ?>" itemname="담당자명"class="frm_input" size="30">
<input type="checkbox" id="info3" class="marl5"><label for="info3" class="marl5">담당자 정보와 동일</label>
</td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><input type="text" name="info_tel3" value="<?php echo $seller['info_tel3']; ?>" itemname="담당자 핸드폰" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일 </th>
		<td><input type="text" name="info_email3" value="<?php echo $seller['info_email3']; ?>" email itemname="담당자 이메일" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">네이트온ID(선택)</th>
		<td><input type="text" name="info_nateon3" value="<?php echo $seller['info_nateon3']; ?>" itemname="담당자 네이트온" class="frm_input" size="30"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>

<h2>배송 담당자 정보</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명  </th>
		<td><input type="text" name="info_name4" value="<?php echo $seller['info_name4']; ?>" itemname="담당자명"class="frm_input" size="30">

<input type="checkbox" id="info4" class="marl5"><label for="info4" class="marl5">담당자 정보와 동일</label>
</td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><input type="text" name="info_tel4" value="<?php echo $seller['info_tel4']; ?>" itemname="담당자 핸드폰" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일 </th>
		<td><input type="text" name="info_email4" value="<?php echo $seller['info_email4']; ?>" email itemname="담당자 이메일" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">네이트온ID(선택)</th>
		<td><input type="text" name="info_nateon4" value="<?php echo $seller['info_nateon4']; ?>" itemname="담당자 네이트온" class="frm_input" size="30"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>


<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>
<script>
    $("#info2,#info3,#info4").on('click',function(){
        var info_name = $('input[name=info_name]').val();
        var info_tel = $('input[name=info_tel]').val();
        var info_email = $('input[name=info_email]').val();
        var info_nateon = $('input[name=info_nateon]').val();
        var res = $(this).is(':checked');
        var num = ( $(this).attr('id') ).slice(-1) ;
        if(res){
            $('input[name=info_name'+num+']').val(info_name);
            $('input[name=info_tel'+num+']').val(info_tel);
            $('input[name=info_email'+num+']').val(info_email);
            $('input[name=info_nateon'+num+']').val(info_nateon);
        }
    });
    
</script>

<?php
include_once("./admin_tail.sub.php");
?>
