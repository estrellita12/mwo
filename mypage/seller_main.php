<?php
if(!defined('_TUBEWEB_')) exit;

$pg_title = "전체 거래진행 통계내역";
include_once("./admin_head.sub.php");

$sql_where = " where seller_id = '{$seller['seller_code']}' ";

$sodr2 = admin_order_status_cnt("{$sql_where} and dan = 2 "); // 총 결제완료
$sodr3 = admin_order_status_cnt("{$sql_where} and dan = 3 "); // 총 배송준비
$sodr4 = admin_order_status_cnt("{$sql_where} and dan = 4 "); // 총 배송중
$sodr9 = admin_order_status_cnt("{$sql_where} and dan = 9 "); // 총 배송전 환불

$sodr12 = admin_order_status_cnt("{$sql_where} and dan = 12 "); // 교환신청
$sodr13 = admin_order_status_cnt("{$sql_where} and dan = 13 "); // 교환중
$sodr10 = admin_order_status_cnt("{$sql_where} and dan = 10 "); // 반품신청
$sodr11 = admin_order_status_cnt("{$sql_where} and dan = 10 "); // 반품중
?>

<div id="main_wrap">
	<section>
		<h2>전체 주문통계<a href="<?php echo TB_MYPAGE_URL; ?>/page.php?code=seller_odr_list" class="btn_small">주문내역 바로가기</a></h2>
		<div class="order_vbx">
		<dl class="od_bx3">
				<dt>주문상태 현황</dt>
				<dd>
					<p class="ddtit">결제완료</p>
					<p><?php echo number_format($sodr2['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">배송준비</p>
					<p><?php echo number_format($sodr3['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">배송중</p>
					<p><?php echo number_format($sodr4['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">환불</p>
					<p><?php echo number_format($sodr9['cnt']); ?></p>
				</dd>
   		</dl>
		<dl class="od_bx3">
				<dt>클래임 현황</dt>
				<dd>
					<p class="ddtit">교환 신청</p>
					<p><?php echo number_format($sodr12['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">교환 중</p>
					<p><?php echo number_format($sodr13['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">반품 신청</p>
					<p><?php echo number_format($sodr10['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">반품중</p>
					<p><?php echo number_format($sodr11['cnt']); ?></p>
				</dd>
			</dl>
		</div>
	</section>
	<section>
		<table class="wfull">
		<tr>
			<td width="49.5%" valign="top" class="sidx_head01">
				<h2>공지사항<a href="<?php echo TB_BBS_URL; ?>/list.php?boardid=20" class="btn_small">바로가기</a></h2>
				<table>
				<colgroup>
					<col width="20%">
					<col width="80%">
				</colgroup>
				<thead>
				<tr>
					<th scope="col">등록일</th>
					<th scope="col">제목</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sql = "select * from shop_board_20 order by wdate desc limit 5 ";
				$res = sql_query($sql);
				for($i=0;$row=sql_fetch_array($res);$i++){
					$bo_subject = cut_str($row['subject'],40);
					$bo_date = date('Y-m-d', $row['wdate']);
					$bo_href = TB_BBS_URL."/read.php?boardid=20&index_no=$row[index_no]";
				?>
				<tr>
					<td class="tac"><?php echo $bo_date; ?></td>
					<td class="tal"><a href="<?php echo $bo_href; ?>"><?php echo $bo_subject; ?></a></td>
				</tr>
				<?php
				}
				if($i == 0)
					echo '<tr><td colspan="2" class="empty_table">자료가 없습니다.</td></tr>';
				?>
				</tbody>
				</table>
			</td>
			<td width="1%"></td>
            <td width="49.5%" valign="top" class="sidx_head01">
				<h2>제안서<a href="<?php echo TB_BBS_URL; ?>/list.php?boardid=42" class="btn_small">바로가기</a></h2>
				<table>
				<colgroup>
					<col width="20%">
					<col width="80%">
				</colgroup>
				<thead>
				<tr>
					<th scope="col">등록일</th>
					<th scope="col">제목</th>
				</tr>
				</thead>
				<tbody>
				<?php
                $sql = "select * from shop_board_42 where writer_s='{$member['name']}' order by wdate desc limit 5 ";
				$res = sql_query($sql);
				for($i=0;$row=sql_fetch_array($res);$i++){
					$bo_subject = cut_str($row['subject'],40);
					$bo_date = date('Y-m-d', $row['wdate']);
					$bo_href = TB_BBS_URL."/read.php?boardid=42&index_no=$row[index_no]";
				?>
				<tr>
					<td class="tac"><?php echo $bo_date; ?></td>
					<td class="tal"><a href="<?php echo $bo_href; ?>"><?php echo $bo_subject; ?></a></td>
				</tr>
				<?php
				}
				if($i == 0)
					echo '<tr><td colspan="2" class="empty_table">자료가 없습니다.</td></tr>';
				?>
				</tbody>
				</table>
			</td>
		</tr>
		</table>
	</section>

    <!-- 2022-04-04 -->
	<section>
		<table class="wfull">
		<tr>
            <td width="49.5%" valign="top" class="sidx_head01">
				<h2>질문과답변<a href="<?php echo TB_BBS_URL; ?>/list.php?boardid=21" class="btn_small">바로가기</a></h2>
				<table>
				<colgroup>
					<col width="20%">
					<col width="80%">
				</colgroup>
				<thead>
				<tr>
					<th scope="col">등록일</th>
					<th scope="col">제목</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$sql = "select * from shop_board_21 order by wdate desc limit 5 ";
				$res = sql_query($sql);
				for($i=0;$row=sql_fetch_array($res);$i++){
					$bo_subject = cut_str($row['subject'],40);
					$bo_date = date('Y-m-d', $row['wdate']);
					$bo_href = TB_BBS_URL."/read.php?boardid=21&index_no=$row[index_no]";
				?>
				<tr>
					<td class="tac"><?php echo $bo_date; ?></td>
					<td class="tal"><a href="<?php echo $bo_href; ?>"><?php echo $bo_subject; ?></a></td>
				</tr>
				<?php
				}
				if($i == 0)
					echo '<tr><td colspan="2" class="empty_table">자료가 없습니다.</td></tr>';
				?>
				</tbody>
				</table>
			</td>
			<td width="1%"></td>
			<td width="49.5%" valign="top" class="sidx_head01">
			</td>
		</tr>
		</table>
	</section>

</div>

<?php
include_once("./admin_tail.sub.php");
?>
