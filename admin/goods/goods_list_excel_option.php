<?php
include_once("./_common.php");


check_demo();

//<<<<<<<<<<<<<<<<<<< Check Parameters >>>>>>>>>>>>>>>>>>>>>//
if(!$io_id) alert("옵션번호가 넘어오지 않았습니다.");

$sql = " SELECT a.*, b.gcode, b.sbcode, b.goods_price, b.opt_subject FROM shop_goods_option AS a LEFT JOIN shop_goods AS b ON (a.gs_id = b.index_no) WHERE io_no IN ({$io_id}) ORDER BY io_no DESC ";
$result = sql_query($sql);
$cnt = @sql_num_rows($result);
if(!$cnt)
	alert("출력할 자료가 없습니다.");

//<<<<<<<<<<<<<<<<<<< Include PHPExcel >>>>>>>>>>>>>>>>>>>>>//
include_once(TB_LIB_PATH.'/PHPExcel.php');
include_once(TB_LIB_PATH.'/PHPExcel_Writer_Excel5.php');

$excel = new PHPExcel();

//<<<<<<<<<<<<<<<<<<< Add Excel Columns >>>>>>>>>>>>>>>>>>>>>//
$char = 'A';
$excel->setActiveSheetIndex(0)
	->setCellValue($char++.'2', '상품코드')
    ->setCellValue($char++.'2', '사방넷품번코드')
	->setCellValue($char++.'2', '옵션명')
	->setCellValue($char++.'2', '옵션항목')
	->setCellValue($char++.'2', '옵션공급가')
	->setCellValue($char++.'2', '옵션가격')
    ->setCellValue($char++.'2', '재고수량')
    ->setCellValue($char++.'2', '통보수량')
    ->setCellValue($char++.'2', '사용여부')
    ->setCellValue($char++.'2', '옵션형식');

//<<<<<<<<<<<<<<<<<<< Add Excel Datas >>>>>>>>>>>>>>>>>>>>>//    
for($i=3; $row=sql_fetch_array($result); $i++)
{
    //information processing 
    $io_id = str_replace(chr(30),',',$row['io_id']);

    //add data
	$char = 'A';
	$excel->setActiveSheetIndex(0)
	->setCellValueExplicit($char++.$i, $row['gcode'], PHPExcel_Cell_DataType::TYPE_STRING)
    ->setCellValueExplicit($char++.$i, $row['sbcode'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit($char++.$i, $row['opt_subject'], PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit($char++.$i, $io_id, PHPExcel_Cell_DataType::TYPE_STRING)
	->setCellValueExplicit($char++.$i, $row['goods_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
    ->setCellValueExplicit($char++.$i, $row['io_price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit($char++.$i, $row['io_stock_qty'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit($char++.$i, $row['io_noti_qty'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
    ->setCellValueExplicit($char++.$i, $row['io_use'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
	->setCellValueExplicit($char++.$i, $row['io_type'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
}

//<<<<<<<<<<<<<<<<<<< Excel Setting & Download >>>>>>>>>>>>>>>>>>>>>//    
// Rename worksheet
$excel->getActiveSheet()->setTitle('상품옵션');

// Auto width
$excel -> getActiveSheet() -> getColumnDimension('A') -> setWidth(20);
$excel -> getActiveSheet() -> getColumnDimension('B') -> setWidth(20);
$excel -> getActiveSheet() -> getColumnDimension('C') -> setWidth(20);
$excel -> getActiveSheet() -> getColumnDimension('D') -> setWidth(20);
$excel -> getActiveSheet() -> getColumnDimension('E') -> setWidth(10);
$excel -> getActiveSheet() -> getColumnDimension('F') -> setWidth(10);
$excel -> getActiveSheet() -> getColumnDimension('G') -> setWidth(10);
$excel -> getActiveSheet() -> getColumnDimension('H') -> setWidth(10);
$excel -> getActiveSheet() -> getColumnDimension('I') -> setWidth(10);
$excel -> getActiveSheet() -> getColumnDimension('J') -> setWidth(10);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="상품옵션-'.date("ymd", time()).'.xls"');
header('Cache-Control: max-age=0');

//$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007'); // 통합 엑셀 [header 확장명 xlsx 로 변경 후 사용]
$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); // 97-2003 [header 확장명 xls 로 변경 후 사용]
$writer->save('php://output');
?>
