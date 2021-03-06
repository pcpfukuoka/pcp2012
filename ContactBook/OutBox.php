<?php
	//SESSIONでユーザーIDを取得
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//連絡帳のデータベースからデータの取り出し
	$sql = "SELECT contact_book.group_seq AS group_seq, contact_book_seq, send_date,  m_user.user_name AS reception_user_name,
				   title, m_group.group_name AS group_name
			FROM contact_book
			LEFT JOIN m_user ON contact_book.reception_user_seq = m_user.user_seq
			LEFT JOIN m_group ON contact_book.group_seq = m_group.group_seq
			WHERE contact_book.send_user_seq = $user_seq
			AND send_flg = 0
			GROUP BY group_seq, title, DATE_FORMAT(send_date,'%Y/%m/%d %k:%i')
      		ORDER BY send_date DESC;";

	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" href="../css/animate.css">
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<title>送信箱</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
			<div align="center">
				<font class="Cubicfont">送信箱</font><br><br>
			</div>

			<hr color="blue">
			<br><br>

			<!-- 連絡帳の受信一覧テーブル作成 -->

			<div align="left">
			<br>
		<div id="tablewrapper">
			<div id="tableheader">
	        	<div class="search">
	                <select id="columns" onchange="sorter.search('query')"></select>
	                <input type="text" id="query" onkeyup="sorter.search('query')" />
	            </div>
	            <span class="details">
					<div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
	        		<div><a href="javascript:sorter.reset()">reset</a></div>
	        	</span>
        	</div>
			<table cellpadding="0" cellspacing="0" border="0" id="table" class="table_01">
				<thead>
						<tr>
							<th align="center"width="200"><font size="5">日付</font></th>
							<th align="center"width="150"><font size="5">TO</font></th>
							<th align="center"width="230"><font size="5">件名</font></th>
						</tr>
					</thead>
					<tbody id="list">
						<?php
							for ($i = 0; $i < $count; $i++)
							{
								$row = mysql_fetch_array($result);
						?>
								<tr>
									<td align="center"><?= $row['send_date'] ?></td>
									<?php
										//グループだったら
										if($row['group_seq'] >= 0)
										{
									?>
											<td align="center"><?= $row['group_name'] ?></td>
									<?php
										}
										//個人だったら
										else
										{
									?>
											<td align="center"><?= $row['reception_user_name'] ?></td>
									<?php
										}
									?>

									<td align="center">
										<!-- GETでシークを渡す -->
										<a href="sendview.php?id=<?= $row['contact_book_seq'] ?>"><?= $row['title'] ?></a>
									</td>
								</tr>
						<?php
							}
						?>
					</tbody>
			</table>
		</div>
		<div id="tablefooter">
          <div id="tablenav">
            	<div>
                    <img src="../images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
                    <img src="../images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
                    <img src="../images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
                    <img src="../images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
                </div>
                <div>
                	<select id="pagedropdown"></select>
				</div>
            </div>
			<div id="tablelocation">
            	<div>
                    <select onchange="sorter.size(this.value)">
                    <option value="5">5</option>
                        <option value="10" selected="selected">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>Entries Per Page</span>
                </div>
                <div class="page">Page <span id="currentpage"></span> of <span id="totalpages"></span></div>
            </div>
        </div>

			</div>
		</div>
	<script type="text/javascript" src="../javascript/script.js"></script>
	<script type="text/javascript">
	var sorter = new TINY.table.sorter('sorter','table',{
		headclass:'head',
		ascclass:'asc',
		descclass:'desc',
		evenclass:'evenrow',
		oddclass:'oddrow',
		evenselclass:'evenselected',
		oddselclass:'oddselected',
		paginate:true,
		size:5,
		colddid:'columns',
		currentid:'currentpage',
		totalid:'totalpages',
		startingrecid:'startrecord',
		endingrecid:'endrecord',
		totalrecid:'totalrecords',
		hoverid:'selectedrow',
		pageddid:'pagedropdown',
		navid:'tablenav',
		sortcolumn:1,
		sortdir:-1,
		init:true
	});
  </script>

	</body>
</html>