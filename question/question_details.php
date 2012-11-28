<?php
$question_seq = $_GET['id'];

require_once("../lib/dbconect.php");
$dbcon = DbConnect();

$sql = "SELECT question_title,question_description,quesion_details_description,COUNT(question_awnser_list.question_details_seq) AS awnser_list_cnt
		FROM question 
		LEFT JOIN question_details ON question.question_seq = question_details.question_seq
		LEFt JOIN question_awnser_list ON question_details.question_details_seq = question_awnser_list.question_details_seq
		WHERE question.question_seq = '$question_seq'
		GROUP BY question_awnser_list.question_details_seq";
$details_result = mysql_query($sql);
$details_cnt = mysql_num_rows($details_result);

$sql = "SELECT question_target_group_seq,question_details.question_details_seq,question_title,question_description,quesion_details_description,awnser_name, COUNT(question_awnser.awnser_user_seq) AS awnser_cnt
		FROM question
		INNER JOIN question_details ON question.question_seq = question_details.question_seq
		INNER JOIN question_awnser_list ON question_details.question_details_seq = question_awnser_list.question_details_seq
		LEFT JOIN question_awnser ON question_awnser_list.question_awnser_list_seq = question_awnser.question_awnser_list_seq
		WHERE question.question_seq = '$question_seq'
		GROUP BY question_awnser_list.question_awnser_list_seq";

$awnser_result = mysql_query($sql);
$awnser_cnt = mysql_num_rows($awnser_result);

?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script language="javascript" type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
		<script language="javascript" type="text/javascript" src="../js/jquery.jqplot.min.js"></script>
		<script language="javascript" type="text/javascript" src="../js/jqplot.pieRenderer.min.js"></script>
		<link rel="stylesheet" type="text/css" href="../js/jquery.jqplot.min.css" />
	</head>
	<script>
function test (id,label,data,description) {
	var label_list = label.split(",");
	var data_list = data.split(",");
	
	var show_data_list = [];

	for(var i = 0; i < label_list.length;i++)
	{
		var list = [label_list[i],Number(data_list[i])];
		show_data_list.push(list)
	}
	
	$.jqplot(id, [show_data_list], {
		// 使用する色を指定する
		// デフォルトの色じゃ嫌だという人は設定
		// タイトルを表示する場合は追加
		title: {
			// タイトル
			text: description,
			// よくわからない show
			show: false,
		},
		seriesDefaults: {
			// 円グラフでお願い！
			renderer: jQuery.jqplot.PieRenderer,
			// 描画オプション
			rendererOptions: {
				// ラベルの表示, true, false
				showDataLabels: true,
				// ラベルの表示内容, 'label', 'value', 'percent'
				dataLabels: 'percent',
				// 塗りつぶし, true, false
				fill: false,
				// マージン
				sliceMargin: 10,
				// 線の太さ
				lineWidth: 5,
				// 影, true, false
				shadow: true,
				// 円グラフの余白
				padding: 10,
				// 開始角度
				startAngle: 0,
			}
		},
		legend: {
			// ラベルリストの表示
			show: true,
			// 配置, nw, w, sw, ne, e, se, n, s から選択
			location: 'e'
		},
		// グラフ全体を囲むグリッドの設定
		grid: {
			// グラフを囲む枠線の太さ、0で消える
			borderWidth: 0,
			// 背景色を透明に
			background: 'transparent',
			// 影もいらない
			shadow: false,
		}
	});
};
</script>
	
	
	
	<body>
		<?php 
		
			$label = array();
			$data = array();
			$seq_array = array();
			$description = array();
			for($i; $i < $details_cnt; $i++)
			{	
				$details_row = mysql_fetch_array($details_result);
			?>
			<table>
				<tr>
					<td>
						<table border="1">
						<tr>
							<th>質問</th>
							<th>回答数</th>
						</tr>
						<?php 
						$label_list = "";
						$data_list = "";
						for($j=0; $j < $details_row['awnser_list_cnt']; $j++)
						{
							$awnser_row = mysql_fetch_array($awnser_result);
							?>
							<tr>
								<td><?= $awnser_row['awnser_name'] ?></td>
								<td><?= $awnser_row['awnser_cnt'] ?></td>
							</tr>
								
					<?php 
							//グラフようにデータを保持
							$flg = $details_row['awnser_list_cnt'] - 1;
							if($flg == $j)
							{
								$label_list = $label_list.$awnser_row['awnser_name'];
								$data_list = $data_list.$awnser_row['awnser_cnt'];
							}
							else 
							{
								$label_list = $label_list.$awnser_row['awnser_name'].',';
								$data_list = $data_list.$awnser_row['awnser_cnt'].',';
							}
						}
						array_push($data, $data_list);
						array_push($label, $label_list);
						array_push($seq_array,$awnser_row['question_details_seq']);
						array_push($description, $details_row['quesion_details_description']);
						
						?>
						</table>
					</td>
					<td>
					<div id="abc<?= $awnser_row['question_details_seq'] ?>" style="height: 300px; width: 300px;"></div>
					</td>
					<td>
						<a href="awnser_details.php?id=<?= $awnser_row['question_details_seq'] ?>">詳細</a>
					</td>
					
				</tr>
			</table>					
		<?php 
			}
		?>
	</body>
	<script>
	<?php 
	for($i = 0; $i < $details_cnt; $i++)
	{
		echo "test('abc$seq_array[$i]','$label[$i]','$data[$i]','$description[$i]');";
	}
	?>
	</script>
	
</html>