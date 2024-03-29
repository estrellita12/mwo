<?php
if(!defined('_TUBEWEB_')) exit;

include_once(TB_THEME_PATH.'/aside_my.skin.php');
?>

<div id="con_lf">
	<h2 class="pg_tit">
		<span><?php echo $tb['title']; ?></span>
		<p class="pg_nav">HOME<i>&gt;</i>마이페이지<i>&gt;</i><?php echo $tb['title']; ?></p>
	</h2>

	<h2 class="anc_tit">상세보기 버튼을 클릭하시면 주문상세내역을 조회하실 수 있습니다.</h2>
	<div class="tbl_head02 tbl_wrap">
		<table>
		<colgroup>
			<col class="w90">
			<col>
			<col class="w100">
			<col class="w140">
		</colgroup>
		<thead>
		<tr>
			<th scope="col">주문일자</th>
			<th scope="col">상품정보</th>
			<th scope="col">결제금액</th>
			<th scope="col">상태</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $row=sql_fetch_array($result); $i++) {
			$sql = " select * from shop_order where od_id = '{$row['od_id']}' order by od_time desc, index_no asc ";
			$res = sql_query($sql);
			$rowspan = sql_num_rows($res) + 1;

			for($k=0; $rw=sql_fetch_array($res); $k++) {
				$gs = unserialize($rw['od_goods']);

				$hash = md5($rw['gs_id'].$rw['od_no'].$rw['od_id']);
				$dlcomp = explode('|', trim($rw['delivery']));
				$href = TB_SHOP_URL.'/view.php?index_no='.$rw['gs_id'];

				if($k == 0) {
		?>
		<tr>
			<td class="tac" rowspan="<?php echo $rowspan; ?>">
				<p class="bold"><?php echo substr($rw['od_time'],0,10);?></p>
				<p class="padt5"><a href="<?php echo TB_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $rw['od_id']; ?>" class="btn_small grey">상세보기</a></p>
			</td>
		</tr>
		<?php } ?>
		<tr class="rows">
			<td>
				<div class="ini_wrap">
					<table class="wfull">
					<colgroup>
						<col class="w70">
						<col>
					</colgroup>
					<tr>
						<td class="vat tal"><a href="<?php echo $href; ?>"><?php echo get_od_image($rw['od_id'], $gs['simg1'], 60, 60); ?></a></td>
						<td class="vat tal">
							<a href="<?php echo $href; ?>"><?php echo get_text($gs['gname']); ?></a>
							<p class="padt3 fc_999">주문번호 : <?php echo $rw['od_id']; ?> / 수량 : <?php echo display_qty($rw['sum_qty']); ?> / 배송비 : <?php echo display_price($rw['baesong_price']); ?></p>
							<?php if($rw['dan'] == 5) { ?>
							<p class="padt3">
								<?php if(is_null_time($rw['user_date'])) { ?>
								<a href="javascript:final_confirm('<?php echo $hash; ?>');" class="btn_ssmall red">구매확정</a>
								<?php } ?>
								<a href="<?php echo TB_SHOP_URL; ?>/orderreview.php?gs_id=<?php echo $rw['gs_id']; ?>&od_id=<?php echo $rw['od_id']; ?>" onclick="win_open(this, 'winorderreview', '650', '530','yes');return false;" class="btn_ssmall bx-white">구매후기 작성</a>
							</p>
							<?php } ?>
						</td>
					</tr>
					</table>
				</div>
			</td>
			<td class="tar"><?php echo display_price($rw['use_price']); ?></td>
			<td class="tac">
				<p><?php echo $gw_status[$rw['dan']]; ?></p>
				<?php if($dlcomp[0] && $rw['delivery_no']) { ?>
				<p class="padt3 fc_90"><?php echo $dlcomp[0]; ?><br><?php echo $rw['delivery_no']; ?></p>
				<?php } ?>
				<?php if($dlcomp[1] && $rw['delivery_no']) { ?>
				<p class="padt3"><?php echo get_delivery_inquiry($rw['delivery'], $rw['delivery_no'], 'btn_ssmall'); ?></p>
				<?php } ?>
			</td>
		</tr>
		<?php }
		}
		if($i==0)
			echo '<tr><td colspan="4" class="empty_list">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<?php
	echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
	?>
</div>
