<?php
if(!defined('_TUBEWEB_')) exit;

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

if( empty($fr_date) ){
    $fr_date = date("Y-m-d", strtotime("-7 day"));
}
if( empty($to_date) ){
    $to_date = TB_TIME_YMD;
}
if( empty($sel_field) ){
    $sel_field = "od_time";
}

$query_string = "code=$code&sel_field=$sel_field$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";


$sql_search = "";
$sql_search .= " dan in (4,5,10,11,12,13,8,7) ";
if($sfl && $stx) {
    $sql_search .= " and b.$sfl like '%$stx%'";
}
$sql_search .= " and ( ";
$sql_search .= "    (left($sel_field,10) between '{$fr_date}' and '{$to_date}') ";
$sql_search .= "    or ";
$sql_search .= "    (left(return_date,10) between '{$fr_date}' and '{$to_date}') ";
$sql_search .= "    or ";
$sql_search .= "    (left(change_date,10) between '{$fr_date}' and '{$to_date}') ";
$sql_search .= " ) ";

$sql_from = " shop_order a join shop_seller b on a.seller_id = b.seller_code  ";


// 테이블의 전체 레코드수만 얻음
$sql = " select count(distinct seller_id) as cnt from {$sql_from} where {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 20;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql_group = " group by seller_id order by seller_id";

$col = " seller_id, b.company_name as seller_company_name, b.mb_id as seller_mb_id";
$col .= ", group_concat(od_id) as od_id_li ";
$col .= ", count( if(dan!=7 and left({$sel_field},10) between '$fr_date' and '$to_date',1,0) ) as count_od_id ";
$col .= ", sum( if(dan!=7 and left({$sel_field},10) between '$fr_date' and '$to_date',supply_price-cancel_price-refund_price,0) ) as tot_supply";
$col .= ", sum( if(dan=7 and left({$sel_field},10) < '$fr_date',supply_price,0) ) as tot_cancel ";
$col .= ", sum( if(dan=7 and left(return_date,10) between '$fr_date' and '$to_date',baesong_price2,0) ) as tot_baesong1 ";
//$col .= ", sum( if(dan=8 and left(change_date,10) between '$fr_date' and '$to_date',baesong_price2,0) ) as tot_baesong2 ";
$col .= ", sum( if(dan=8 ,baesong_price2,0) ) as tot_baesong2 ";

$sql = " select {$col} from $sql_from where $sql_search $sql_group limit {$from_record}, {$rows}";
$result = sql_query($sql);

/*
$sql_search = " where seller_id = '{$row['seller_code']}' ";
    //$sql_search .= " and sellerpay_yes = '0' ";
    $sql_search .= " and ( ";
    $sql_search .= "    ( sellerpay_yes = 0 and dan IN (4,5,10,11,12,13,8,7) and left({$sel_field},10) between '$fr_date' and '$to_date'  )  ";
    $sql_search .= "        or ";
    $sql_search .= "    ( dan IN(7) and left(return_date,10) between '$fr_date' and '$to_date' and ( left({$sel_field},10) < '$fr_date' or left({$sel_field},10) > '$to_date') ) ";
    $sql_search .= " or ( dan IN(7) and left(return_date,10) between '$fr_date' and '$to_date' and ( left({$sel_field},10) < '$fr_date' or left({$sel_field},10) > '$to_date') ) ";
    $sql_search .= " or ( dan IN(8) and left(change_date,10) between '$fr_date' and '$to_date' and ( left(od_time,10) < '$fr_date' or left(od_time,10) > '$to_date') ) ) ";
    $sql_order = " order by index_no desc ";
$col = "*,";
$col .= " od_id ";
$sql = " select {$col} $sql_common $sql_search";
$res = sql_query($sql);
$row = sql_fetch_array($res);
print_r($row);
*/

include_once(TB_PLUGIN_PATH.'/jquery-ui/datepicker.php');

/*
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택정산" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./seller/seller_pay_excel.php?$q1" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
EOF;
*/
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택정산" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
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
            <select name="sfl" class="w100">
                <?php echo option_selected('company_name', $sfl, '공급사명'); ?>
                <?php echo option_selected('seller_code', $sfl, '업체코드'); ?>
                <?php echo option_selected('mb_id', $sfl, '아이디'); ?>
            </select>
            <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
        </td>
    </tr>
    <tr>
        <th scope="row">주문일</th>
        <td>
			<select name="sel_field" class="w100">
				<?php echo option_selected('od_time', $sel_field, "주문일"); ?>
				<?php echo option_selected('delivery_date', $sel_field, "송장등록일"); ?>
			</select>
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
        <col class="w60">
    </colgroup>
    <thead>
    <tr>
        <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
        <th scope="col">번호</th>
        <th scope="col">업체코드</th>
        <th scope="col">공급사명</th>
        <th scope="col" class="th_bg">주문수</th>
        <th scope="col" class="th_bg">정산차감액</th>
        <th scope="col" class="th_bg">공급가총액</th>
        <th scope="col" class="th_bg">실정산액</th>
        <th scope="col" class="th_bg">교환/반품배송비</th>
        <th scope="col">정산 주문건</th>
    </tr>
    </thead>
    <tbody>
<?php
for($i=0; $row=sql_fetch_array($result); $i++) {
    $bg = 'list'.($i%2);
    $temp_idx = $row['od_id_li'];
    $tot_supply = $row['tot_supply'];
    $tot_price = $tot_supply;
    $tot_cancel = $row['tot_cancel']+$row['tot_refund'];
    $tot_baesong = $row['tot_baesong1']+$row['tot_baesong2'];
    $tot_seller = $tot_supply - $tot_cancel + $tot_baesong;
?>
    <tr class="<?php echo $bg; ?>">
        <td>
            <input type="hidden" name="mb_id[<?php echo $i; ?>]" value="<?php echo $row['mb_id']; ?>">
            <input type="hidden" name="order_idx[<?php echo $i; ?>]" value="<?php echo $temp_idx; ?>">
            <input type="hidden" name="tot_price[<?php echo $i; ?>]" value="<?php echo $tot_price; ?>">
            <input type="hidden" name="tot_baesong[<?php echo $i; ?>]" value="<?php echo $tot_baesong; ?>">
            <input type="hidden" name="tot_supply[<?php echo $i; ?>]" value="<?php echo $tot_supply; ?>">
            <input type="hidden" name="tot_seller[<?php echo $i; ?>]" value="<?php echo $tot_seller; ?>">
            <input type="hidden" name="tot_cancel[<?php echo $i; ?>]" value="<?php echo $tot_cancel; ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
        </td>
        <td><?php echo $num--; ?></td>
        <td class="tal"><?php echo get_sideview($row['seller_mb_id'], $row['seller_id']); ?></td>
        <td class="tal"><?php echo $row['seller_company_name']; ?></td>
        <td class="tal bold"><?php echo number_format($row['count_od_id']); ?></td>
        <td class="tar"><?php echo number_format($tot_cancel); ?></td>
        <td class="tar"><?php echo number_format($tot_supply); ?></td>
        <td class="tar fc_00f bold"><?php echo number_format($tot_seller); ?></td>
        <td class="tar"><?php echo number_format($tot_baesong); ?></td>
        <td><a href="<?php echo TB_ADMIN_URL; ?>/seller/seller_pay_excel2.php?<?php echo $q1;?>&seller_code=<?php echo $row['seller_id']; ?>&company_name=<?php echo $row['seller_company_name']; ?>" class="btn_small">다운로드</a></td>
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
            <p>ㆍ<strong>공급사 정산관리에 출력되는 주문건은 정산여부와는 상관없이 출력됩니다.</strong></p>
            <p>ㆍ주문일이 검색 일자에 포함되는 <strong>배송중, 배송완료, 반품신청, 반품중, 반품 완료, 교환신청, 교환중, 교환완료</strong>상태의 주문건이 표시됩니다.</p>
            <p>ㆍ주문일은 검색일자 이전이지만, 반품 완료 일자가 검색 일자에 포함되는 <strong>반품 완료</strong>상태의 주문건도 표시됩니다. 이경우에는 해당 주문건의 정산액이 (-)차감으로 표시됩니다.</p>
            <p>ㆍ주문일은 검색일자 이전이지만, 교환 완료 일자가 검색 일자에 포함되는 <strong>반품 완료</strong>상태의 주문건도 표시됩니다. 이경우에는 해당 주문건의 정산액이 0원으로 표시됩니다.</p>
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
