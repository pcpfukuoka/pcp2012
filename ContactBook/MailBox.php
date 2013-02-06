<?php
	session_start();
	$user_seq = $_SESSION['login_info[user]'];

	//データベースの呼出
	require_once("../lib/dbconect.php");
	$dbcon = DbConnect();

	//連絡帳のテータベースからデータの取り出し
	$sql = "SELECT contact_book_seq, send_date, m_user.user_name AS send_user_name, title, new_flg, link_contact_book_seq
			FROM contact_book
			Left JOIN m_user ON contact_book.send_user_seq = m_user.user_seq
			WHERE contact_book.reception_user_seq = $user_seq
			AND contact_book.send_flg = 0
			ORDER BY send_date DESC;";

	$result = mysql_query($sql);
	$count = mysql_num_rows($result);

	//データベースを閉じる
	Dbdissconnect($dbcon);
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta http-equiv="Content-Style-Type" content="text/css">
		<link rel="stylesheet" type="text/css" href="../css/back_ground.css" />
		<link rel="stylesheet" type="text/css" href="../css/text_display.css" />
		<link rel="stylesheet" type="text/css" href="../css/table.css" />
		<link rel="stylesheet" type="text/css" href="../css/table_search.css" />
		<title>受信箱</title>
	</head>

	<body>
		<img class="bg" src="../images/blue-big.jpg" alt="" />
		<div id="container">
		<div align="center">
			<font class="Cubicfont">受信箱</font><br><br>
		</div>

		<hr color="blue">
		<div class="holder"></div>

		<!-- 連絡帳の受信一覧テーブル作成 -->
		<br>
		<p align="left">
			<font size="5">連絡帳</font>
		</p>

		<div align="left">
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
				<th align="center" width="30"></th>
				<th align="center" width="200"><font size="5">日付</font></th>
				<th align="center" width="150"><font size="5">FROM</font></th>
				<th align="center" width="230"><font size="5">件名</font></th>
			</tr>
			<tbody id="list">
				<?php
				for ($i = 0; $i < $count; $i++){
					$row = mysql_fetch_array($result);
				?>
					<tr>

						<?php
							if($row['new_flg'] == 1)
							{
						?>
								<td align="center"><img src="../images/mail_icon.jpg"></td>
						<?php
							}
							else
							{
								echo "<td></td>";
							}
						?>
							<td align="center"><?= $row['send_date'] ?></td>
							<td align="center"><?= $row['send_user_name'] ?></td>
							<td align="center">
								<!-- GETでcontact_book_seqを送る -->
								<a href="view.php?id=<?= $row['contact_book_seq'] ?>&link_contact_book_seq=<?= $row['link_contact_book_seq'] ?>"><?= $row['title'] ?></a>
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
			<br>
			<hr>
		</div>

		<?php

			//データベースの呼出
			require_once("../lib/dbconect.php");
			$dbcon = DbConnect();

			//プリント配信用のデータベースからデータの取り出し
			$sql = "SELECT print_delivery_seq, target_group_seq, delivery_user_seq, delivery_date, printurl, title, m_user.user_name AS send_user_name
					FROM print_delivery
					LEFT JOIN m_user ON print_delivery.delivery_user_seq = m_user.user_seq
					LEFT JOIN group_details ON print_delivery.target_group_seq = group_details.group_seq
					WHERE group_details.user_seq = $user_seq
					ORDER BY delivery_date DESC;";
			$result = mysql_query($sql);
			$cnt = mysql_num_rows($result);

		?>

		<!-- プリントの受信一覧テーブル作成 -->
		<p align="left">
			<font size="5">配信</font>
		</p>
		<div class="holder"></div>

		<div align="left">
		<div id="tablewrapper">
			<div id="tableheader">
	        	<div class="search">
	                <select id="columns" onchange="sorter2.search('query')"></select>
	                <input type="text" id="query" onkeyup="sorter2.search('query')" />
	            </div>
	            <span class="details">
					<div>Records <span id="startrecord"></span>-<span id="endrecord"></span> of <span id="totalrecords"></span></div>
	        		<div><a href="javascript:sorter2.reset()">reset</a></div>
	        	</span>
        </div>
		<table cellpadding="0" cellspacing="0" border="0" id="table_2" class="table_01">
			<thead>
						<tr bgcolor="yellow">
					<th align="center" width="30"></th>
					<th align="center" width="200"><font size="5">日付</font></th>
					<th align="center" width="150"><font size="5">FROM</font></th>
					<th align="center" width="230"><font size="5">件名</font></th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i = 0; $i < $cnt; $i++){
					$row = mysql_fetch_array($result);

					$delivery = $row['print_delivery_seq'];

					$sql = "SELECT print_check_flg
							FROM print_check
							WHERE print_delivery_seq = $delivery
							AND user_seq = $user_seq;";

					$result_chk = mysql_query($sql);
					$chk = mysql_fetch_array($result_chk);
				?>
					<tr>

					<?php

						if ($chk['print_check_flg'] == 1)
						{
					?>
							<td align="center"><img src="../images/mail_icon.jpg"></td>
					<?php
						}
						else
						{
							echo "<td></td>";
						}
					?>

						<td align="center"><?= $row['delivery_date'] ?></td>
						<td align="center"><?= $row['send_user_name'] ?></td>
						<td align="center">
							<!-- GETでprint_delivery_seqを送る -->
							<!-- <a href="<?= printurl ?>"><?= $row['title'] ?></a> -->
							<a href="../Print_delivery/pdf_view.php?id=<?= $row['print_delivery_seq'] ?>&printurl=<?= $row['printurl'] ?>"><?= $row['title'] ?></a>
						</td>
					</tr>
				<?php
				}

				//データベースを閉じる
				Dbdissconnect($dbcon);
				?>
				</tbody>
			</table>
											</div>
		<div id="tablefooter">
          <div id="tablenav">
            	<div>
                    <img src="../images/first.gif" width="16" height="16" alt="First Page" onclick="sorter2.move(-1,true)" />
                    <img src="../images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter2.move(-1)" />
                    <img src="../images/next.gif" width="16" height="16" alt="First Page" onclick="sorter2.move(1)" />
                    <img src="../images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter2.move(1,true)" />
                </div>
                <div>
                	<select id="pagedropdown"></select>
				</div>
            </div>
			<div id="tablelocation">
            	<div>
                    <select onchange="sorter2.size(this.value)">
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
	var sorter2 = new TINY.table.sorter('sorter','table_2',{
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
