<?php
include_once("./_common.php");

check_demo();

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

$company_name = '';

$sql_common = " from shop_order a, shop_seller b ";
$sql_search = " where a.seller_id=b.seller_code and seller_id='{$seller_id}'  and ( dan IN(4,5,10,11,12,13,8) and sellerpay_yes = '0' ";

if($fr_date && $to_date) {
    $sql_search .= " and left(od_time,10) between '$fr_date' and '$to_date' ";
}
$sql_search .= ") or ( dan IN(10) and sellerpay_yes = '1' )  ";

// 플러스 정산
// 주문상태 : 배송중,배송완료,교환신청,교환중,교환완료,반품신청,반품중
// 정상산태 : 미처리
// 마이너스 정산
// 주문상태 : 반품 완료
// 정상산태 : 처리
/*
if( empty($fr_date) || empty($to_date) ){
    $search_order = " dan IN (4,5,12,13,8,10,11) and sellerpay_yes = '0' ";
    $search_cancel = ' 1 != 1 ';
}else{
    $search_order = " dan IN (4,5,12,13,8,10,11) and sellerpay_yes = '0' and left(od_time,10) between '$fr_date' and '$to_date' ";
    $search_cancel = " dan IN (7) and sellerpay_yes = '0' and ( not left(od_time,10) between '$fr_date' and '$to_date' ) and left(rcent_time,10) between '$fr_date' and '$to_date' ";
}
*/

$sql = " select a.*, b.company_name, seller_comm
    $sql_common
    $sql_search and ( ($search_order)  )
    $sql_order ";

$result = sql_query($sql);
$cnt = @sql_num_rows($result);
if(!$cnt)
    alert("출력할 자료가 없습니다.");

/** Include PHPExcel */
include_once(TB_LIB_PATH.'/PHPExcel.php');

// Create new PHPExcel object
$excel = new PHPExcel();

$TH_COLOR = array(
    //배경색 설정
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'444444'),
    ),

    //글자색 설정
    'font' => array(
        'bold' => 'true',
        'size' => '10',
        'color' => array('rgb'=>'ffffff')
    )

);

// Add some data
$char = 'A';
$excel->setActiveSheetIndex(0)
      ->setCellValue($char++.'1', '업체코드')
      ->setCellValue($char++.'1', '공급사명')
      ->setCellValue($char++.'1', '주문번호')
      ->setCellValue($char++.'1', '주문시간')
      ->setCellValue($char++.'1', '택배사')
      ->setCellValue($char++.'1', '송장번호')
      ->setCellValue($char++.'1', '수취인')
      ->setCellValue($char++.'1', '수집상품명')
      ->setCellValue($char++.'1', '수집옵션명')
      ->setCellValue($char++.'1', '수량')
      ->setCellValue($char++.'1', '공급가액')
      ->setCellValue($char++.'1', '배송비')
      ->setCellValue($char++.'1', '실정산액')
      ->setCellValue($char++.'1', '세금구분')
      ->setCellValue($char++.'1', '주문상태')
      ->setCellValue($char++.'1', '최종처리일')
      ->setCellValue($char++.'1', '기타');
$excel->getActiveSheet()->getStyle("A1:Q1")->applyFromArray($TH_COLOR);



$res_supply = 0;
$res_tot = 0;
$res_qty = 0;
$res_baesong = 0;

$sql = " select * $sql_common $sql_search and $search_order $sql_order ";
$result = sql_query($sql);

for($i=2; $row=sql_fetch_array($result); $i++)
{
    // 정산액 = (공급가합 + 배송비)
    $tot_seller = ( ($row['supply_price'] + $row['baesong_price']) * $row['seller_comm'] ) / 100;

    $res_supply += $row['supply_price'];
    $res_baesong += $row['baesong_price'];
    $res_qty += $row['sum_qty'];
    $res_tot += $tot_seller;


    $gs = unserialize($row['od_goods']);
    $amount = get_order_spay($row['od_id']);
    $company_name = $row['company_name'];
    $sodr = array();
    $sodr['it_options'] =  print_complete_options($row['gs_id'], $row['od_id'], 1);
    $sodr['od_delivery_company'] = explode("|",$row['delivery'])[0];
    $char = 'A';
    $excel->setActiveSheetIndex(0)
          ->setCellValueExplicit($char++.$i, $row['seller_id'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $company_name, PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['od_id'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['od_time'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $sodr['od_delivery_company'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['delivery_no'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['b_name'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $gs['gname'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $sodr['it_options'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['sum_qty'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['supply_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$i, $row['baesong_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$i, $tot_seller, PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$i, '과세', PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $gw_status[$row['dan']], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['rcent_time'], PHPExcel_Cell_DataType::TYPE_STRING);

    $excel->getActiveSheet()->getStyle("J$i:M$i")->getNumberFormat()->setFormatCode('#,##0');
}


$TD_COLOR = array(
    //배경색 설정
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'fff2cc'),
    )

);

$sql = " select * $sql_common $sql_search and $search_cancel $sql_order ";
$result = sql_query($sql);

for($j=$i; $row=sql_fetch_array($result); $j++)
{
    // 정산액 = (공급가합 + 배송비)
    $row['supply_price'] = $row['supply_price'] * -1;
    $row['baesong_price'] = $row['baesong_price'] * -1;
    $tot_seller = ( ($row['supply_price'] + $row['baesong_price']) * $row['seller_comm'] ) / 100;

    //$res_supply += $row['supply_price'];
    //$res_baesong += $row['baesong_price'];
    //$res_qty += $row['sum_qty'];
    $res_tot += $tot_seller;

    $gs = unserialize($row['od_goods']);
    $amount = get_order_spay($row['od_id']);
    $sodr = array();
    $sodr['it_options'] =  print_complete_options($row['gs_id'], $row['od_id'], 1);
    $sodr['od_delivery_company'] = explode("|",$row['delivery'])[0];
    $char = 'A';
    $excel->setActiveSheetIndex(0)
          ->setCellValueExplicit($char++.$j, $row['seller_id'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['company_name'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['od_id'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['od_time'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $sodr['od_delivery_company'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['delivery_no'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['b_name'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $gs['gname'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $sodr['it_options'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['sum_qty'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['supply_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$j, $row['baesong_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$j, $tot_seller, PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$j, '과세', PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $gw_status[$row['dan']], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$j, $row['rcent_time'], PHPExcel_Cell_DataType::TYPE_STRING);

    $excel->getActiveSheet()->getStyle("J$j:M$j")->getNumberFormat()->setFormatCode('#,##0');
    $excel->getActiveSheet()->getStyle("A$j:$char$j")->applyFromArray($TD_COLOR);
}


$RES_COLOR = array(
    //배경색 설정
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'f4cccc'),
    )

);

$char = 'J';
$excel->setActiveSheetIndex(0)
      ->setCellValueExplicit($char++.$j, $res_qty, PHPExcel_Cell_DataType::TYPE_NUMERIC)
      ->setCellValueExplicit($char++.$j, $res_supply, PHPExcel_Cell_DataType::TYPE_NUMERIC)
      ->setCellValueExplicit($char++.$j, $res_baesong, PHPExcel_Cell_DataType::TYPE_NUMERIC)
      ->setCellValueExplicit($char++.$j, $res_tot, PHPExcel_Cell_DataType::TYPE_NUMERIC);
$excel->getActiveSheet()->getStyle("J$j:M$j")->getNumberFormat()->setFormatCode('#,##0');
$excel->getActiveSheet()->getStyle("J$j:M$j")->applyFromArray($RES_COLOR);


// Rename worksheet
$excel->getActiveSheet()->setTitle('공급업체주문내역');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel -> setActiveSheetIndex(0);
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('P')->setWidth(22);



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="공급업체정산-'.$company_name.'-'.date("ymd", time()).'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save('php://output');
?>
