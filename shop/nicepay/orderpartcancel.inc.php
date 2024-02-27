<?php
if(!defined("_TUBEWEB_")) exit; // 개별 페이지 접근 불가

if($od['od_pg'] != 'nicepay') return;

require_once(TB_SHOP_PATH.'/settle_nicepay.inc.php');

require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayWEB.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/core/Constants.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayHttpServletRequestWrapper.php');

$_REQUEST['MID']				= $merchantID;
$_REQUEST['TID']				= $od['od_tno'];
$_REQUEST['CancelAmt']			= (int)$tax_mny + (int)$free_mny;
$_REQUEST['CancelMsg']			= $mod_memo;
$_REQUEST['CancelPwd']			= $merchantPwd;
$_REQUEST['CancelIP']			= $_SERVER['REMOTE_ADDR'];
$_REQUEST['Moid']				= $od['od_no'];
$_REQUEST['PartialCancelCode']	= 1;

$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$nicepayWEB = new NicePayWEB();

$nicepayWEB->setParam("NICEPAY_LOG_HOME", $g_conf_home_dir.'/log'); // 로그 디렉토리 설정
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
$resultCode  = trim($responseDTO->getParameter("ResultCode"));		// 결과코드 (취소성공: 2001, 취소성공(LGU 계좌이체):2211)
$resultMsg   = trim($responseDTO->getParameterUTF("ResultMsg"));	// 결과메시지
$cancelAmt   = trim($responseDTO->getParameter("CancelAmt"));		// 취소금액
$cancelDate  = trim($responseDTO->getParameter("CancelDate"));		// 취소일
$cancelTime  = trim($responseDTO->getParameter("CancelTime"));		// 취소시간
$cancelNum   = trim($responseDTO->getParameter("CancelNum"));		// 취소번호
$payMethod   = trim($responseDTO->getParameter("PayMethod"));		// 취소 결제수단
$mid         = trim($responseDTO->getParameter("MID"));				// 상점 ID
$tno         = trim($responseDTO->getParameter("TID"));				// 거래아이디 TID

if( in_array($resultCode, array('2001','2211')) ) {
	// 환불금액기록
	$sql = " update shop_order
				set refund_price = '$cancelAmt'
			  where od_id = '{$od['od_id']}'
				and od_no = '{$od['od_no']}'
				and od_tno = '$tno' ";
	sql_query($sql);

	$sql = " update shop_order
				set shop_memo = concat(shop_memo, \"$mod_memo\")
			  where od_id = '{$od['od_id']}'
				and od_tno = '$tno' ";
	sql_query($sql);
} else {
	alert($resultMsg.' 코드 : '.$resultCode);
}
?>