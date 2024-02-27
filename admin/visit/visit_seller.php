<?php
if(!defined('_TUBEWEB_')) exit;

include_once(TB_ADMIN_PATH.'/visit/visit.sub.php');

?>
<div class="local_ov mart20">
<!--
	<strong>총 판매상품수 : <?php echo number_format(0); ?>건</strong>
	<span class="fc_red">(취소/환불/반품 내역은 제외)</span>
-->
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w100">
		<col class="w100">
		<col class="w100">
		<col class="w100">
		<col class="w100">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">날짜</th>
		<th scope="col">공급사</th>
		<th scope="col"><?php echo subject_sort_link('od_cnt',$q2); ?>주문건수</a></th>
		<th scope="col"><?php echo subject_sort_link('sum_qty',$q2); ?>주문갯수</a></th>
		<th scope="col"><?php echo subject_sort_link('sum_supply_price',$q2); ?>총공급가액</a></th>
	</tr>
	</thead>
	<tbody class="list">
	<?php
    $sql_order = "order by sum_supply_price desc";
    if( isset($orderby) ){
        $sql_order = "order by {$filed} {$orderby}";
    }
$sql = " select seller_id
            ,count(od_id) as od_cnt
            ,sum(supply_price) as sum_supply_price
            ,sum(sum_qty) as sum_qty
            from shop_order
            where 
                od_time between '{$fr_date}' and '{$to_date}'
                and dan in (2,3,4,5)
            group by seller_id
            {$sql_order}";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td><?php echo $fr_date." ~ ".$to_date; ?></td>
		<td><?php echo get_order_seller_id($row['seller_id']); ?></td>
		<td><?php echo number_format($row['od_cnt']); ?>건</td>
		<td><?php echo number_format($row['sum_qty']); ?>개</td>
		<td><?php echo number_format($row['sum_supply_price']); ?>원</td>
	</tr>
    <?php } ?>
	</tbody>
	</table>
</div>
