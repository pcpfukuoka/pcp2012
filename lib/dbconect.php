<?php
    function DbConnect()
    {
    	
    	$dbconfig = parse_ini_file("config.ini");    	
		$link = mysql_connect($dbconfig['address'],$dbconfig['user'],$dbconfig['pass']);

		mysql_select_db("pcp2012");

        return $link;
    }

    function Dbdissconnect($link)
    {
        mysql_close($link);
    }
?>
