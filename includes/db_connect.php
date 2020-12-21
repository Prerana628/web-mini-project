<?php
	error_reporting(E_ERROR);
	$db=mysql_connect("localhost","root","root") or die(mysql_error());
	$db_sel=mysql_select_db("online_wedding_planner") or die(mysql_error());
?>