<?php
define('NO_CONTAINER', true);
include_once("./_common.php");
include_once(TB_ADMIN_PATH."/admin_access.php");
include_once(TB_ADMIN_PATH."/admin_head.php");
include_once(TB_ADMIN_PATH."/admin_topmenu.php");

//$sodrr = admin_order_status_sum("where dan > 0 "); // 총 주문내역
$sodr1 = admin_order_status_sum("where dan = 1 "); // 총 입금대기
$sodr2 = admin_order_status_sum("where dan = 2 "); // 총 결제완료
$sodr3 = admin_order_status_sum("where dan = 3 "); // 총 배송준비
$sodr4 = admin_order_status_sum("where dan = 4 "); // 총 배송중
//$sodr5 = admin_order_status_sum("where dan = 5 "); // 총 배송완료
//$sodr6 = admin_order_status_sum("where dan = 6 "); // 총 입금전 취소
//$sodr7 = admin_order_status_sum("where dan = 7 "); // 총 배송후 반품
//$sodr8 = admin_order_status_sum("where dan = 8 "); // 총 배송후 교환
//$sodr9 = admin_order_status_sum("where dan = 9 "); // 총 배송전 환불
$sodr10 = admin_order_status_sum("where dan = 10 "); // 총 반품 신청
$sodr11 = admin_order_status_sum("where dan = 11 "); // 총 반품 중
$sodr12 = admin_order_status_sum("where dan = 12 "); // 총 교환 신청
$sodr13 = admin_order_status_sum("where dan = 13 "); // 총 교환 중

//$final = admin_order_status_sum("where dan = 5 and user_ok = 0 "); // 총 구매미확정
?>

<div id="main_wrap">
	<section>
		<h2>전체 주문통계<a href="<?php echo TB_ADMIN_URL; ?>/order.php?code=list" class="btn_small">주문내역 바로가기</a></h2>
		<div class="order_vbx">
			<dl class="od_bx4">
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
			</dl>
			<dl class="od_bx3">
				<dt>구매확정/클래임 현황</dt>
				<dd>
					<p class="ddtit">반품 신청</p>
					<p><?php echo number_format($sodr10['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">반품 중</p>
					<p><?php echo number_format($sodr11['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">교환 신청</p>
					<p><?php echo number_format($sodr12['cnt']); ?></p>
				</dd>
				<dd>
					<p class="ddtit">교환 중</p>
					<p><?php echo number_format($sodr13['cnt']); ?></p>
				</dd>
			</dl>
		</div>
	</section>

    <section class="sidx_head01 padt10">
        <h2>승인 대기 중인 공급사<a href="<?php echo TB_ADMIN_URL; ?>/member.php?code=list" class="btn_small">공급사관리 바로가기</a></h2>
        <table>
        <thead>
        <tr>
            <th scope="col">아이디</th>
            <th scope="col">업체명</th>
            <th scope="col">대표자명</th>
            <th scope="col">사업자등록번호</th>
            <th scope="col">담당자 이름</th>
            <th scope="col">담당자 전화번호</th>
            <th scope="col">등록일시</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "select * from shop_seller where state=0  order by index_no desc limit 5";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++){
        ?>
        <tr class="tr_alignc">
            <td><?php echo $row['mb_id']; ?></td>
            <td><?php echo $row['company_name']; ?></td>
            <td><?php echo $row['company_owner']; ?></td>
            <td><?php echo $row['company_saupja_no']; ?></td>
            <td><?php echo $row['info_name']; ?></td>
            <td><?php echo $row['info_tel']; ?></td>
            <td><?php echo substr($row['reg_time'],0,16); ?> (<?php echo get_yoil($row['reg_time']); ?>)</td>
        </tr>
        <?php
        }
        if($i==0)
            echo '<tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
        </table>
    </section>

	<section class="sidx_head01 padt20">
		<h2>최근 주문내역<a href="<?php echo TB_ADMIN_URL; ?>/order.php?code=list" class="btn_small">주문내역 바로가기</a></h2>
		<table>
		<thead>
		<tr>
			<th scope="col">주문번호</th>
			<th scope="col">주문자명</th>
			<th scope="col">수령자명</th>
			<th scope="col">전화번호</th>
			<th scope="col">결제방법</th>
			<th scope="col">총주문액</th>
			<th scope="col">주문일시</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$sql = " select * from shop_order where dan > 0 order by index_no desc limit 5 ";
		$result = sql_query($sql);
		for($i=0; $row=sql_fetch_array($result); $i++){
			$amount = get_order_spay($row['od_id']);
		?>
		<tr class="tr_alignc">
			<td><?php echo $row['od_id']; ?></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['b_name']; ?></td>
			<td><?php echo $row['cellphone']; ?></td>
			<td><?php echo $row['paymethod']; ?></td>
			<td><?php echo number_format($amount['buyprice']); ?></td>
			<td><?php echo substr($row['od_time'],0,16); ?> (<?php echo get_yoil($row['od_time']); ?>)</td>
		</tr>
		<?php
		}
		if($i==0)
			echo '<tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</section>

</div>

<?php
include_once(TB_ADMIN_PATH."/admin_tail.php");
?>
