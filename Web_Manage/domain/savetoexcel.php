<?php
include_once("_config.php");
include_once('filterconfig.php');
$errorhandle=new coderErrorHandle();
try{
    //coderAdmin::vaild($auth,'export');
    $cd_kn = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');
    $page_size = -1;
    include('getservicedata.php');

    //使用phpexcel匯出excel檔
    ob_end_clean();
    require_once $inc_path.'excel/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);//指定目前要編輯的工作表 0表示第一個

    $sheet = $objPHPExcel->getActiveSheet();
    $sheet->setTitle('發票資料');

    //寬度設定
    $cd_ki = 0;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;

    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(40);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(30);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    //$sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;

    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;

    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(20);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;
    $sheet->getColumnDimension($cd_kn[$cd_ki])->setWidth(10);$cd_ki++;

    //第二行
    $cd_ki = 0;
    $index = 1;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,"ID");;$cd_ki++;
    //$sheet->getStyle($cd_kn[$cd_ki].$index)->getAlignment()->setWrapText(true);$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,"獎項");$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'發票號碼');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'姓名');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'Email');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'手機');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'性別');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'年齡');$cd_ki++;
    //$sheet->setCellValue($cd_kn[$cd_ki].$index,'通路');$cd_ki++;

    $sheet->setCellValue($cd_kn[$cd_ki].$index,'key');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'utm_source');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'utm_medium');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'utm_content');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'utm_campaign');$cd_ki++;

    $sheet->setCellValue($cd_kn[$cd_ki].$index,'來源');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'remktg_consent');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'optin_cmpgn');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'IP');$cd_ki++;
    $sheet->setCellValue($cd_kn[$cd_ki].$index,'建立時間');$cd_ki++;
    //$sheet->setCellValue($cd_kn[$cd_ki].$index,'填寫問卷');$cd_ki++;
    //$sheet->getStyle($cd_kn[$cd_ki].$index)->getAlignment()->setWrapText(true);$cd_ki++;

    //下方內容
    if($rows){
        $index = 2;
        foreach ($rows as $key => $row) {
            $cd_ki = 0;

            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['id'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            //$sheet->getStyle($cd_kn[$cd_ki].$index)->getAlignment()->setWrapText(true);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['ptype'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['receipt_no'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['name'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['email'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['phone'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['gender'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['age'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            //$sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['channel'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['key'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['utm_source'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['utm_medium'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['utm_content'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['utm_campaign'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['origin'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['remktg_consent'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['optin_cmpgn'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['ip'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            $sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['createtime'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
            //$sheet->setCellValueExplicit($cd_kn[$cd_ki].$index,$row['issurvey'],PHPExcel_Cell_DataType::TYPE_STRING);$cd_ki++;
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
$_file = "event_".date('Y-m-d').'.xlsx';
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