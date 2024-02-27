<?php
include_once("./_common.php");
if(!$od_id)
alert_close("주문번호가 넘어오지 않았습니다.");

$sql = " select * from shop_order where od_id IN ({$od_id}) group by od_id order by index_no desc ";
$result = sql_query($sql);
$cnt = @sql_num_rows($result);
if(!$cnt)
alert_close("출력할 자료가 없습니다.");

$sql2 = " select * from shop_order where od_id = '{$od_id}' order by od_time desc, index_no asc ";
$od = sql_fetch($sql2);

$tb['title'] = "주문내역";
include_once(TB_ADMIN_PATH."/admin_head.php");
?>

<div id="sodr_print_pop" class="new_win">
    <form method="post" action="./seller_odr_log_update.php">
<input type="hidden" name="od_id" value="<?php echo $od['od_id'] ?>">
        <h1>CS 이력 추가</h1>
        <div class="tbl_frm01 marl10 marr10">
            <table>
                <colgroup>
                    <col class="w180">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th>주문번호</th>
                    <td><?php echo $od['od_id'] ?></td>
                </tr>
                <tr>
                    <th>주문자</th>
                    <td><?php echo $od['name'] ?></td>
                </tr>
                <tr>
                    <th>CS 내용</th>
                    <td><textarea name="memo" required></textarea></td>
                </tr>
                </tbody>
            </table>
            <div class="btn_confirm">
                <input type="submit" value="등록" id="btn_submit" class="btn_medium" accesskey="s">
            </div>
        </div>
    </form>
</div>

</body>
</html>
