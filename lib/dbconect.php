<?php
    function DbConnect()
    {
		//$link = mysql_connect("10.50.202.105","root","");
    	$link = mysql_connect("49.212.201.99","pcp","pcp2012");

		mysql_select_db("pcp2012");

        return $link;
    }

    function Dbdissconnect($link)
    {
        mysql_close($link);
    }
?>
