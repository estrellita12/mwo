<?php
if(!defined('_TUBEWEB_')) exit;
?>
		<?php
		if(!defined('_INDEX_')) { // index가 아니면 실행
			echo '</div>'.PHP_EOL;
		}
		?>
	</div>
	<!-- 카피라이터 시작 { -->
	<div id="ft">
		<div class="company">
			<ul>
				<li>
					<?php echo $config['company_name']; ?> <span class="g_hl"></span> 대표자 : <?php echo $config['company_owner']; ?> <span class="g_hl"></span> <?php echo $config['company_addr']; ?><br>사업자등록번호 : <?php echo $config['company_saupja_no']; ?> <a  href="javascript:saupjaonopen('<?php echo conv_number($config['company_saupja_no']); ?>');" class="btn_ssmall grey2 marl5">사업자정보확인</a> <span class="g_hl"></span> 통신판매업신고 : <?php echo $config['tongsin_no']; ?><br>
Email : <?php echo $super['email']; ?><span class="g_hl"></span>문의전화 : <?php echo $super['cellphone']; ?> <span class="g_hl"></span> FAX : <?php echo $config['company_fax']; ?><br>
개인정보보호책임자 : <?php echo $config['info_name']; ?> (<?php echo $config['info_email']; ?>)
					<p class="etctxt"><?php echo $config['company_name']; ?>의 사전 서면 동의 없이 사이트의 일체의 정보, 콘텐츠 및 UI등을 상업적 목적으로 전재, 전송, 스크래핑 등 무단 사용할 수 없습니다.</p>
					<p class="cptxt">Copyright ⓒ <?php echo $config['company_name']; ?> All rights reserved.</p>
				</li>
			</ul>
		</div>
	</div>

	<script>
	function escrow_foot_check()
	{
		<?php if($default['de_pg_service'] == 'inicis') { ?>
		var mid = "<?php echo $default['de_inicis_mid']; ?>";
		window.open("https://mark.inicis.com/mark/escrow_popup.php?mid="+mid, "escrow_foot_pop","scrollbars=yes,width=565,height=683,top=10,left=10");
		<?php } ?>
		<?php if($default['de_pg_service'] == 'lg') { ?>
		var mid = "<?php echo $default['de_lg_mid']; ?>";
		window.open("https://pgweb.uplus.co.kr/ms/escrow/s_escrowYn.do?mertid="+mid, "escrow_foot_pop","scrollbars=yes,width=465,height=530,top=10,left=10");
		<?php } ?>
		<?php if($default['de_pg_service'] == 'kcp') { ?>
		window.open("", "escrow_foot_pop", "width=500 height=450 menubar=no,scrollbars=no,resizable=no,status=no");

		document.escrow_foot.target = "escrow_foot_pop";
		document.escrow_foot.action = "http://admin.kcp.co.kr/Modules/escrow/kcp_pop.jsp";
		document.escrow_foot.submit();
		<?php } ?>
		<?php if($default['de_pg_service'] == 'nicepay') { ?>
		var mid = "<?php echo $default['de_nicepay_mid']; ?>";
		var CoNo = "<?php echo conv_number($config['company_saupja_no']); ?>";
		window.open("https://pg.nicepay.co.kr/issue/IssueEscrow.jsp?Mid="+mid+"&CoNo="+CoNo, "escrow_foot_pop","width=500,height=380,scrollbars=auto,resizable=yes");
		<?php } ?>
	}
	</script>
	<!-- } 카피라이터 끝 -->
</div>

<?php
if(TB_DEVICE_BUTTON_DISPLAY && !TB_IS_MOBILE && is_mobile()) { ?>
<a href="<?php echo TB_URL; ?>/index.php?device=mobile" id="device_change">모바일 버전으로 보기</a>
<?php } ?>
