<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$target_dir = "excels/";
//$target_file = $target_dir . basename($_FILES["excel"]["name"]);
$target_file = $target_dir . "po.po";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["excel"]["tmp_name"], $target_file)){
        echo "The file ". htmlspecialchars( basename( $_FILES["excel"]["name"])). " has been uploaded.";
        //chmod($_SERVER["DOCUMENT_ROOT"]."/excels/po.po", 777);
    } 
    // $file = $_FILES["fileToUpload"]["tmp_name"];
    // if($check !== false) {
    //     echo "File is an image - " . $check["mime"] . ".";
    //     $uploadOk = 1;
    // } else {
    //     echo "File is not an image.";
    //     $uploadOk = 0;
    // }
}
// die();
$helper = new Sample();
if ($helper->isCli()) {
    $helper->log('This example should only be run from a Web Browser' . PHP_EOL);

    return;
}
// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
    ->setLastModifiedBy('Maarten Balliauw')
    ->setTitle('Office 2007 XLSX Test Document')
    ->setSubject('Office 2007 XLSX Test Document')
    ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Test result file');

// Add some data
$ln = 1;
$datos = $_FILES["excel"];
print_r($datos);
die();
$output  = preg_match_all("/(((#)(.*?)(\n))+(msgid )(.*?)+(\n)(msgstr )(.*?)+(\n))|(msgid )(.*?)+(\n)(msgstr )(.*?)+(\n)/", $datos, $matches, PREG_OFFSET_CAPTURE);
foreach($matches[0] AS $item){
    $output2  = preg_match_all("/(#)(.*?)(\n)/", $item[0], $matches2, PREG_OFFSET_CAPTURE);
    $word = $matches2[0][0][0];
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('A'.$ln, $word);
    //echo $word."<br>";

    $output2  = preg_match_all("/(msgid )(.*?)+(\n)/", $item[0], $matches2, PREG_OFFSET_CAPTURE);
    $word = preg_replace(
        "/(msgid \")|(\")/",
        "",
        $matches2[0][0][0]
    );
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('B'.$ln, $word);
    //echo $word."<br>";

    $output2  = preg_match_all("/(msgstr )(.*?)+(\n)/", $item[0], $matches2, PREG_OFFSET_CAPTURE);
    $word = preg_replace(
        "/(msgstr \")|(\")/",
        "",
        $matches2[0][0][0]
    );
    $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue('C'.$ln, $word);
    //echo $word."<br>";

    
    //echo $matches2[0][0][0]."<br>";
    //print_r($matches2[0][0][0]);
    $ln++;
}

// Miscellaneous glyphs, UTF-8
// $spreadsheet->setActiveSheetIndex(0)
//     ->setCellValue('A4', 'Miscellaneous glyphs')
//     ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Simple');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="excels/excel.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
