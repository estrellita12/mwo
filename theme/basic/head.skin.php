<?php
if(!defined('_TUBEWEB_')) exit;

if(defined('_INDEX_')) { // index에서만 실행
	include_once(TB_LIB_PATH.'/popup.inc.php'); // 팝업레이어
}
?>

<div id="wrapper">
    <div id="header2">
        <div id="tnb2">
            <div id="tnb_inner2">
                <?php echo display_logo();?>
                <ul>
                    <?php
                    $tnb = array();
                    if($is_admin)
                        $tnb[] = '<li><a href="'.$is_admin.'" target="_blank" class="fc_eb7">관리자</a></li>';
                    if($is_member) {
                        $tnb[] = '<li><a href="'.TB_BBS_URL.'/logout.php" >로그아웃</a></li>';
                    } else {
                        $tnb[] = '<li><a href="'.TB_BBS_URL.'/login.php?url='.$urlencode.'" >로그인</a></li>';
                        $tnb[] = '<li><a href="'.TB_BBS_URL.'/seller_reg.php" >입점신청</a></li>';
                    }
                    /*
                    $tnb[] = '<li><a href="'.TB_SHOP_URL.'/mypage.php">마이페이지</a></li>';
                    $tnb[] = '<li><a href="'.TB_SHOP_URL.'/cart.php">장바구니<span class="ic_num">'. get_cart_count().'</span></a></li>';
                    $tnb[] = '<li><a href="'.TB_SHOP_URL.'/orderinquiry.php">주문/배송조회</a></li>';
                    $tnb[] = '<li><a href="'.TB_BBS_URL.'/faq.php?faqcate=1">고객센터</a></li>';
                    */
                    $tnb_str = implode(PHP_EOL, $tnb);
                    echo $tnb_str;
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div id="container">
		<?php
		if(!defined('_INDEX_')) { // index가 아니면 실행
			echo '<div class="cont_inner">'.PHP_EOL;
		}
		?>
