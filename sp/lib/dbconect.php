<?php
    function DbConnect()
    {
    	
    	$dbconfig = parse_ini_file("config.ini");    	
		$link = mysql_connect($dbconfig['address'],$dbconfig['user'],$dbconfig['pass']);

		mysql_select_db($dbconfig['dbname']);

        return $link;
    }

    function Dbdissconnect($link)
    {
        mysql_close($link);
    }
?>
