<?php
include_once("./_common.php");

check_demo();

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

if( empty($fr_date) ){
    $fr_date = date("Y-m-d", strtotime("-7 day"));
}
if( empty($to_date) ){
    $to_date = TB_TIME_YMD;
}
if( empty($sel_field) ){
    $sel_field = "od_time";
}

$sql_common = " from shop_order ";
//$sql_search = " where seller_id = '".$seller_code."' and sellerpay_yes = '0' ";
$sql_search = " where seller_id = '".$seller_code."' ";
$sql_search .= " and ( ( dan IN(4,5,10,11,12,13,8,7) and left($sel_field,10) between '$fr_date' and '$to_date'  )  ";
$sql_search .= " or ( dan IN(7) and left(return_date,10) between '$fr_date' and '$to_date' and (left($sel_field,10) < '$fr_date'  or left($sel_field,10) > '$to_date') ) ";
$sql_search .= " or ( dan IN(8) and left(change_date,10) between '$fr_date' and '$to_date' and (left($sel_field,10) < '$fr_date'  or left($sel_field,10) > '$to_date') ) ) ";
$sql_order = " order by index_no desc ";

$sql = " select * $sql_common $sql_search ";
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
      ->setCellValue($char++.'1', '쇼핑몰주문번호')
      ->setCellValue($char++.'1', '주문시간')
      ->setCellValue($char++.'1', '교환완료일')
      ->setCellValue($char++.'1', '반품완료일')
      ->setCellValue($char++.'1', '택배사')
      ->setCellValue($char++.'1', '송장번호')
      ->setCellValue($char++.'1', '수취인')
      ->setCellValue($char++.'1', '주문자 기본주소')
      ->setCellValue($char++.'1', '수집상품명')
      ->setCellValue($char++.'1', '수집옵션명')
      ->setCellValue($char++.'1', '상품공급가')
      ->setCellValue($char++.'1', '수량')
      ->setCellValue($char++.'1', '교환/반품배송비')
      ->setCellValue($char++.'1', '정산액')
      ->setCellValue($char++.'1', '세금구분')
      ->setCellValue($char++.'1', '주문상태')
      ->setCellValue($char++.'1', '교환/반품메모')
      ->setCellValue($char++.'1', '관리자메모');
$excel->getActiveSheet()->getStyle("A1:T1")->applyFromArray($TH_COLOR);

$re_list = array();
$ch_list = array();
$tot_supply = 0;
$tot_baesong = 0;

$sql = " select * $sql_common $sql_search ";
$result = sql_query($sql);
for($i=2; $row=sql_fetch_array($result); $i++)
{
    $supply_price = $row['supply_price'];

    //if( $row['od_time'] < $fr_date ){ // 지난달에 정산을 해준 경우
    if( $row[$sel_field] < $fr_date ){ // 지난달에 정산을 해준 경우
        if($row['dan']=='7'){ // 반품 완료 주문건
            $supply_price *= -1;
            array_push($re_list,$i);
        }else if($row['dan']=='8'){ // 교환 완료 주문건
            $supply_price = 0;
        }
    }else{
        if($row['dan']=='7'){ // 반품 완료 주문건
            $supply_price  = 0;
        }
    }

    if($row['dan']!='7' && $row['dan']!='8'){
        $supply_price -= $row['cancel_price'];
    }

    $gs = unserialize($row['od_goods']);
    $amount = get_order_spay($row['od_id']);
    $sodr = array();
    $sodr['it_options'] =  print_complete_options($row['gs_id'], $row['od_id'], 1);
    $sodr['od_delivery_company'] = explode("|",$row['delivery'])[0];
    $char = 'A';
    $excel->setActiveSheetIndex(0)
          ->setCellValueExplicit($char++.$i, $row['seller_id'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $company_name, PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['od_id'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['od_pwd'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['od_time'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['change_date'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['return_date'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $sodr['od_delivery_company'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['delivery_no'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['b_name'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['b_addr1'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $gs['gname'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $sodr['it_options'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['supply_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$i, $row['sum_qty'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['baesong_price2'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$i, $supply_price, PHPExcel_Cell_DataType::TYPE_NUMERIC)
          ->setCellValueExplicit($char++.$i, '과세', PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $gw_status[$row['dan']], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['change_memo'], PHPExcel_Cell_DataType::TYPE_STRING)
          ->setCellValueExplicit($char++.$i, $row['shop_memo'], PHPExcel_Cell_DataType::TYPE_STRING);
    $excel->getActiveSheet()->getStyle("M$i:P$i")->getNumberFormat()->setFormatCode('#,##0');
}

$TD_COLOR = array(
    //배경색 설정
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'fff2cc'),
    )
);
foreach($re_list as $idx){
    $excel->getActiveSheet()->getStyle("A$idx:T$idx")->applyFromArray($TD_COLOR);
}

$RES_COLOR = array(
    //배경색 설정
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'f4cccc'),
    ),
    //글자색 설정
    'font' => array(
        'bold' => 'true',
        'size' => '10'
    )
);

// Rename worksheet
$excel->getActiveSheet()->setTitle('공급업체주문내역');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel -> setActiveSheetIndex(0);
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(40);
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
$excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
$excel->getActiveSheet()->getColumnDimension('R')->setWidth(30);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="공급업체정산-'.$company_name.'-'.date("ymd", time()).'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save('php://output');
?>
