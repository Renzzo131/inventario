<?php

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$spreadsheet ->getProperties()->setCreator("yo")->setLastModifiedBy("yo")->setTitle("yo")->setDescription("yo");
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setTitle("hoja 1");




/*$a = 2 ;
while ($a <= 100) {
    $activeWorksheet->setCellValue('A'.$a, $a);
    $a++; 
}

$fila = 1;
$col = 1;
while ($col <= 100) {
    $celda = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $fila;
    $activeWorksheet->setCellValue($celda, $col);
    $col++;
}*/


$a = 1;
$b = 1;
while ($b <= 12) {
        $activeWorksheet->setCellValue('A'.$b, $a);
        $activeWorksheet->setCellValue('B'.$b, 'x');
        $activeWorksheet->setCellValue('C'.$b, $b);
        $activeWorksheet->setCellValue('D'.$b, '=');
        $activeWorksheet->setCellValue('E'.$b, $a * $b);
    $b++; 

}


//$activeWorksheet->setCellValue('A1', 'Hola Mundo !');
//$activeWorksheet->setCellValue('A2', 'DNI');
//$activeWorksheet->setCellValue('B2', '73004125');

//$activeWorksheet->setCellValueByColumnAndRow();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="hello_world.xlsx"');
header('Cache-Control: max-age=0');


$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
