<?php
include_once('./_common.php');
require_once(TB_SHOP_PATH.'/settle_nicepay.inc.php');

require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayWEB.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/core/Constants.php');
require_once(TB_SHOP_PATH.'/nicepay/lib/nicepay/web/NicePayHttpServletRequestWrapper.php');

$od = sql_fetch(" select * from shop_order where od_id = '$od_id' ");
if(!$od)
	die('<p id="scash_empty">주문서가 존재하지 않습니다.</p>');

if($od['od_cash'] == 1)
	alert('이미 등록된 현금영수증 입니다.');

$buyername = $od['name'];
$goods     = get_full_name($od['od_id']);
$goodname  = $goods['full_name'];
$amt_tot   = (int)$od['od_tax_mny'] + (int)$od['od_vat_mny'] + (int)$od['od_free_mny'];
$amt_sup   = (int)$od['od_tax_mny'] + (int)$od['od_free_mny'];
$amt_tax   = (int)$od['od_vat_mny'];
$amt_svc   = 0;


$_REQUEST['GoodsName']			= iconv_euckr($goodname);
$_REQUEST['Moid']               = $od_id;
$_REQUEST['BuyerName']			= iconv_euckr($buyername);
$_REQUEST['ReceiptAmt']			= $amt_tot;
$_REQUEST['ReceiptSupplyAmt']	= $amt_sup;
$_REQUEST['ReceiptVAT']			= $amt_tax;
$_REQUEST['ReceiptServiceAmt']	= $amt_svc;
$_REQUEST['ReceiptType']		= $tr_code;
$_REQUEST['ReceiptTypeNo']		= $id_info;
$_REQUEST['MID']				= $merchantID;

/*********************
 * 발급 정보 설정 *
 *********************/
$httpRequestWrapper = new NicePayHttpServletRequestWrapper($_REQUEST);
$_REQUEST = $httpRequestWrapper->getHttpRequestMap();
$nicepayWEB = new NicePayWEB();

$nicepayWEB->setParam("NICEPAY_LOG_HOME", $g_conf_home_dir.'/log');	// 로그 디렉토리 설정
$nicepayWEB->setParam("APP_LOG","1");								// 어플리케이션로그 모드 설정(0: DISABLE, 1: ENABLE)
$nicepayWEB->setParam("EncFlag","S");								// 암호화플래그 설정(N: 평문, S:암호화)
$nicepayWEB->setParam("SERVICE_MODE", "PY0");						// 서비스모드 설정(결제 서비스 : PY0 , 취소 서비스 : CL0)
$nicepayWEB->setParam("Currency", "KRW");							// 통화 설정(현재 KRW(원화) 가능)
$nicepayWEB->setParam("PayMethod",'CASHRCPT');						// 결제방법

$responseDTO = $nicepayWEB->doService($_REQUEST);
$resultCode  = trim($responseDTO->getParameter("ResultCode"));		// 결과코드 (정상 :3001 , 그 외 에러)
$resultMsg   = trim($responseDTO->getParameter("ResultMsg"));		// 결과메시지
$authDate	 = trim($responseDTO->getParameter("AuthDate"));		// 승인일시 YYMMDDHH24mmss
$tid		 = trim($responseDTO->getParameter("TID"));				// 거래ID

// DB 반영
if($resultCode == '3001') {
    $cash_no = $authDate;

    $cash = array();
    $cash['TID']       = $tid;
    $cash['AuthDate']  = $authDate;
    $cash_info = serialize($cash);

	$sql = " update shop_order
				set od_cash = '1',
					od_cash_no = '$cash_no',
					od_cash_info = '$cash_info'
			  where od_id = '$od_id' ";
	sql_query($sql, false);
}

$tb['title'] = '현금영수증 발급';
if(TB_IS_MOBILE) {
	include_once(TB_MPATH.'/head.sub.php');
} else {
	include_once(TB_PATH.'/head.sub.php');
}
?>

<script>
function viewReceipt(TID) {
	 var status = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=414,height=622";
     window.open("https://npg.nicepay.co.kr/issue/IssueLoader.do?TID="+TID+"&type=1","popupIssue",status);

}
</script>

<div id="lg_req_tx" class="new_win">
    <h1 id="win_title">현금영수증 - 나이스페이</h1>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <colgroup>
            <col class="w120">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">결과코드</th>
            <td><?php echo $resultCode; ?></td>
        </tr>
        <tr>
            <th scope="row">결과 메세지</th>
            <td><?php echo iconv_utf8($resultMsg); ?></td>
        </tr>
        <tr>
            <th scope="row">현금영수증 거래번호</th>
            <td><?php echo $tid; ?></td>
        </tr>
        <tr>
            <th scope="row">승인시간</th>
            <td><?php echo preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3 \\4:\\5:\\6", $authDate); ?></td>
        </tr>
        <tr>
            <th scope="row">현금영수증 URL</th>
            <td>
                <button type="button" name="receiptView" class="btn_small" onClick="javascript:viewReceipt('<?php echo $tid; ?>');">영수증 확인</button>
                <span class="frm_info">영수증 확인은 실 등록의 경우에만 가능합니다.</span>
            </td>
        </tr>
        </tbody>
        </table>
    </div>

	<div class="win_btn">
		<input type="button" class="btn_lsmall bx-white" value="닫기" onclick="window.close();">
    </div>

</div>

<?php
if(TB_IS_MOBILE) {
	include_once(TB_MPATH.'/tail.sub.php');
} else {
	include_once(TB_PATH.'/tail.sub.php');
}
?>