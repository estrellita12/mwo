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

<input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
<input type="hidden" name="od_settle_case" value="<?php echo $od['paymethod']; ?>">
<input type="hidden" name="od_name" value="<?php echo $od['name']; ?>">
<input type="hidden" name="od_tel" value="<?php echo $od['telephone']; ?>">
<input type="hidden" name="od_hp" value="<?php echo $od['cellphone']; ?>">
<input type="hidden" name="od_zip" value="<?php echo $od['zip']; ?>">
<input type="hidden" name="od_addr1" value="<?php echo $od['addr1']; ?>">
<input type="hidden" name="od_addr2" value="<?php echo $od['addr2']; ?>">
<input type="hidden" name="od_addr3" value="<?php echo $od['addr3']; ?>">
<input type="hidden" name="od_addr_jibeon" value="<?php echo $od['addr_jibeon']; ?>">
<input type="hidden" name="od_email" value="<?php echo $od['email']; ?>">
<input type="hidden" name="od_b_name" value="<?php echo $od['b_name']; ?>">
<input type="hidden" name="od_b_tel" value="<?php echo $od['b_telephone']; ?>">
<input type="hidden" name="od_b_hp" value="<?php echo $od['b_cellphone']; ?>">
<input type="hidden" name="od_b_zip" value="<?php echo $od['b_zip']; ?>">
<input type="hidden" name="od_b_addr1" value="<?php echo $od['b_addr1']; ?>">
<input type="hidden" name="od_b_addr2" value="<?php echo $od['b_addr2']; ?>">
<input type="hidden" name="od_b_addr3" value="<?php echo $od['b_addr3']; ?>">
<input type="hidden" name="od_b_addr_jibeon" value="<?php echo $od['b_addr_jibeon']; ?>">

<?php /* 주문폼 자바스크립트 에러 방지를 위해 추가함 */ ?>
<input type="hidden" name="good_mny" value="<?php echo $tot_price; ?>">
<?php if($default['de_tax_flag_use']) { ?>
<input type="hidden" name="comm_tax_mny" value="<?php echo $comm_tax_mny; ?>"> <!-- 과세금액 -->
<input type="hidden" name="comm_vat_mny" value="<?php echo $comm_vat_mny; ?>"> <!-- 부가세 -->
<input type="hidden" name="comm_free_mny" value="<?php echo $comm_free_mny; ?>"> <!-- 비과세 금액 -->
<?php } ?>

<!-- Mall Parameters -->
<input type="hidden" name="PayMethod" value=""> <!-- 지불방법 -->
<input type="hidden" name="GoodsName" value="<?php echo $goods; ?>"> <!-- 상품명 -->
<input type="hidden" name="GoodsCnt" value="<?php echo ($goods_count+1); ?>"> <!-- 상품갯수 -->
<input type="hidden" name="Amt" value="<?php echo $tot_price; ?>"> <!-- 상품 가격 -->
<input type="hidden" name="BuyerName" value=""> <!-- 주문자명 -->
<input type="hidden" name="BuyerTel" value=""> <!-- 주문자 핸드폰 -->
<input type="hidden" name="Moid" value="<?php echo $od_id; ?>"> <!-- 주문번호 -->
<input type="hidden" name="MID" value="<?php echo $merchantID; ?>"> <!-- 상점아이디 -->
<input type="hidden" name="UserIP" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">

<!-- 옵션 -->
<input type="hidden" name="VbankExpDate" value="<?php echo $vDate; ?>"> <!-- 가상계좌 입금예정 만료일  -->
<input type="hidden" name="BuyerEmail" value=""> <!-- 주문자 이메일 -->
<input type="hidden" name="TransType" value="0"> <!-- 결제 타입 0:일반, 1:에스크로 -->
<input type="hidden" name="GoodsCl" value="1"> <!-- 상품유형: 실물(1),컨텐츠(0) -->

<!-- 변경 불가 -->
<input type="hidden" name="EncodeParameters" value=""> <!-- 암호화 항목 -->
<input type="hidden" name="EdiDate" value="<?php echo $ediDate;?>">
<input type="hidden" name="EncryptData" value="<?php echo $hashString;?>" >
<input type="hidden" name="TrKey" value="">
