<?php
if(!defined("_TUBEWEB_")) exit; // 개별 페이지 접근 불가
?>

<div class="m_bo_bg mart10">
	<div class="title"><?php echo $bo_subject; ?></div>
	<div class="wr_name"><?php echo $write['writer_s']; ?><span class="wr_day"><?php echo $bo_wdate; ?></span></div>
	<div class="wr_txt">
		<?php
		$file1 = TB_DATA_PATH."/board/{$boardid}/{$write['fileurl1']}";
		if(is_file($file1) && preg_match("/\.(gif|jpg|jpeg|png)$/i", $write['fileurl1'])) {
			$file1 = rpc($file1, TB_PATH, TB_URL);
		?>
		<img src="<?php echo $file1; ?>" class="img_fix">
		<?php } ?>
		<?php
		$file2 = TB_DATA_PATH."/board/{$boardid}/{$write['fileurl2']}";
		if(is_file($file2) && preg_match("/\.(gif|jpg|jpeg|png)$/i", $write['fileurl2'])) {
			$file2 = rpc($file2, TB_PATH, TB_URL);
		?>
		<img src="<?php echo $file2; ?>" class="img_fix">
		<?php } ?>

		<div class="img_fix2 iframe_cont">
			<?php echo conv_content($write['memo'], 1); ?>
		</div>
	</div>
</div>

<div class="btn_confirm">
	<a href="<?php echo TB_MBBS_URL; ?>/board_list.php?<?php echo $qstr1; ?>" class="btn_medium bx-white">목록</a>
	<?php if($member['grade']<=$board['reply_priv'] && $board['usereply']=='Y') { ?>
	<a href="<?php echo TB_MBBS_URL; ?>/board_write.php?<?php echo $qstr2; ?>&w=r" class="btn_medium bx-white">답변</a>
	<?php } if(($mb_no == $write['writer']) || is_admin()) { ?>
	<a href="<?php echo TB_MBBS_URL; ?>/board_write.php?<?php echo $qstr2; ?>&w=u" class="btn_medium bx-white">수정</a>
	<a href="<?php echo TB_MBBS_URL; ?>/board_delete.php?<?php echo $qstr2; ?>" class="btn_medium bx-white">삭제</a>
	<?php } ?>
</div>

<!--코멘트 출력부분-->
<?php if($board['usetail']=='Y') { ?>
<form name="fboardform" id="fboardform" class="m_bo_bg mart30" method="post" action="<?php echo $from_action_url; ?>" onsubmit="return fboardform_submit(this);">
<input type="hidden" name="mode" value="w">
<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">
<input type="hidden" name="boardid" value="<?php echo $boardid; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="<?php echo $token; ?>">

<?php
$sql = "select * from shop_board_{$boardid}_tail where board_index='$index_no' order by wdate asc";
$res = sql_query($sql);
if(sql_num_rows($res)) {
?>
<div class="tbl_frm02 tbl_wrap marb10">
	<table>
	<tbody>
	<?php
	while($row=sql_fetch_array($res)) {
		$bo_wdate = date("Y-m-d H:i:s",$row['wdate']);

		$btn_del = "";
		if($is_member && (($mb_no == $write['writer']) || is_admin())) {
			$btn_del = " <a href=\"./board_tail_del.php?tailindex={$row['index_no']}&{$qstr2}\" class=\"btn_ssmall red fr\" onclick=\"return bo_delete_confirm(this);\">삭제</a>";
		}
	?>
	<tr class="list1">
		<td>작성자 : <b><?php echo $row['writer_s']; ?></b> (<?php echo $bo_wdate; ?>)<?php echo $btn_del; ?></td>
	</tr>
	<tr>
		<td><?php echo conv_content($row['memo'], 0); ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>
<?php } ?>

<?php if($member['grade'] <= $board['tail_priv']) { ?>
<table class="wfull bd">
<tr height="50">
	<td class="tal padl10" colspan="2">
		작성자 : <input type="text" name="writer_s" value="<?php echo $member['name']; ?>" class="frm_input w100 marr15">
		<?php if(!$is_member) { ?>
		비밀번호 : <input type="password" name="passwd" class="frm_input w100">
		<?php } ?>
	</td>
</tr>
<tr height="80">
	<td class="tal padl10" width="80%"><textarea name="memo" class="frm_textbox h60"></textarea></td>
	<td class="tar padl10 padr10"><input type="submit" value="댓글입력" class="btn_medium grey h60"></td>
</tr>
</table>
<?php } ?>
</form>

<script>
function fboardform_submit(f)
{
	if(!f.writer_s.value) {
		alert('작성자명을 입력하세요.');
		f.writer_s.focus();
		return false;
	}

	<?php if(!$is_member) { ?>
	if(!f.passwd.value) {
		alert('비밀번호를 입력하세요.');
		f.passwd.focus();
		return false;
	}
	<?php } ?>

	if(!f.memo.value) {
		alert('댓글을 작성하지 않았습니다!');
		f.memo.focus();
		return false;
	}

	return true;
}

function bo_delete_confirm(el)
{
    if(confirm("댓글을 삭제 하시겠습니까?")) {
        el.href = href;
        return true;
    } else {
        return false;
    }
}
</script>
<?php } ?>
