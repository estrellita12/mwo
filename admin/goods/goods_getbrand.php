<?php
if(!defined('_TUBEWEB_')) exit;

include_once(TB_ADMIN_PATH.'/goods/goods_sub.php');
?>

<form name="fgoodslist" id="fgoodslist" method="post" action="./goods/goods_list_update.php" onsubmit="return fgoodslist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
	<span class="ov_a">
		<select id="page_rows" onchange="location='<?php echo "{$_SERVER['SCRIPT_NAME']}?{$q1}&page=1"; ?>&page_rows='+this.value;">
			<?php echo option_selected('30',  $page_rows, '30줄 정렬'); ?>
			<?php echo option_selected('50',  $page_rows, '50줄 정렬'); ?>
			<?php echo option_selected('100', $page_rows, '100줄 정렬'); ?>
			<?php echo option_selected('150', $page_rows, '150줄 정렬'); ?>
		</select>
	</span>
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>

<div class="tbl_head02">
	<table id="sodr_list" class="tablef">
	<colgroup>
		<col class="w50">
		<col class="w50">
		<col class="w60">
		<col class="w120">
		<col>
		<col>
		<col class="w80">
		<col class="w80">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w60">
		<col class="w60">
	</colgroup>
	<thead>
	<tr>
		<th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col" rowspan="2">번호</th>
		<th scope="col" rowspan="2">이미지</th>
		<th scope="col"><?php echo subject_sort_link('gcode',$q2); ?>상품코드</a></th>
		<th scope="col" colspan="2"><?php echo subject_sort_link('gname',$q2); ?>상품명</a></th>
		<th scope="col"><?php echo subject_sort_link('reg_time',$q2); ?>최초등록일</a></th>
		<th scope="col"><?php echo subject_sort_link('isopen',$q2); ?>진열</a></th>
		<th scope="col" colspan="4" class="th_bg">가격정보</th>
		<th scope="col" rowspan="2"><?php echo subject_sort_link('rank',$q2); ?>순위</a></th>
		<th scope="col" rowspan="2">관리</th>
	</tr>
	<tr class="rows">
		<th scope="col"><?php echo subject_sort_link('mb_id',$q2); ?>업체코드</a></th>
		<th scope="col">공급사명</th>
		<th scope="col"><?php echo subject_sort_link('brand_nm',$q2); ?>브랜드명</a></th>
		<th scope="col"><?php echo subject_sort_link('update_time',$q2); ?>최근수정일</a></th>
		<th scope="col"><?php echo subject_sort_link('stock_qty',$q2); ?>재고</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('normal_price',$q2); ?>시중가</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('supply_price',$q2); ?>공급가</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('goods_price',$q2); ?>판매가</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('gpoint',$q2); ?>포인트</a></th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$gs_id = $row['index_no'];

		if($row['stock_mod'])
			$stockQty = number_format($row['stock_qty']);
		else
			$stockQty = '<span class="txt_false">무제한</span>';

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td rowspan="2">
			<input type="hidden" name="gs_id[<?php echo $i; ?>]" value="<?php echo $gs_id; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td rowspan="2"><?php echo $num--; ?></td>
		<td rowspan="2"><a href="<?php echo TB_SHOP_URL; ?>/view.php?index_no=<?php echo $gs_id; ?>" target="_blank"><?php echo get_it_image($gs_id, $row['simg1'], 40, 40); ?></a></td>
		<td><?php echo $row['gcode']; ?></td>
		<td colspan="2" class="tal"><?php echo get_text($row['gname']); ?></td>
		<td><?php echo substr($row['reg_time'],2,8); ?></td>
		<td><?php echo $gw_isopen[$row['isopen']]; ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['normal_price']); ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['supply_price']); ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['goods_price']); ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['gpoint']); ?></td>
		<td rowspan="2"><input type="text" class="frm_input" name="rank[<?php echo $i; ?>]" value='<?php echo $row['rank']; ?>'></td>
		<td rowspan="2"><a href="./goods.php?code=form&w=u&gs_id=<?php echo $gs_id.$qstr; ?>&page=<?php echo $page; ?>&bak=<?php echo $code; ?>" class="btn_small">수정</a></td>
	</tr>
	<tr class="<?php echo $bg; ?>">
		<td class="fc_00f"><?php echo $row['mb_id']; ?></td>
		<td class="tal txt_succeed"><?php echo get_seller_name($row['mb_id']); ?></td>
		<td class="tal txt_succeed"><?php echo $row['brand_nm']; ?></td>
		<td class="fc_00f"><?php echo substr($row['update_time'],2,8); ?></td>
		<td><?php echo $stockQty; ?></td>
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

<h2>브랜드연결 및 해제 일괄처리</h2>
<form name="frmbrand" id="frmbrand" method="post" autocomplete="off">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">적용조건</th>
		<td>
			<input type="radio" name="gubun" value="1" id="gubun_1" checked="checked">
			<label for="gubun_1">선택한 상품만 적용</label>
			<input type="radio" name="gubun" value="2" id="gubun_2">
			<label for="gubun_2">검색된 상품 전체(<?php echo number_format($total_count); ?>개)를 적용</label>
		</td>
	</tr>
	<tr>
		<th scope="row">연결하기</th>
		<td>
			<label for="new_brand" class="sound_only">브랜드</label>
			<select name="new_brand" id="new_brand">
				<?php
				echo option_selected('', '', '선택');
				$sql = "select * from shop_brand where br_user_yes='0' order by br_name asc ";
				$res = sql_query($sql);
				while($row = sql_fetch_array($res)){
					echo option_selected($row['br_id'], '', $row['br_name']);
				}
				?>
			</select>
			<input type="button" value="일괄적용하기" onclick="js_chk_frm(this.form, 1);" class="btn_small">
		</td>
	</tr>
	<tr>
		<th scope="row">연결해제</th>
		<td><input type="button" value="선택(검색)된 상품의 모든 브랜드를 연결해제" onclick="js_chk_frm(this.form, 2);" class="btn_small"></td>
	</tr>
	</tbody>
	</table>
</div>
</form>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ일괄수정 할 상품을 검색 후 상품 브랜드를 일괄처리 하시기 바랍니다.</p>
			<p>ㆍ서버 부하등 안정적인 서비스를 위해서 수정할 상품이 많은 경우에는 "검색된 상품에 적용"은 피하시기 바랍니다.</p>
		</div>
		<div class="hd">ㆍ브랜드설정 안내</div>
		<div class="desc01">
			<p>ㆍ<em>[연결하기]</em> 기존에 연결되어있는 모든 브랜드는 삭제되며 새롭운 브랜드만 연결됩니다.</p>
			<p>ㆍ<em>[연결해제]</em> 기존에 연결되어있는 모든 브랜드가 삭제됩니다.</p>
		</div>
	 </div>
</div>

<script>
function fgoodslist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

// 일괄적용하기
function js_chk_frm(f2, act)
{
	var f = document.fgoodslist;
	if(getRadioVal(f2.gubun) == 1) {
		var chk = document.getElementsByName("chk[]");
		var bchk = false;
		for(i=0; i<chk.length; i++)
		{
			if(chk[i].checked)
				bchk = true;
		}

		if(!bchk)
		{
			alert("적용할 자료를 하나 이상 선택하세요.");
			return;
		}
	}

	if(act == 1) {
		if(getSelectVal(f2.new_brand) == "") {
			alert("적용할 브랜드를 선택하세요.");
			return;
		}
	}

	addHidden(f, 'gubun', getRadioVal(f2.gubun));
	addHidden(f, 'new_brand', getSelectVal(f2.new_brand));
	addHidden(f, 'act', act);

	if(confirm("일괄적용 후에는 이전상태로 복원이 되지않습니다.\n\n정말 적용하시겠습니까?")) {
		var token = get_ajax_token();
        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }

		f.token.value = token;
		f.action = "./goods/goods_getbrandupdate.php";
		f.submit();
	}
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date,#to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
