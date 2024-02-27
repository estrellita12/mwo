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

<form name="fsellerform" id="fsellerform" action="./pop_sellerformupdate.php" method="post"  enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
<input type="hidden" name="seller_code" value="<?php echo $sr['seller_code']; ?>">

<div id="sellerform_pop" class="new_win">
	<h1><?php echo $tb['title']; ?></h1>

	<section class="new_win_desc marb50">

	<?php echo mb_pg_anchor($mb_id); ?>

	<h3 class="anc_tit">사업자정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">입점 승인상태</th>
			<td class="td_label">
				<?php echo radio_checked('state', $sr['state'], '1', '승인'); ?>
				<?php echo radio_checked('state', $sr['state'], '0', '대기'); ?>
			</td>
            <!--
			<th scope="row">전체 상품진열</th>
			<td class="td_label">
				<?php echo radio_checked('seller_open', $sr['seller_open'], '1', '진열'); ?>
				<?php echo radio_checked('seller_open', $sr['seller_open'], '2', '품절'); ?>
				<?php echo radio_checked('seller_open', $sr['seller_open'], '3', '단종'); ?>
				<?php echo radio_checked('seller_open', $sr['seller_open'], '4', '중지'); ?>
			</td>
            -->
		</tr>
		<tr>
			<th scope="row">제공상품</th>
			<td><input type="text" name="seller_item" value="<?php echo $sr['seller_item']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">업체(법인)명</th>
			<td><input type="text" name="company_name" value="<?php echo $sr['company_name']; ?>" class="frm_input" size="30"></td>
        </tr>
		<tr>
			<th scope="row">대표자명</th>
			<td><input type="text" name="company_owner" value="<?php echo $sr['company_owner']; ?>" class="frm_input" size="30"></td>
        </tr>
		<tr>
			<th scope="row">사업자등록번호</th>
			<td><input type="text" name="company_saupja_no" value="<?php echo $sr['company_saupja_no']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">사업자등록증 사본</th>
			<td>
                <?php
                    $file = TB_DATA_PATH.'/common/'.$sr['company_saupja_file'];
                    if(is_file($file) && $sr['company_saupja_file']) {
                        $seal = rpc($file, TB_PATH, TB_URL);
                        $chk_file = mime_content_type($file);
                        console_log($chk_file);
                        if(in_array($chk_file, $allowed_list)){
                            //echo "<iframe src='".$seal."' frameborder='0'></iframe>";
                        }                                                                    
                ?>
                <a href="<?php echo $seal; ?>" class="btn_small" download="사업자등록증_<?php echo $sr['company_name'] ?>">사업자 등록증 사본 다운로드</a>
                <input type="checkbox" name="company_saupja_file_del" value="1" id="company_saupja_file_del" class="marl5">
                <label for="company_saupja_file_del">삭제</label>
                <?php echo help('파일 변경이 필요 할 경우, 삭제 후 진행하여 주시기 바랍니다.'); ?>
                <?php }else{ ?>
                <input type="file" name="company_saupja_file" id="company_saupja_file">
                <?php echo help('등록된 파일이 존재하지 않습니다.'); ?>
                <?php } ?>
            </td>
		</tr>
		<tr>
			<th scope="row">업태</th>
			<td><input type="text" name="company_item" value="<?php echo $sr['company_item']; ?>" class="frm_input" size="30"></td>
        </tr>
		<tr>
			<th scope="row">종목</th>
			<td><input type="text" name="company_service" value="<?php echo $sr['company_service']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">전화번호</th>
			<td><input type="text" name="company_tel" value="<?php echo $sr['company_tel']; ?>" class="frm_input" size="30"></td>
        </tr>
		<tr>
			<th scope="row">팩스번호</th>
			<td><input type="text" name="company_fax" value="<?php echo $sr['company_fax']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">사업장주소</th>
			<td>
				<input type="text" name="company_zip" value="<?php echo $sr['company_zip']; ?>" class="frm_input" size="8" maxlength="5"> <a href="javascript:win_zip('fsellerform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');" class="btn_small grey">주소검색</a>
				<p class="mart5"><input type="text" name="company_addr1" value="<?php echo $sr['company_addr1']; ?>" class="frm_input" size="60"> 기본주소</p>
				<p class="mart5"><input type="text" name="company_addr2" value="<?php echo $sr['company_addr2']; ?>" class="frm_input" size="60"> 상세주소</p>
				<p class="mart5"><input type="text" name="company_addr3" value="<?php echo $sr['company_addr3']; ?>" class="frm_input" size="60"> 참고항목
				<input type="hidden" name="company_addr_jibeon" value="<?php echo $sr['company_addr_jibeon']; ?>"></p>
			</td>
		</tr>
		<tr>
			<th scope="row">통신판매업 신고증 사본</th>
			<td>
                <?php
                    $file = TB_DATA_PATH.'/common/'.$sr['company_report_file'];
                    if(is_file($file) && $sr['company_report_file']) {
                        $seal = rpc($file, TB_PATH, TB_URL);
                        /*
                        $chk_file = mime_content_type($file);
                        if(in_array($chk_file, $allowed_list)){
                            echo "<iframe src='".$seal."' frameborder='0'></iframe>";
                        }   
                        */                                                                 
                ?>
                <a href="<?php echo $seal; ?>" class="btn_small"  download="통신판매업신고증_<?php echo $sr['company_name'] ?>">통신판매업 신고증 사본 다운로드</a>
                <input type="checkbox" name="company_report_file_del" value="1" id="company_report_file_del" class="marl5">
                <label for="company_report_file_del">삭제</label>
                <?php echo help('파일 변경이 필요 할 경우, 삭제 후 진행하여 주시기 바랍니다.'); ?>
                <?php }else{ ?>
                <input type="file" name="company_report_file" id="company_report_file">
                <?php echo help('등록된 파일이 존재하지 않습니다.'); ?>
                <?php } ?>
            </td>
		</tr>

		<tr>
			<th scope="row">홈페이지</th>
			<td><input type="text" name="company_hompage" value="<?php echo $sr['company_hompage']; ?>" class="frm_input" size="40" placeholder="http://"></td>
		</tr>
		<tr>
			<th scope="row">수수료</th>
			<td><input type="text" name="seller_comm" value="<?php echo $sr['seller_comm']; ?>" class="frm_input" size="20" > %</td>
		</tr>
		<tr>
			<th scope="row">전달사항</th>
			<td><textarea name="memo" class="frm_textbox wfull"><?php echo $sr['memo']; ?></textarea></td>
		</tr>
		</tbody>
		</table>
	</div>

	<h3 class="anc_tit mart30">정산계좌 정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">은행명</th>
			<td><input type="text" name="bank_name" value="<?php echo $sr['bank_name']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">계좌번호</th>
			<td><input type="text" name="bank_account" value="<?php echo $sr['bank_account']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">예금주명</th>
			<td><input type="text" name="bank_holder" value="<?php echo $sr['bank_holder']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">법인명의 통장 사본</th>
			<td>
                <?php
                    $file = TB_DATA_PATH.'/common/'.$sr['company_bank_file'];
                    if(is_file($file) && $sr['company_bank_file']) {
                        $seal = rpc($file, TB_PATH, TB_URL);
                        /*
                        $chk_file = mime_content_type($file);
                        if(in_array($chk_file, $allowed_list)){
                            echo "<iframe src='".$seal."' frameborder='0'></iframe>";
                        }   
                        */                 
                ?>
                <a href="<?php echo $seal; ?>" class="btn_small" download="법인명의통장_<?php echo $sr['company_name'] ?>">법인명의 통장 사본 다운로드</a>
                <input type="checkbox" name="company_bank_file_del" value="1" id="company_bank_file_del" class="marl5">
                <label for="company_bank_file_del">삭제</label>
                <?php echo help('파일 변경이 필요 한 경우, 삭제 후 진행하여 주시기 바랍니다.'); ?>
                <?php }else{ ?>
                <input type="file" name="company_bank_file" id="company_bank_file">
                <?php echo help('등록된 파일이 존재하지 않습니다.'); ?>
                <?php } ?>

            </td>
		</tr>


		</tbody>
		</table>
	</div>

	<h3 class="anc_tit mart30">대표 상품 정보</h3>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w170">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">상품 위탁판매 제안서</th>
			<td>
                <?php
                    $file = TB_DATA_PATH.'/common/'.$sr['company_proposal_file'];
                    if(is_file($file) && $sr['company_proposal_file']) {
                        $seal = rpc($file, TB_PATH, TB_URL);
                        /*
                        $chk_file = mime_content_type($file);
                        if(in_array($chk_file, $allowed_list)){
                            echo "<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=".$seal."' width='px' height='px' frameborder='0'></iframe>";
                        } 
                        */                                           
                ?>
                <a href="<?php echo $seal; ?>" class="btn_small" download="상품위탁판매제안서_<?php echo $sr['company_name'] ?>">상품 위탁 판매 제안서 다운로드</a>
                <input type="checkbox" name="company_proposal_file_del" value="1" id="company_proposal_file_del" class="marl5">
                <label for="company_proposal_file_del">삭제</label>
                <?php echo help('파일 변경이 필요 한 경우, 삭제 후 진행하여 주시기 바랍니다.'); ?>
                <?php }else{ ?>
                <input type="file" name="company_proposal_file" id="company_proposal_file">
                <?php echo help('등록된 파일이 존재하지 않습니다.'); ?>
                <?php } ?>
            </td>
		</tr>
		<tr>
			<th scope="row">대표 상품 정보 확인 링크(URL)</th>
			<td><a href="<?php echo $sr['goods_link'] ?>" target="blank">바로가기</a></td>
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
