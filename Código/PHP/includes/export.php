<?php
$dir_raiz = "../";
require $dir_raiz.'vendor/autoload.php';
require_once($dir_raiz."includes/config.php");
require_once($dir_raiz."includes/funciones.php");

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
if(isset($_POST["table-content"])){
	$logo_stubia.'img/logo-stubia.png';
	$logoHeight = getimagesize($logo_stubia)[1];        
	
        $filename = isset($_POST["filename"]) ? $_POST["origen"]."_".$_POST["filename"]."_".date('Ymdhis') : "Export_".date('Ymdhis') ;
	$nrows = isset($_POST["nrows"]) ? $_POST["nrows"] : 1;
	$ncolums = isset($_POST["ncolums"]) ? $_POST["ncolums"] - 1 : 1;	
	
	$styleArray = [
		'font' => [
			'bold' => true,
		],
		'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
		],
		'borders' => [
			'top' => [
				'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			],
		],
		'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
			'rotation' => 90,
			'startColor' => [
				'argb' => 'FFA0A0A0',
			],
			'endColor' => [
				'argb' => 'FFFFFFFF',
			],
		],
	];

	$evenRow = [
		'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			'startColor' => [
				'rgb' => 'e2efda',
			],
		],
		'font' => [
			'color' => [
				'rgb' => '548235',
			],
		],
	];
	$oddRow = [
		'font' => [
			'color' => [
				'rgb' => '548235',
			],
		],
	];

	$reader = IOFactory::createReader('Html');
	$spreadsheet = $reader->loadFromString($_POST["table-content"]);
	
	$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
	$drawing->setName('Logo');
	$drawing->setDescription('Logo');
	$drawing->setPath($logo_stubia);
	$drawing->setCoordinates('A1');
	$drawing->setWorksheet($spreadsheet->getActiveSheet());
	
	$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight($logoHeight + 10);
	foreach(range('A',$columnas[$ncolums]) as $columnID) {
		if(($_POST["filename"] == "Indicadores" && $columnID == "C")){
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setWidth(60);
		}else{
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
	}
	
	$spreadsheet->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('2:2')->getFont()->setBold(true);

	for($i=1; $i<=$nrows; $i++){
		if($i%2 ==0 ){
			$spreadsheet->getActiveSheet()->getStyle($columnas[0].$i.":".$columnas[$ncolums].$i)->applyFromArray($evenRow);
		}else{
			$spreadsheet->getActiveSheet()->getStyle($columnas[0].$i.":".$columnas[$ncolums].$i)->applyFromArray($oddRow);
		}
	}

        
	//$spreadsheet->getActiveSheet()->removeRow(3,1);
        if($_POST["origen"] == "CMO" || $_POST["origen"] == "MITMA" ) $spreadsheet->getActiveSheet()->removeRow(3,1);
	$spreadsheet->getActiveSheet()->setAutoFilter("A2:".$columnas[$ncolums].$nrows);
        
	$spreadsheet->getActiveSheet()->getStyle('I3:J'.$nrows)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);	
	$spreadsheet->getActiveSheet()->getStyle('I3:J'.$nrows)->getAlignment()->setHorizontal('right');
        
        //$spreadsheet = new Spreadsheet();
	//$sheet = $spreadsheet->getActiveSheet();
	//$sheet->setCellValue('A1', 'Hello World !');

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	//$writer->save('hello world.xlsx');
	// We'll be outputting an excel file
	header('Content-type: application/vnd.ms-excel');

	// It will be called file.xls
	header("Content-Disposition: attachment; filename=".$filename.".xlsx");

	// Write file to the browser
	$writer->save('php://output');

	header("Location: ".php_actual());
}else{
	require_once($dir_raiz."includes/encabezado.php");
    lanzar_aviso("No se ha podido completar la exportaci�n.");
	require_once($dir_raiz."includes/cabecera.php");
}

