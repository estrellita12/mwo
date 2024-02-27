<?php
if(!defined('_TUBEWEB_')) exit;
?>

<div class="tbl_frm01 tbl_wrap">
	<table>
	<tbody>
	<tr>
		<td class="list1 fs14"><b><?php echo $bo_subject; ?></b></td>
	</tr>
	<tr>
		<td class="list1 tal"><b><?php echo $bo_writer_s; ?></b> <?php if($bo_writer_id){?>(<?php echo $bo_writer_id; ?>)<?php } ?>, <b>작성일</b> : <?php echo $bo_wdate; ?>, <b>조회수</b> : <?php echo $bo_hit; ?></td>
	</tr>
	<?php if($bo_file1) { ?>
	<tr>
		<td>첨부파일1 : <a href="./download.php?file=<?php echo $bo_file1; ?>&url=<?php echo TB_DATA_PATH; ?>/board/<?php echo $boardid; ?>/<?php echo $bo_file1; ?>"><b><?php echo $bo_file1; ?></b></a></td>
	</tr>
	<?php } ?>
	<?php if($bo_file2) { ?>
	<tr>
		<td>첨부파일2 : <a href="./download.php?file=<?php echo $bo_file2; ?>&url=<?php echo TB_DATA_PATH; ?>/board/<?php echo $boardid; ?>/<?php echo $bo_file2; ?>"><b><?php echo $bo_file2; ?></b></a></td>
	</tr>
	<?php } ?>
	<tr>
		<td style="height:200px;vertical-align:top;">
		<?php
		// 픽셀 (게시판에서 출력되는 이미지의 폭 크기)
		if($board['width'] > 100) {
			$thumbnail_width = $board['width'];
		} else {
			$thumbnail_width = 730;
		}
		if($bo_file1 && preg_match("/\.(gif|jpg|jpeg|png)$/i", $bo_file1))
		{
			$file1anal = explode(".",$bo_file1);
			if(in_array($file1anal[1],$accept))
			{
				$imgsize1 = getimagesize(TB_DATA_PATH."/board/".$boardid."/".$bo_file1);
				if($imgsize1[0] > $thumbnail_width) {
					$width = $thumbnail_width;
					$height = ($imgsize1[1] / $imgsize1[0]) * $thumbnail_width;
				} else {
					$width = $imgsize1[0];
					$height = $imgsize1[1];
				}
			}
		?>
		<a href="javascript:imgview('<?php echo TB_DATA_URL; ?>/board/<?php echo $boardid; ?>/<?php echo $bo_file1; ?>');"><img src="<?php echo TB_DATA_URL; ?>/board/<?php echo $boardid; ?>/<?php echo $bo_file1; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a><br><br>
		<?php
		}

		if($bo_file2 && preg_match("/\.(gif|jpg|jpeg|png)$/i", $bo_file2))
		{
			$file2anal = explode(".",$bo_file2);
			if(in_array($file2anal[1],$accept))
			{
				$imgsize1 = getimagesize(TB_DATA_PATH."/board/".$boardid."/".$bo_file2);
				if($imgsize1[0] > $thumbnail_width) {
					$width = $thumbnail_width;
					$height = ($imgsize1[1] / $imgsize1[0]) * $thumbnail_width;
				} else {
					$width = $imgsize1[0];
					$height = $imgsize1[1];
				}
			}
		?>
		<a href="javascript:imgview('<?php echo TB_DATA_URL; ?>/board/<?php echo $boardid; ?>/<?php echo $bo_file2; ?>');"><img src="<?php echo TB_DATA_URL; ?>/board/<?php echo $boardid; ?>/<?php echo $bo_file2; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a>
		<?php
		}

		echo get_view_thumbnail(conv_content($bo_memo, 1), $thumbnail_width);
		?>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="page_wrap">
	<div class="lbt_box">
		<a href="./list.php?<?php echo $qstr1; ?>" class="btn_lsmall bx-white">목록</a>
	</div>
	<div class="rbt_box">
		<?php if( ($member['index_no'] == $bo_writer &&  $boardid!='42' ) || is_admin() ) { ?>
		<a href="./modify.php?<?php echo $qstr2; ?>" class="btn_lsmall bx-white">수정</a>
		<?php } ?>
		<?php if($member['index_no'] && $member['grade']<=$board['reply_priv'] && $board['usereply']=='Y') { ?>
		<a href="./reply.php?<?php echo $qstr2; ?>" class="btn_lsmall bx-white">답글</a>
		<?php } ?>
		<?php if( ($member['index_no'] == $bo_writer &&  $boardid!='42' ) || is_admin() ) { ?>
		<a href="./del.php?<?php echo $qstr2; ?>" class="btn_lsmall bx-white">삭제</a>
		<?php } ?>
		<?php if($member['grade'] <= $board['write_priv']){ ?>
		<a href="./write.php?boardid=<?php echo $boardid; ?>" class="btn_lsmall">글쓰기</a>
		<?php } ?>
	</div>
</div>

<!--코멘트 출력부분-->
<?php if($board['usetail']=='Y') { ?>
<form name="fboardform" id="fboardform" method="post" action="<?php echo $from_action_url; ?>" onsubmit="return fboardform_submit(this);">
<input type="hidden" name="mode" value="w">
<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">
<input type="hidden" name="boardid" value="<?php echo $boardid; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

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
	?>
	<tr class="list1">
		<td>작성자 : <b><?php echo $row['writer_s']; ?></b> (<?php echo $bo_wdate; ?>) <?php echo "<a href=\"./tail_del.php?tailindex={$row['index_no']}&{$qstr2}\" class=\"btn_ssmall bx-white\">삭제</a>"; ?></td>
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
<div class="tbl_frm01 tbl_wrap">
	<table>
	<tr>
		<td colspan="2">
			작성자 : <input type="text" name="writer_s" value="<?php echo $member['name']; ?>" class="frm_input marr15" size="20">
			<?php if(!$is_member) { ?>
			비밀번호 : <input type="password" name="passwd" class="frm_input" size="20">
			<?php } ?>
		</td>
	</tr>
	<tr class="list1">
		<td width="90%"style="padding:10px 0 10px 10px"><textarea name="memo" class="frm_textbox h60"></textarea></td>
		<td class="tar padr10 padl10"><input type="submit" value="댓글입력" class="btn_medium grey h60"></td>
	</tr>
	</table>
</div>
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
</script>
<?php } ?>

<script>
function imgview(img) {
	 window.open("imgviewer.php?img="+img,"img",'width=150,height=150,status=no,top=0,left=0,scrollbars=yes');
}
</script>

<?php
include_once(TB_BBS_PATH."/skin/{$board['list_skin']}/read_list.php");
?>