<?php

//�����̗j���擾
$weekday = date("w");
if($weekday == "0")
{
	$today = "��";
}
else if($weekday == "1")
{
	$today = "��";
}
else if($weekday == "2")
{
	$today = "��";
}
else if($weekday == "3")
{
	$today = "��";
}
else if($weekday == "4")
{
	$today = "��";
}
else if($weekday == "5")
{
	$today = "��";
}
else if($weekday == "6")
{
	$today = "�y";
}

//�X�[�p�[�O���[�o���ϐ��΍�
if(!isset($PHP_SELF)){ $PHP_SELF = $_SERVER["PHP_SELF"]; }
if(!isset($action)){
    if($_GET['action']){
        $action = $_GET['action'];
    }else{
        $action = $_POST['action'];
    }
}
?>

<?php
//�J�����_�[�̐���
function calendar($year = "", $month = "") {
	if(empty($year) && empty($month)) {
		$year = date("Y");
		$month = date("n");
	}
	//�����̎擾
	$l_day = date("j", mktime(0, 0, 0, $month + 1, 0, $year));
	//�����o��
	$tmp = <<<EOM
	<table cellspacing="0" cellpadding="0" border="0" class="calendar">
	<caption>{$year}�N{$month}��</caption>

	<tr>
		<th class="red">��</th>
		<th>��</th>
		<th>��</th>
		<th>��</th>
		<th>��</th>
		<th>��</th>
		<th class="blue">�y</th>
	</tr>\n
EOM;
	$lc = 0;
	//�������J��Ԃ�
	for ($i = 1; $i < $l_day + 1;$i++) {
		//�j���̎擾
		$week = date("w", mktime(0, 0, 0, $month, $i, $year));
		//�j�������j���̏ꍇ
		if ($week == 0) {
			$tmp .= "\t<tr>\n";
			$lc++;
		}
		//1���̏ꍇ
		if ($i == 1) {
			if($week != 0) {
				$tmp .= "\t<tr>\n";
				$lc++;
			}
			$tmp .= repeat($week);
		}
		if ($i == date("j") && $year == date("Y") && $month == date("n")) {
			//���݂̓��t�̏ꍇ
			$tmp .= "\t\t<td class=\"today\">{$i}</td>\n";
		} else {
			//���݂̓��t�ł͂Ȃ��ꍇ
			//�y�j���̏ꍇ
			if($week == 6)
			{
				$tmp .= "\t\t<td><font color = 'blue'>{$i}</font></td>\n";
			}
			//���j���̏ꍇ
			else if($week == 0)
			{
				$tmp .= "\t\t<td><font color = 'red'>{$i}</font></td>\n";
			}
			else
			{
				$tmp .= "\t\t<td>{$i}</td>\n";
			}
		}
		//�����̏ꍇ
		if ($i == $l_day) {
			$tmp .= repeat(6 - $week);
		}
		//�y�j���̏ꍇ
		if($week == 6) {
			 $tmp . "\t</tr>\n";
		}
	}
	if($lc < 6) {
		$tmp .= "\t<tr>\n";
		$tmp .= repeat(7);
		$tmp .= "\t</tr>\n";
	}
	if($lc == 4) {
		$tmp .= "\t<tr>\n";
		$tmp .= repeat(7);
		$tmp .= "\t</tr>\n";
	}
	$tmp .= "</table>\n";
	return $tmp;
}

function repeat($n) {
	return str_repeat("\t\t<td> </td>\n", $n);
}
?>

<?php
//�V�C�\��\�����̐ݒ�
$tnk = 40;
?>
<!--
���k�@1a
�����@1b
�����@1c
����@1d
�X�@2
���  3
�{��  4
�H�c  5
�R�`  6
����  7
���  8
�Ȗ�  9
�Q�n  10
���  11
��t  12
����  13
�_�ސ�  14
�V��  15
�x�R  16
�ΐ�  17
����  18
�R��  19
����  20
��  21
�É�  22
���m  23
�O�d  24
����  25
���s  26
���  27
����  28
�ޗ�  29
�a�̎R  30
����  31
����  32
���R  33
�L��  34
�R��  35
����  36
����  37
���Q  38
���m  39
����  40
����  41
����  42
�F�{  43
�啪  44
�{��  45
������  46
����  47
-->


<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="top.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/button.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
	</head>
	<body>
	<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">

		<br>
		<br>
		<br>
		<div align="center">
		<table width = "60%">
			<tr>
		<!-- �J�����_�[�̕\�� -->
				<td width = "40%">
					<?= calendar() ?>
				</td>


				<!-- �V�C�\��̕\�� -->
				<td width = "40%">
				<script language="javascript" charset="euc-jp" type="text/javascript" src="http://weather.livedoor.com/plugin/common/forecast/<?= $tnk ?>.js"></script>
				</td>

			</tr>
		</table>
		</div>

		<br><br>

		</div>
	</body>
</html>
