<?php
define('_PURENESS_', true);
include_once("./_common.php");

$nicepayHome = TB_SHOP_PATH.'/nicepay'; // 나이스페이 홈디렉터리
$PG_IP = $_SERVER['REMOTE_ADDR'];

if( $PG_IP == "121.133.126.10" || $PG_IP == "121.133.126.11" || $PG_IP == "211.33.136.39" )  //PG에서 보냈는지 IP로 체크
{
	//**********************************************************************************
	// 구매자가 입금하면 NICE정보토인에서  전달하는 가상계좌이체의 결과를 수신하여 DB 처리 하는 부분 입니다.
	// 수신되는 필드에 대한 DB 작업을 수행하십시오.
	// 수신필드 자세한 내용은 메뉴얼 참조
	//**********************************************************************************

	$PayMethod      = trim($PayMethod);			//지불수단
	$M_ID           = trim($MID);				//상점ID
	$MallUserID     = trim($MallUserID);		//회원사ID
	$Amt            = trim($Amt);				//금액
	$name           = trim($name);				//구매자명
	$GoodsName      = trim($GoodsName);			//상품명
	$TID            = trim($TID);				//거래번호
	$MOID           = trim($MOID);				//주문번호
	$AuthDate       = trim($AuthDate);			//입금일시 (yyMMddHHmmss)
	$ResultCode     = trim($ResultCode);		//결과코드 ('4110' 경우 입금통보)
	$ResultMsg      = trim($ResultMsg);			//결과메시지
	$VbankNum       = trim($VbankNum);			//가상계좌번호
	$FnCd           = trim($FnCd);				//가상계좌 은행코드
	$VbankName      = trim($VbankName);			//가상계좌 은행명
	$VbankInputName = trim($VbankInputName);	//입금자명
	$CancelDate     = trim($CancelDate);		//취소일시

	//가상계좌채번시 현금영수증 자동발급신청이 되었을경우 전달되며
	//RcptTID 에 값이 있는경우만 발급처리 됨
	$RcptTID        = trim($RcptTID);			//현금영수증 거래번호
	$RcptType       = trim($RcptType);			//현금 영수증 구분(0:미발행, 1:소득공제용, 2:지출증빙용)
	$RcptAuthCode   = trim($RcptAuthCode);		//현금영수증 승인번호

	//**********************************************************************************
	//이부분에 로그파일 경로를 수정해주세요.
	$logfile = fopen($nicepayHome."/log/nice_vacct_noti_result.log", "a+" );
	//로그는 문제발생시 오류 추적의 중요데이터 이므로 반드시 적용해주시기 바랍니다.
	//**********************************************************************************

	fwrite( $logfile,"************************************************\r\n");
	fwrite( $logfile,"PayMethod     : ".$PayMethod."\r\n");
	fwrite( $logfile,"MID           : ".$MID."\r\n");
	fwrite( $logfile,"MallUserID    : ".$MallUserID."\r\n");
	fwrite( $logfile,"Amt           : ".$Amt."\r\n");
	fwrite( $logfile,"name          : ".$name."\r\n");
	fwrite( $logfile,"GoodsName     : ".$GoodsName."\r\n");
	fwrite( $logfile,"TID           : ".$TID."\r\n");
	fwrite( $logfile,"MOID          : ".$MOID."\r\n");
	fwrite( $logfile,"AuthDate      : ".$AuthDate."\r\n");
	fwrite( $logfile,"ResultCode    : ".$ResultCode."\r\n");
	fwrite( $logfile,"ResultMsg     : ".$ResultMsg."\r\n");
	fwrite( $logfile,"VbankNum      : ".$VbankNum."\r\n");
	fwrite( $logfile,"FnCd          : ".$FnCd."\r\n");
	fwrite( $logfile,"VbankName     : ".$VbankName."\r\n");
	fwrite( $logfile,"VbankInputName : ".$VbankInputName."\r\n");
	fwrite( $logfile,"RcptTID       : ".$RcptTID."\r\n");
	fwrite( $logfile,"RcptType      : ".$RcptType."\r\n");
	fwrite( $logfile,"RcptAuthCode  : ".$RcptAuthCode."\r\n");
	fwrite( $logfile,"CancelDate    : ".$CancelDate."\r\n");
	fwrite( $logfile,"************************************************\r\n");

	fclose( $logfile );

	// 가맹점 DB처리
	$result = false;

	// 주문서 UPDATE
	$sql = " update shop_order
				set receipt_time = '".TB_TIME_YMDHIS."'
				  , dan = '2'
			  where od_id = '$MOID'
				and od_app_no = '$VbankNum'
				and dan = '1' ";
	$result = sql_query($sql, FALSE);

	if($result) {
		$sql = "update shop_cart set ct_select = '1' where od_id = '$MOID' ";
		sql_query($sql, FALSE);
	}

	//**************************************************************************************************
	//**************************************************************************************************
	//결제 데이터 통보 설정 > “OK” 체크박스에 체크한 경우" 만 처리 하시기 바랍니다.
	//**************************************************************************************************
	//TCP인 경우 OK 문자열 뒤에 라인피드 추가
	//위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 NICEPAY로
	//리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
	//(주의) OK를 리턴하지 않으시면 NICEPAY 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
	//기타 다른 형태의 PRINT(out.print)는 하지 않으시기 바랍니다
	if ($result)
	{
		echo "OK"; // 절대로 지우지마세요
	}
	else
	{
		echo "FAIL";
	}
	//*************************************************************************************************
	//*************************************************************************************************
}
?>