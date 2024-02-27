<?php
if(!defined('_TUBEWEB_')) exit; // 개별 페이지 접근 불가

require_once(TB_SHOP_PATH.'/settle_nicepay.inc.php');

require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayWEB.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/core/Constants.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayHttpServletRequestWrapper.php');

/*
*******************************************************
* <결제 결과 설정>
* 사용전 결과 옵션을 사용자 환경에 맞도록 변경하세요.
* 로그 디렉토리는 꼭 변경하세요.
*******************************************************
*/
$nicepayWEB = new NicePayWEB();
$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$payMethod = trim($_REQUEST['PayMethod']);

$nicepayWEB->setParam("NICEPAY_LOG_HOME", $g_conf_home_dir.'/log');	// 로그 디렉토리 설정
$nicepayWEB->setParam("APP_LOG","1");								// 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EncFlag","S");								// 암호화플래그 설정(N: 평문, S:암호화)
$nicepayWEB->setParam("SERVICE_MODE", "PY0");						// 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)
$nicepayWEB->setParam("Currency", "KRW");							// 통화 설정(현재 KRW(원화) 가능)
$nicepayWEB->setParam("CHARSET", "UTF8");							// 인코딩
$nicepayWEB->setParam("PayMethod",$payMethod);						// 결제방법
$nicepayWEB->setParam("LicenseKey",$merchantKey);					// 상점키

/*
*******************************************************
* <결제 결과 필드>
* 아래 응답 데이터 외에도 전문 Header와 개별부 데이터 Get 가능
*******************************************************
*/
$responseDTO = $nicepayWEB->doService($_REQUEST);
$resultCode	 = trim($responseDTO->getParameter("ResultCode"));		// 결과코드 (정상 결과코드:3001)
$resultMsg	 = trim($responseDTO->getParameterUTF("ResultMsg"));	// 결과메시지

//$authDate       = $responseDTO->getParameter("AuthDate");			// 승인일시 (YYMMDDHH24mmss)
//$authCode       = $responseDTO->getParameter("AuthCode");			// 승인번호
//$buyerName      = $responseDTO->getParameterUTF("BuyerName");		// 구매자명
//$mallUserID     = $responseDTO->getParameter("MallUserID");		// 회원사고객ID
//$goodsName      = $responseDTO->getParameterUTF("GoodsName");		// 상품명
//$mallUserID     = $responseDTO->getParameter("MallUserID");		// 회원사ID
//$mid            = $responseDTO->getParameter("MID");				// 상점ID
//$tid            = $responseDTO->getParameter("TID");				// 거래ID
//$moid           = $responseDTO->getParameter("Moid");				// 주문번호
//$amt            = $responseDTO->getParameter("Amt");				// 금액
//$cardQuota      = $responseDTO->getParameter("CardQuota");		// 카드 할부개월 (00:일시불,02:2개월)
//$cardCode       = $responseDTO->getParameter("CardCode");			// 결제카드사코드
//$cardName       = $responseDTO->getParameterUTF("CardName");		// 결제카드사명
//$bankCode       = $responseDTO->getParameter("BankCode");			// 은행코드
//$bankName       = $responseDTO->getParameterUTF("BankName");		// 은행명
//$rcptType       = $responseDTO->getParameter("RcptType");			// 현금 영수증 타입 (0:발행되지않음,1:소득공제,2:지출증빙)
//$rcptAuthCode   = $responseDTO->getParameter("RcptAuthCode");		// 현금영수증 승인번호
//$carrier        = $responseDTO->getParameter("Carrier");			// 이통사구분
//$dstAddr        = $responseDTO->getParameter("DstAddr");			// 휴대폰번호
//$vbankBankCode  = $responseDTO->getParameter("VbankBankCode");	// 가상계좌은행코드
//$vbankBankName  = $responseDTO->getParameterUTF("VbankBankName"); // 가상계좌은행명
//$vbankNum       = $responseDTO->getParameter("VbankNum");			// 가상계좌번호
//$vbankExpDate   = $responseDTO->getParameter("VbankExpDate");		// 가상계좌입금예정일

/** 위의 응답 데이터 외에도 전문 Header와 개별부 데이터 Get 가능 */
$paySuccess = false;
if($payMethod == "CARD") {
    if($resultCode == "3001") $paySuccess = true; // 신용카드(정상 결과코드:3001)
} else if($payMethod == "BANK") {
    if($resultCode == "4000") $paySuccess = true; // 계좌이체(정상 결과코드:4000)
} else if($payMethod == "CELLPHONE") {
    if($resultCode == "A000") $paySuccess = true; // 휴대폰(정상 결과코드:A000)
} else if($payMethod == "VBANK") {
    if($resultCode == "4100") $paySuccess = true; // 가상계좌(정상 결과코드:4100)
} else if($payMethod == "SSG_BANK") {
    if($resultCode == "0000") $paySuccess = true; // SSG은행계좌(정상 결과코드:0000)
}

if($paySuccess == true) {
    //최종결제요청 결과 성공 DB처리
    $tno        = trim($responseDTO->getParameter("TID"));
    $amount     = trim($responseDTO->getParameter("Amt"));
    $app_time   = trim($responseDTO->getParameter("AuthDate"));
    $depositor  = trim($responseDTO->getParameterUTF("BuyerName"));
    $commid     = trim($responseDTO->getParameter("Carrier"));
    $mobile_no  = trim($responseDTO->getParameter("DstAddr"));
    $app_no     = trim($responseDTO->getParameter("AuthCode"));
    $card_name  = trim($responseDTO->getParameterUTF("CardName"));
    switch($payMethod) {
        case 'BANK': // 계좌이체
            $bank_name = trim($responseDTO->getParameterUTF("BankName"));
            if($default['de_escrow_use'] == 1)
                $escw_yn         = 'Y';
            break;
        case 'VBANK': // 가상계좌
            $bankname  = trim($responseDTO->getParameterUTF("VbankBankName"));
            $account   = trim($responseDTO->getParameter("VbankNum"));
            $app_no    = trim($responseDTO->getParameter("VbankNum"));
            if($default['de_escrow_use'] == 1)
                $escw_yn         = 'Y';
            break;
        default:
            break;
    }
} else {
	die("{$resultMsg} (응답코드:{$resultCode})");
}
?>