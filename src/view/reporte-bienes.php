<?php

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$spreadsheet ->getProperties()->setCreator("yp")->setLastModifiedBy("yo")->setTitle("yo")->setDescription("yo");
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle("hoja 1");
$activeWorksheet->setCellValue('A1', 'Hola Mundo !');
$activeWorksheet->setCellValue('A2', 'DNI');
$activeWorksheet->setCellValue('B2', '73004125');

//$activeWorksheet->setCellValueByColumnAndRow();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="hello_world.xlsx"');
header('Cache-Control: max-age=0');


$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
