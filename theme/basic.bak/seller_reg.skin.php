<?php
if(!defined('_TUBEWEB_')) exit;
?>

<div>
    <div class="tab_box02">
                    <ul class="navbar">
                        <li><a class="tab01 selected"><span class="dn">회원신청</span></a></li>
                        <li><a class="tab02"><span class="dn">승인대기</span></a></li>
                        <li><a class="tab03"><span class="dn">서류심사</span></a></li>
                        <li><a class="tab04"><span class="dn">회원가입완료</span></a></li>
                    </ul>
                </div>
</div>


<div><img src="<?php echo TB_IMG_URL; ?>/seller_reg2.gif"></div>
<!-- <div><img src="<?php echo TB_IMG_URL; ?>/seller_reg.gif"></div> -->
<div class="mart20">
    <?php echo get_view_thumbnail(conv_content($config['seller_reg_guide'], 1), 1000); ?>
</div>

    <div class="fsellerform_term">
        <h2 class="marb10">공급사 이용약관</h2>
        <textarea readonly><?php echo $config['seller_reg_agree']; ?></textarea>
        <fieldset class="fsellerform_agree">
            <input type="checkbox" name="agree" value="1" id="agree11">
            <label for="agree11">위 내용을 읽었으며 약관에 동의합니다.</label>
        </fieldset>

        <h2 class="mart20 marb10">개인정보 수집 및 이용</h2>
        <textarea readonly><?php echo $config['shop_private']; ?></textarea>
        <fieldset class="fsellerform_agree">
            <input type="checkbox" name="agree3" value="1" id="agree31">
            <label for="agree31">개인정보 수집 및 이용 내용에 동의합니다.</label>
        </fieldset>

        <fieldset class="fsellerform_agree">
            <input type="checkbox" name="chk_all" value="1" id="chk_all">
            <label for="chk_all" class="bold fs14">모든 약관을 확인하고 전체 동의합니다.</label>
        </fieldset>
    </div>



<div class="btn_confirm">
    <a href="<?php echo TB_BBS_URL; ?>/seller_reg_from.php" class="btn_large wset">확인</a>
    <a href="<?php echo TB_URL; ?>" class="btn_large bx-white">취소</a>
</div>
<script>
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

