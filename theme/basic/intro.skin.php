<?php
if(!defined('_TUBEWEB_')) exit;

include_once(TB_PATH.'/head.sub.php');
?>

<form name="flogin" action="<?php echo TB_HTTPS_BBS_URL; ?>/login_check.php" onsubmit="return flogin_submit(this);" method="post">
<div id="intro2">
	<div id="int_wrap2">
		<div class="lcont">
            <h1><?php echo display_logo(); ?></h1>
            <h2 class="tit"><b>공급사 로그인</b></h2>
			<dl class="int_login">
				<dd>
					<label for="login_id" class="sound_only">회원아이디</label>
					<input type="text" name="mb_id" id="login_id" class="frm_input" maxLength="20" placeholder="아이디">					
				</dd>
				<dd>
					<label for="login_pw" class="sound_only">비밀번호</label>
					<input type="password" name="mb_password" id="login_pw" class="frm_input" maxLength="20" placeholder="비밀번호">		
				</dd>
				<dt><input type="submit" value="로그인" class="btn_large wset"></dt>
			</dl>
            <!--
			<p class="marb20">
				<input type="checkbox" name="auto_login" id="login_auto_login"> <label for="login_auto_login" class="fs11">자동로그인</label>
			</p>
            -->
			<div class="int_btn">
				<a href="<?php echo TB_BBS_URL; ?>/password_lost.php" onclick="win_open(this,'pop_password_lost','500','400','no');return false;">아이디/비밀번호 찾기</a>
            </div>
            <?php if($config['seller_reg_yes']) { ?>
            <div class="seller_reg_btn">
                <a href="<?php echo TB_BBS_URL; ?>/seller_reg.php" class="btn_lsmall">공급사 회원가입</a>
                <!-- <a href="<?php echo TB_BBS_URL; ?>/partnership_form.php" class="btn_lsmall grey fr">제휴문의</a>-->
			</div>
            <?php } ?>
			<ul class="int-txt">
				<!--<li>업체에서 메이저월드로 공급하는 상품을 관리하는 사이트입니다.</li>-->
                <!--<li>아이디/비밀번호를 분실하신 경우,담당 영업사원에게 문의하시기 바랍니다.</li>-->
				<!--<li>해당 몰로 송신받은 상품은 메이저월드에서 운영/관리하는 채널에 위탁판매하게 됩니다.</li>-->
				<!--<li>아이디/비밀번호를 분실하신 경우, 담당 영업사원에게 문의하시기 바랍니다.</li>-->
				<!--<li>메이저월드 <?php echo $config['company_tel']; ?>(<?php echo $config['company_hours']; ?>)</li>-->
			</ul>
		</div>
    </div>
	<div class="int_copy">
		<?php echo $config['company_name']; ?> <span class="g_hl"></span> 대표자 : <?php echo $config['company_owner']; ?> <span class="g_hl"></span> <?php echo $config['company_addr']; ?><br>
		사업자번호 : <?php echo $config['company_saupja_no']; ?> <a href="javascript:saupjaonopen('<?php echo conv_number($config['company_saupja_no']); ?>');" class="btn_ssmall bx-white marl5">사업자정보확인</a> <span class="g_hl"></span> 통신판매번호 : <?php echo $config['tongsin_no']; ?><br>
		Email : <?php echo $super['email']; ?> <span class="g_hl"></span> 문의전화 : <?php echo $super['cellphone']; ?><br>
		<p class="mart5 fc_137 fs11">Copyright ⓒ <?php echo $config['company_name']; ?> All rights reserved.</p>
	</div>
</div>
</form>

<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f){
	if(!f.mb_id.value){
		alert('아이디를 입력하세요.');
		f.mb_id.focus();
		return false;
	}
	if(!f.mb_password.value){
		alert('비밀번호를 입력하세요.');
		f.mb_password.focus();
		return false;
	}

	return true;
}
</script>

<?php
include_once(TB_PATH."/tail.sub.php");
?>