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
<h2 class="pg_tit">
    <span><?php echo $tb['title']?></span>
    <p class="pg_nav">온라인 입점 신청<i class="ionicons ion-ios-arrow-right"></i>입점 안내 및 약관 동의</p>
</h2>
<div class="seller_reg_bx">
    <ul>
        <li class="selected">입점 안내 및 약관 동의</li>
        <li>정보 입력</li>
        <li>입점 신청 완료</li>
    </ul>
</div>
<div id="seller_reg_form">
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

        <div class="mart20">
            <fieldset class="fsellerform_agree">
                <input type="checkbox" name="chk_all" value="1" id="chk_all">
                <label for="chk_all" class="bold fs14">모든 약관을 확인하고 전체 동의합니다.</label>
            </fieldset>
        </div>
    </div>
</div>
<div class="btn_confirm">
    <a href="<?php echo TB_BBS_URL; ?>/seller_reg_from.php" class="btn_large wset" onclick="return check_terms()">확인</a>
    <a href="<?php echo TB_URL; ?>" class="btn_large bx-white">취소</a>
</div>
<script>
jQuery(function($){
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

function check_terms(){
    if ( $("#agree11").prop('checked') &&  $("#agree31").prop('checked') ){
        return true;
    }else{
        alert("약관에 동의하여 주시기 바랍니다.")
        return false;
    }
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
}

</script>

