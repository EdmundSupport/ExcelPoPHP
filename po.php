<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load("01simple.xlsx");

$worksheet = $spreadsheet->getActiveSheet();
$itera = 1;
$fichero = "messages.po";
file_put_contents($fichero, "");
foreach ($worksheet->getRowIterator() as $row) {
    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                                                       //    even if a cell value is not set.
                                                       // For 'TRUE', we loop through cells
                                                       //    only when their value is set.
                                                       // If this method is not called,
                                                       //    the default value is 'false'.
    
    foreach ($cellIterator as $cell) {
        
        //if($itera == 1) file_put_contents($fichero, $cell->getValue()."\n",FILE_APPEND);
        if($itera == 2) file_put_contents($fichero, "msgid \"".trim($cell->getValue())."\"\n",FILE_APPEND);
        if($itera == 3){
            file_put_contents($fichero, "msgstr \"".trim($cell->getValue())."\"\n",FILE_APPEND);
            $itera = 1;
        }else $itera++;

    }
    file_put_contents($fichero, "\n",FILE_APPEND);
    
}
