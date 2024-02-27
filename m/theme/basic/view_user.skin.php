<?php
if(!defined("_TUBEWEB_")) exit; // 개별 페이지 접근 불가
?>

<h2 class="pop_title">
	<?php echo $tb['title']; ?> <span class="fc_red">(<?php echo number_format($total_count); ?>)</span>
	<a href="javascript:cl_list();" class="btn_small bx-white">전체상품보기</a>
</h2>

<div id="sit_review">
	<table class="tbl_review">
	<colgroup>
		<col width="80px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<td class="image"><?php echo get_it_image($gs_id, $gs['simg1'], 80, 80); ?></td>
		<td class="gname">
			<?php echo get_text($gs['gname']); ?>
			<p class="bold mart5"><?php echo mobile_price($gs_id); ?></p>
		</td>
	</tr>
	</tbody>
	</table>

	<?php
	echo "<ul>\n";
	for($i=0; $row=sql_fetch_array($result); $i++)
	{
		$wr_star = $gw_star[$row['score']];
		$wr_id   = substr($row['mb_id'],0,3).str_repeat("*",strlen($row['mb_id']) - 3);
		$wr_time = substr($row['reg_time'],0,10);

		$hash = md5($row['index_no'].$row['reg_time'].$row['mb_id']);

		echo "<li class=\"lst\">\n";
		echo "<span class=\"lst_post\">{$row['memo']}</span>\n";
		echo "<span class=\"lst_h\"><span class=\"fc_255\">{$wr_star}</span>\n";
		echo "<span class=\"fc_999\"> / {$wr_id} / {$wr_time}";

		if(is_admin() || ($member['id'] == $row['mb_id'])) {
			echo "<a href=\"javascript:window.open('".TB_MSHOP_URL."/orderreview.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=u');\" class=\"marl10 tu fc_blk\">수정</a>\n";
			echo "<a href=\"".TB_MSHOP_URL."/orderreview_update.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=d&hash=$hash&p=1\" class=\"marl5 tu fc_blk itemqa_delete\">삭제</a>\n";
		}
		echo "</span>\n";
		echo "</li>\n";
	}

	if($i == 0) {
		echo "<li class=\"empty_list\">자료가 없습니다.</li>\n";
	}

	echo "</ul>\n";

	echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
	?>
	<div class="btn_confirm">
		<a href="javascript:window.open('<?php echo TB_MSHOP_URL; ?>/orderreview.php?gs_id=<?php echo $gs_id; ?>');" class="btn_medium">구매후기쓰기</a>
		<a href="javascript:window.close();" class="btn_medium bx-white">창닫기</a>
	</div>
</div>

<script>
function cl_list(){
	opener.location.href = tb_mobile_shop_url+'/list.php?ca_id=<?php echo $gs[ca_id]; ?>';
	window.close();
}

// 삭제
$(function(){
    $(".itemqa_delete").click(function(){
        return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
    });
});
</script>
