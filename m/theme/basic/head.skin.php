<?php
if(!defined("_TUBEWEB_")) exit; // 개별 페이지 접근 불가

include_once(TB_MTHEME_PATH.'/slideMenu.skin.php');
?>

<div id="wrapper">
	<div onclick="history.go(-1);" class="page_cover"><span class="sm_close"></span></div>
    <!--
	<?php if($banner1 = mobile_banner(1, $pt_id)) { // 상단 큰배너 ?>
	<div class="top_ad"><?php echo $banner1; ?></div>
	<?php } ?>
    -->
	<header id="header">
		<div id="m_gnb">
            <?php if($_SESSION['ss_mb_id']){ // 로그인창 아닌 경우  ?>
			<h1 class="logo"><?php echo mobile_display_logo(); ?></h1> 
            <?php }else{ // 로그인창인 경우 ?>
            <h1 class="logo"><a href="<?php echo TB_MURL; ?>"><img src="https://mwd.kr/wp-content/uploads/2020/02/majorworld_logo.png" class="lg_wh"></a></h1>
            <?php } ?>
            <?php if(get_session('ss_mb_id')) echo '<span class="btn_sidem fa fa-navicon"></span>' ?>
			<span class="btn_search fa fa-search"></span>
			<!--<a href="<?php echo TB_MSHOP_URL; ?>/cart.php" class="btn_cart fa fa-shopping-cart"><span class="ic_num"><?php echo get_cart_count(); ?></span></a>-->
		</div>
		<div id="hd_sch">
			<section>
				<form name="fsearch" id="fsearch" method="get" action="<?php echo TB_MSHOP_URL; ?>/search.php" onsubmit="return fsearch_submit(this);" autocomplete="off">
				<input type="hidden" name="hash_token" value="<?php echo TB_HASH_TOKEN; ?>">
				<input type="search" name="ss_tx" value="<?php echo $ss_tx; ?>" class="search_inp" maxlength="20">
				<input type="submit" value="&#xf002;" id="sch_submit">
				</form>
				<script>
				function fsearch_submit(f){
					if(!f.ss_tx.value){
						alert('검색어를 입력하세요.');
						return false;
					}
					return true;
				}
				</script>
			</section>
			<script>
			$(function(){
				// 상단의 검색버튼 누르면 검색창 보이고 끄기
				$('.btn_search').click(function(){
					if($("#hd_sch").css('display') == 'none'){
						$("#hd_sch").slideDown('fast');
						$(this).attr('class','btn_search ionicons ion-android-close');
					} else {
						$("#hd_sch").slideUp('fast');
						$(this).attr('class','btn_search fa fa-search');
					}
				});
			});
			</script>

			<script>
			</script>
		</div>
	</header>

	<!-- content -->
	<div id="container"<?php if(!defined("_MINDEX_")) { ?> class="sub_wrap"<?php } ?>>
		<nav id="gnb">
			<?php
			if($default['de_skin1_menu']) {
				$list_gnb = unserialize(base64_decode($default['de_skin1_menu']));
				$list_cnt = count($list_gnb);
			?>
			<ul>
				<?php for($i=0; $i<$list_cnt; $i++) { ?>
				<li><a href="<?php echo trim($list_gnb[$i]['mobile_href']); ?>"><?php echo trim($list_gnb[$i]['subj']); ?></a></li>
				<?php } ?>
			</ul>
			<?php } ?>
		</nav>

		<script>
		//상단 슬라이드 메뉴
		var menuScroll = null;
		$(window).ready(function() {
			menuScroll = new iScroll('gnb', {
				hScrollbar:false, vScrollbar:false, bounce:false, click:true
			});
		});
		</script>

		<?php if(!defined("_MINDEX_")) { ?>
		<div id="content_title">
			<span><?php echo ($pg['pagename'] ? $pg['pagename'] : $tb['title']); ?></span>
		</div>
		<?php } ?>
