<?php
include_once("./_common.php");

include_once("./head.sub.php");
?>

<form name="flogin" id="flogin" action="<?php echo TB_HTTPS_BBS_URL; ?>/login_check2.php" method="post" onsubmit="return flogin_submit(this);" autocomplete="off">

<div class="ptn_wrap">
	<h1 class="ptn_logo"><img src="<?php echo adm_logo_url('basic_logo'); ?>"></h1>
	<div class="ptn_bx">
		<p class="ptn_ttxt"><?php echo $config['company_name']; ?> 공급사를 위한 <span>입점몰 관리자 로그인</span> 페이지입니다.</p>
		<dl>
			<dt>
				<button type="submit" class="btn_large">로그인</button>
				<button type="button" class="btn_large red" onclick="gotoUrl('<?php echo TB_BBS_URL; ?>/seller_reg_from.php');">공급사<br>회원가입</button>
			</dt>
			<dd><input type="text" name="mb_id" tabindex="1" placeholder="아이디를 입력해주세요"></dd>
			<dd><input type="password" name="mb_password" tabindex="2" placeholder="비밀번호를 입력해주세요"></dd>
		</dl>
	</div>
</div>
</form>

<script>
function flogin_submit(f)
{
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
include_once("./tail.sub.php");
?>