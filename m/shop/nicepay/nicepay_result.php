<?php
include_once('./_common.php');
include_once(TB_LIB_PATH.'/mailer.lib.php');

require_once(TB_SHOP_PATH.'/settle_nicepay.inc.php');

require_once(TB_MSHOP_PATH.'/nicepay/lib/nicepay/web/NicePayWEB.php');
require_once(TB_MSHOP_PATH.'/nicepay/lib/nicepay/core/Constants.php');
require_once(TB_MSHOP_PATH.'/nicepay/lib/nicepay/web/NicePayHttpServletRequestWrapper.php');

/*
*******************************************************
* <인증 결과>
*******************************************************
*/
$authResultCode	= trim($_REQUEST['AuthResultCode']);	// 인증결과 : 0000(성공)
$authResultMsg	= trim($_REQUEST['AuthResultMsg']);		// 인증결과 메시지
$paySuccess = false;

if($authResultCode == '0000'){
    /*
    *******************************************************
    * <결제 결과 설정>
    * 사용전 결과 옵션을 사용자 환경에 맞도록 변경하세요.
    * 로그 디렉토리는 꼭 변경하세요.
    *******************************************************
    */
    $nicepayWEB         = new NicePayWEB();
    $httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
    $_REQUEST           = $httpRequestWrapper->getHttpRequestMap();
    $payMethod          = trim($_REQUEST['PayMethod']);

	$nicepayWEB->setParam("NICEPAY_LOG_HOME", $g_conf_home_dir.'/log'); // 로그 디렉토리 설정
    $nicepayWEB->setParam("APP_LOG","1");								// 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
    $nicepayWEB->setParam("EVENT_LOG","1");								// 이벤트로그 모드 설정(0: DISABLE, 1: ENABLE)
    $nicepayWEB->setParam("EncFlag","S");								// 암호화플래그 설정(N: 평문, S:암호화)
    $nicepayWEB->setParam("SERVICE_MODE", "PY0");						// 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)
    $nicepayWEB->setParam("Currency", "KRW");							// 통화 설정(현재 KRW(원화) 가능)
    $nicepayWEB->setParam("PayMethod",$payMethod);						// 결제방법
    $nicepayWEB->setParam("LicenseKey",$merchantKey);					// 상점키
    $nicepayWEB->setParam("CHARSET", "UTF8");							// 인코딩

    /*
    *******************************************************
    * <결제 결과 필드>
    * 아래 응답 데이터 외에도 전문 Header와 개별부 데이터 Get 가능
    *******************************************************
    */
    $responseDTO    = $nicepayWEB->doService($_REQUEST);
    $resultCode     = trim($responseDTO->getParameter("ResultCode"));	// 결과코드 (정상 결과코드:3001)
    $resultMsg      = trim($responseDTO->getParameterUTF("ResultMsg"));	// 결과메시지

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
	//$vbankBankName  = $responseDTO->getParameterUTF("VbankBankName");	// 가상계좌은행명
	//$vbankNum       = $responseDTO->getParameter("VbankNum");			// 가상계좌번호
	//$vbankExpDate   = $responseDTO->getParameter("VbankExpDate");		// 가상계좌입금예정일

    /*
    *******************************************************
    * <결제 성공 여부 확인>
    *******************************************************
    */
    if($payMethod == "CARD"){
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
} else {
    $resultCode = $authResultCode;
    $resultMsg  = $authResultMsg;
}

if($paySuccess == true) {
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

	$od_id = trim($responseDTO->getParameter("Moid"));

	$od = sql_fetch("select * from shop_order where od_id='$od_id'");
	if(!$od['od_id']) {
		alert("결제할 주문서가 없습니다.", TB_MURL);
	}

	$stotal = get_order_spay($od_id); // 총계

	$i_price = (int)$stotal['useprice']; // 결제금액
	$i_usepoint = (int)$stotal['usepoint']; // 포인트결제액

	if(!$i_price) {
		alert("결제할 금액이 없습니다.", TB_MURL);
	}

	$od_tno = '';

	if($od['paymethod'] == "계좌이체")
	{
		$od_tno             = $tno;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_deposit_name    = $od['name'];
		$od_bank_account    = $bank_name;
		$pg_price           = $amount;
		$od_status			= '2';
	}
	else if($od['paymethod'] == "가상계좌")
	{
		$od_tno             = $tno;
		$od_app_no			= $app_no;
		$od_bank_account    = $bankname.' '.$account;
		$od_deposit_name    = $depositor;
		$pg_price           = $amount;
		$od_status			= '1';
	}
	else if($od['paymethod'] == "휴대폰")
	{
		$od_tno             = $tno;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $commid . ($commid ? ' ' : '').$mobile_no;
		$pg_price           = $amount;
		$od_status			= '2';
	}
	else if($od['paymethod'] == "신용카드")
	{
		$od_tno             = $tno;
		$od_app_no          = $app_no;
		$od_receipt_time    = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $app_time);
		$od_bank_account    = $card_name;
		$pg_price           = $amount;
		$od_status			= '2';
	}
	else
	{
		die("od_settle_case Error!!!");
	}

	$od_pg = $default['de_pg_service'];

	// 주문금액과 결제금액이 일치하는지 체크
	if($tno) {
		if((int)$i_price !== (int)$pg_price) {
			$cancel_msg = '결제금액 불일치';
			include TB_SHOP_PATH.'/nicepay/nicepay_cancel.php';

			die("Receipt Amount Error");
		}
	}

	$od_escrow = 0;
	if($escw_yn == 'Y')
		$od_escrow = 1;

	// 복합과세 금액
	$od_tax_mny = round($i_price / 1.1);
	$od_vat_mny = $i_price - $od_tax_mny;
	$od_free_mny = 0;
	if($default['de_tax_flag_use']) {
		$info = comm_tax_flag($od_id);
		$od_tax_mny  = $info['comm_tax_mny'];
		$od_vat_mny  = $info['comm_vat_mny'];
		$od_free_mny = $info['comm_free_mny'];
	}

	// 주문서에 UPDATE
	$sql = " update shop_order
				set deposit_name = '$od_deposit_name'
				  , receipt_time = '$od_receipt_time'
				  , bank		 = '$od_bank_account'
				  , dan			 = '$od_status'
				  , od_pg		 = '$od_pg'
				  , od_tno		 = '$od_tno'
				  , od_app_no	 = '$od_app_no'
				  , od_escrow	 = '$od_escrow'
				  , od_tax_mny	 = '$od_tax_mny'
				  , od_vat_mny	 = '$od_vat_mny'
				  , od_free_mny	 = '$od_free_mny'
			  where od_id = '$od_id'";
	$result = sql_query($sql, false);

	if($result) {
		// 장바구니 상태변경
		$sql = " update shop_cart set ct_select = '1' where od_id = '$od_id' ";
		sql_query($sql, false);
	} else {
		// 주문정보 UPDATE 오류시 결제 취소
		if($tno) {
			$cancel_msg = '주문상태 변경 오류';
			include TB_SHOP_PATH.'/nicepay/nicepay_cancel.php';
		}

		die('<p>고객님의 주문 정보를 처리하는 중 오류가 발생해서 주문이 완료되지 않았습니다.</p><p>'.strtoupper($od_pg).'를 이용한 전자결제(신용카드, 계좌이체, 가상계좌 등)은 자동 취소되었습니다.');
	}

	// 회원이면서 포인트를 사용했다면 테이블에 사용을 추가
	if($is_member && $i_usepoint) {
		insert_point($member['id'], (-1) * $i_usepoint, "주문번호 $od_id 결제");
	}

	// 쿠폰사용내역기록
	if($is_member) {
		$sql = "select * from shop_order where od_id='$od_id'";
		$res = sql_query($sql);
		for($i=0; $row=sql_fetch_array($res); $i++) {
			if($row['coupon_price']) {
				$sql = "update shop_coupon_log
						   set mb_use = '1',
							   od_no = '$row[od_no]',
							   cp_udate	= '".TB_TIME_YMDHIS."'
						 where lo_id = '$row[coupon_lo_id]' ";
				sql_query($sql);
			}
		}
	}

	// 주문완료 문자전송
	icode_order_sms_send($od['pt_id'], $od['cellphone'], $od_id, 2);

	// 메일발송
	if($od['email']) {
		$subject1 = get_text($od['name'])."님 주문이 정상적으로 처리되었습니다.";
		$subject2 = get_text($od['name'])." 고객님께서 신규주문을 신청하셨습니다.";

		ob_start();
		include_once(TB_SHOP_PATH.'/orderformupdate_mail.php');
		$content = ob_get_contents();
		ob_end_clean();

		// 주문자에게 메일발송
		mailer($config['company_name'], $super['email'], $od['email'], $subject1, $content, 1);

		// 관리자에게 메일발송
		if($super['email'] != $od['email']) {
			mailer($od['name'], $od['email'], $super['email'], $subject2, $content, 1);
		}
	}

	// 주문 정보 임시 데이터 삭제
	$sql = " delete from shop_order_data where od_id = '$od_id' and dt_pg = '$od_pg' ";
	sql_query($sql);

	// 주문번호제거
	set_session('ss_order_id', '');

	// 장바구니 session 삭제
	set_session('ss_cart_id', '');

	// orderinquiryview 에서 사용하기 위해 session에 넣고
	$uid = md5($od_id.$od['od_time'].$_SERVER['REMOTE_ADDR']);
	set_session('ss_orderview_uid', $uid);

	goto_url(TB_MSHOP_URL.'/orderinquiryview.php?od_id='.$od_id.'&uid='.$uid);

} else {
   alert("{$resultMsg} (응답코드:{$resultCode})", TB_MURL);
}
?>