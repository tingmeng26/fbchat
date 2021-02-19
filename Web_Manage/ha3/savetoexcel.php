<?php
include_once("_config.php");
include_once('filterconfig.php');
include('getservicedata.php');
$errorhandle=new coderErrorHandle();
try{
    //coderAdmin::vaild($auth,'export');
    $cd_kn = range('A','Z');
    
    //使用phpexcel匯出excel檔
    ob_end_clean();
    require_once CONFIG_DIR.'PHPExcel/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);//指定目前要編輯的工作表 0表示第一個

    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->setTitle('測字資料');

    //寬度設定
    $cd_ki = 0;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(40);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;

    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;

    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;

    //第二行
    $cd_ki = 0;
    $index = 1;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,"ID");;$cd_ki++;
    //$sheet->getStyle($cd_kn[$cd_ki].$index)->getAlignment()->setWrapText(true);$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,"PSID");$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'姓名');$cd_ki++;
    

    $sheet->setCellValue($cd_kn[$cd_ki].$index,'Q1');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'Q2');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'Q3');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'Q4');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'測字結果');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'分享');$cd_ki++;
    
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'建立時間');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'最後更新時間');$cd_ki++;
    //$sheet->getStyle($cd_kn[$cd_ki].$index)->getAlignment()->setWrapText(true);$cd_ki++;

    //下方內容
    if($rows){
        $index = 2;
        foreach ($rows as $key => $row) {
            $cd_ki = 0;

            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['id'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            //$sheet->getStyle($cd_kn[$cd_ki].$index)->getAlignment()->setWrapText(true);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['psid'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['name'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['q1'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['q2'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['q3'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['q4'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['result'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['is_share'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['createtime'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['updatetime'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $index++;
        }
    }
}catch(Exception $e){
    $db->close();
    $errorhandle->setException($e);
}
if ($errorhandle->isException()) {
    $errorhandle->showError();exit;
}


$objPHPExcel->setActiveSheetIndex(0);
//while (@ob_end_clean());
//下載
$_file = "ha3_event_".date('Y-m-d').'.xlsx';
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type:application/force-download');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.$_file);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("php://output");exit;
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
?>