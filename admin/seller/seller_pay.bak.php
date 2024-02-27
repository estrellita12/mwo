<?php
if(!defined('_TUBEWEB_')) exit;

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

// 0 : 미정산, 1 : 정산완료, 2 : 교환/반품 배송비 정산완료
$sql_common = " from shop_order a, shop_seller b ";
$sql_search = " where a.seller_id = b.seller_code and left(a.seller_id,3)='AP-'  ";
$sql_search .= " and ( ( a.dan IN(4,5,10,11,12,13,8,7) and a.sellerpay_yes = '0' ) or ( a.dan IN(7) and a.sellerpay_yes = '2' ) ) ";

if($sfl && $stx) {
    $sql_search .= " and $sfl like '%$stx%' ";
}

if($fr_date && $to_date) {
	$sql_search .= " and left(a.od_time,10) between '$fr_date' and '$to_date' ";
}

$sql_order = " group by a.seller_id order by a.index_no desc ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(DISTINCT a.seller_id) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql = " select a.*, b.mb_id, b.company_name $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

include_once(TB_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택정산" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./seller/seller_pay_excel.php?$q1" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
EOF;
?>

<h2>기본검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
			<select name="sfl">
				<?php echo option_selected('b.company_name', $sfl, '공급사명'); ?>
				<?php echo option_selected('b.seller_code', $sfl, '업체코드'); ?>
				<?php echo option_selected('b.mb_id', $sfl, '아이디'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	<tr>
		<th scope="row">주문일</th>
		<td>
			<?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
	<input type="button" value="초기화" id="frmRest" class="btn_medium grey">
</div>
</form>

<form name="forderlist" id="forderlist" method="post" action="./seller/seller_pay_update.php" onsubmit="return forderlist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col class="w50">
		<col class="w80">
		<col>
		<col class="w60">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w60">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col">번호</th>
		<th scope="col">업체코드</th>
		<th scope="col">공급사명</th>
		<th scope="col" class="th_bg">총건수</th>
		<th scope="col" class="th_bg">주문금액</th>
		<th scope="col" class="th_bg">배송비</th>
		<th scope="col" class="th_bg">차감액</th>
		<th scope="col" class="th_bg">공급가총액</th>
		<th scope="col" class="th_bg">실정산액</th>
		<th scope="col">정산 주문건</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'list'.($i%2);

		$tot_price	 = 0;
		$tot_baesong = 0;
		$tot_supply	 = 0;
		$tot_seller	 = 0;
		$tot_cancel	 = 0;
		$order_idx	 = array();
		$cancel_idx	 = array();
		$order_arr	 = array();

		$sql2 = " select * from shop_order where seller_id = '{$row['seller_id']}' and ( dan IN(4,5,10,11,12,13,8,7) and sellerpay_yes = '0' ";
		if($fr_date && $to_date) {
			$sql2 .= " and left(od_time,10) between '$fr_date' and '$to_date' ";
		}

        $sql2 .= ") or ( dan IN(7) and sellerpay_yes = '2' )  ";
		$res2 = sql_query($sql2);
		while($row2 = sql_fetch_array($res2)) {
			$order_idx[] = $row2['index_no'];
			$order_arr['od_id'] = $row2['od_id'];

            if($row2['dan']=='7'){
                if( $row2['sellerpay_yes']=='2' ){
			        $tot_cancel   += (int)$row2['supply_price']; // 차감주문건
			        $cancel_idx[] = $row2['index_no'];
                }else{

                }
                continue;
            }
			$tot_supply  += (int)$row2['supply_price']; // 공급가
			$tot_price   += (int)$row2['goods_price']; // 판매가
			$tot_baesong += (int)$row2['baesong_price']; // 배송비
		}

		$temp_idx = implode(',', $order_idx);
		$temp_cidx = implode(',', $cancel_idx);

		// 정산액 = (공급가합 + 배송비)
		$tot_seller = ($tot_supply + $tot_baesong - $tot_cancel);

	?>
	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="mb_id[<?php echo $i; ?>]" value="<?php echo $row['mb_id']; ?>">
			<input type="hidden" name="order_idx[<?php echo $i; ?>]" value="<?php echo $temp_idx; ?>">
			<input type="hidden" name="cancel_idx[<?php echo $i; ?>]" value="<?php echo $temp_cidx; ?>">
			<input type="hidden" name="tot_price[<?php echo $i; ?>]" value="<?php echo $tot_price; ?>">
			<input type="hidden" name="tot_baesong[<?php echo $i; ?>]" value="<?php echo $tot_baesong; ?>">
			<input type="hidden" name="tot_supply[<?php echo $i; ?>]" value="<?php echo $tot_supply; ?>">
			<input type="hidden" name="tot_seller[<?php echo $i; ?>]" value="<?php echo $tot_seller; ?>">
			<input type="hidden" name="tot_cancel[<?php echo $i; ?>]" value="<?php echo $tot_cancel; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td><?php echo $num--; ?></td>
		<td class="tal"><?php echo get_sideview($row['mb_id'], $row['seller_id']); ?></td>
		<td class="tal"><?php echo $row['company_name']; ?></td>
		<td><?php echo count($order_idx); ?></td>
		<td class="tar"><?php echo number_format($tot_price); ?></td>
		<td class="tar"><?php echo number_format($tot_baesong); ?></td>
		<td class="tar"><?php echo number_format($tot_cancel); ?></td>
		<td class="tar"><?php echo number_format($tot_supply); ?></td>
		<td class="tar fc_00f bold"><?php echo number_format($tot_seller); ?></td>
        <td><a href="<?php echo TB_ADMIN_URL; ?>/seller/seller_pay_excel2.php?<?php echo $q1;?>&seller_id=<?php echo $row['seller_id']; ?>&name=<?php echo $row['company_name']; ?>" class="btn_small">다운로드</a></td>
	</tr>
	<?php
	}
	if($i==0)
		echo '<tr><td colspan="14" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>
<div class="information">
    <h4>도움말</h4>
    <div class="content">
        <div class="desc02">
            <p>ㆍ정산되지 않은 주문건 중 <strong>배송중, 배송완료, 반품신청, 반품중, 반품 완료(정산액 0원), 교환신청, 교환중, 교환완료</strong> 주문건만 표시됩니다.</p>
            <p>ㆍ정산된 주문건 중 <strong>반품완료</strong> 주문건은 차감건으로 표시됩니다.</p>
        </div>
     </div>
</div>

<script>
function forderlist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택정산") {
        if(!confirm("선택한 자료를 정산하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date,#to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
