<?php
$ninzu = 30;

//�����_���ɔԍ�����
	$numbers = range(1, $ninzu);
	shuffle($numbers);
	for ($i = 0; $i < $ninzu; $i++)
	{
		$ban[$i] = $numbers[$i];
	}

//$sheetnames = 'Sheet2';


//���C�u�����̃C���N���[�h
set_include_path(get_include_path() . PATH_SEPARATOR . 'Excel/PHPExcel-1.7.7/Classes/');
include 'PHPExcel.php';
include 'PHPExcel/IOFactory.php';

//�e���v���[�g��ǂݍ���ŃC���X�^���X��
$objReader = PHPExcel_IOFactory::createReader("Excel5");
$objPHPExcel = $objReader->load("zasekihyo.xls");

//�f�[�^�̃Z�b�g

$row = 4;
for ($i = 0; $i < $ninzu; $i++)
		{
        $objPHPExcel->getSheetByName('list')->setCellValueExplicitByColumnAndRow(4, $row, $ban[$i], PHPExcel_Cell_DataType::TYPE_STRING);
				$row++;
    }


//Excel2003�ȑO�̌`���Ńt�@�C���o��
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
$objWriter->save('zasekihyo.htm');
?>

