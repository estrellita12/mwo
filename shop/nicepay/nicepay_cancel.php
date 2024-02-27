<?php
if(!defined('_TUBEWEB_')) exit; // 개별 페이지 접근 불가

require_once(TB_SHOP_PATH.'/settle_nicepay.inc.php');

require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayWEB.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/core/Constants.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayHttpServletRequestWrapper.php');

$_REQUEST['MID']               = $merchantID;
$_REQUEST['TID']               = $tno;
$_REQUEST['CancelAmt']		   = $amount;
$_REQUEST['CancelMsg']         = $cancel_msg;
$_REQUEST['CancelPwd']         = $merchantPwd;
$_REQUEST['PartialCancelCode'] = 0;

/*
*******************************************************
* <취소 결과 설정>
* 사용전 결과 옵션을 사용자 환경에 맞도록 변경하세요.
* 로그 디렉토리는 꼭 변경하세요.
*******************************************************
*/
$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$nicepayWEB = new NicePayWEB();

$nicepayWEB->setParam("NICEPAY_LOG_HOME" $g_conf_home_dir.'/log'); // 로그 디렉토리 설정
$nicepayWEB->setParam("APP_LOG","1"); // 이벤트로그 모드 설정(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EVENT_LOG","1"); // 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EncFlag","S"); // 암호화플래그 설정(N: 평문, S:암호화)
$nicepayWEB->setParam("SERVICE_MODE", "CL0"); // 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)
$nicepayWEB->setParam("CHARSET", "UTF8"); // 인코딩

/*
*******************************************************
* <취소 결과 필드>
*******************************************************
*/
$responseDTO = $nicepayWEB->doService($_REQUEST);
//$resultCode  = $responseDTO->getParameter("ResultCode");        // 결과코드 (취소성공: 2001, 취소성공(LGU 계좌이체):2211)
//$resultMsg   = $responseDTO->getParameterUTF("ResultMsg");      // 결과메시지
//$cancelAmt   = $responseDTO->getParameter("CancelAmt");         // 취소금액
//$cancelDate  = $responseDTO->getParameter("CancelDate");        // 취소일
//$cancelTime  = $responseDTO->getParameter("CancelTime");        // 취소시간
//$cancelNum   = $responseDTO->getParameter("CancelNum");         // 취소번호
//$payMethod   = $responseDTO->getParameter("PayMethod");         // 취소 결제수단
//$mid         = $responseDTO->getParameter("MID");               // 상점 ID
//$tid         = $responseDTO->getParameter("TID");               // 거래아이디 TID
?>