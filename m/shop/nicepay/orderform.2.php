<?php
if(!defined("_TUBEWEB_")) exit; // 개별 페이지 접근 불가

/*
*******************************************************
* <해쉬암호화> (수정하지 마세요)
* SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
*******************************************************
*/
$ediDate = date("YmdHis");
$hashString = bin2hex(hash('sha256', $ediDate.$merchantID.$tot_price.$merchantKey, true));

// 가상계좌 입금 예정일 설정
$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
$vDate = date("Ymd", $tomorrow);
?>

<!-- Mall Parameters -->
<input type="hidden" name="PayMethod" value=""> <!-- 지불방법 -->
<input type="hidden" name="GoodsName" value="<?php echo $goods; ?>"> <!-- 상품명 -->
<input type="hidden" name="GoodsCnt" value="<?php echo ($goods_count+1); ?>"> <!-- 상품갯수 -->
<input type="hidden" name="Amt" value="<?php echo $tot_price; ?>"> <!-- 상품 가격 -->
<input type="hidden" name="BuyerName" value="<?php echo $od['name']; ?>"> <!-- 주문자명 -->
<input type="hidden" name="BuyerTel" value="<?php echo $od['cellphone']; ?>"> <!-- 주문자 핸드폰 -->
<input type="hidden" name="Moid" value="<?php echo $od_id; ?>"> <!-- 주문번호 -->
<input type="hidden" name="MID" value="<?php echo $merchantID; ?>"> <!-- 상점아이디 -->

<!-- 옵션 -->
<input type="hidden" name="ReturnURL" value="<?php echo $ReturnURL; ?>">
<input type="hidden" name="CharSet" value="utf-8">
<input type="hidden" name="GoodsCl" value="1"> <!-- 상품유형: 실물(1),컨텐츠(0) -->
<input type="hidden" name="VbankExpDate" value="<?php echo $vDate; ?>"> <!-- 가상계좌 입금예정 만료일  -->
<input type="hidden" name="BuyerEmail" value="<?php echo $od['email']; ?>"> <!-- 주문자 이메일 -->
<input type="hidden" name="TransType" value="0"> <!-- 결제 타입 0:일반, 1:에스크로 -->

<!-- 변경 불가 -->
<input type="hidden" name="EncryptData" value="<?php echo $hashString;?>">
<input type="hidden" name="ediDate" value="<?php echo $ediDate; ?>"> <!-- 전문 생성일시 -->
<input type="hidden" name="AcsNoIframe" value="Y"> <!-- 나이스페이 결제창 프레임 옵션 (변경불가) -->
<input type="hidden" name="TrKey" value="">

<div id="display_pay_button" class="btn_confirm">
    <input type="button" onclick="forderform_check(this.form);" value="주문하기" class="btn_medium wset">
    <a href="<?php echo TB_MURL; ?>" class="btn_medium bx-white">취소</a>
</div>