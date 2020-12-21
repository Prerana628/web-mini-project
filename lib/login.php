<?php
	session_start();
	include_once("../includes/db_connect.php");
	if($_REQUEST[act]=="check_login")
	{
		check_login();
	}
	if($_REQUEST[act]=="logout")
	{
		logout();
	}
####Function check user#######
function check_login()
{
	$user_user=$_REQUEST[user_user];
	$user_password=$_REQUEST[user_password];
	$SQL="SELECT * FROM user WHERE user_username = '$user_user' AND user_password = '$user_password'";
	$rs = mysql_query($SQL) or die(mysql_error());
	if(mysql_num_rows($rs))
	{
		$_SESSION[login]=1;
		$_SESSION['user_details'] = mysql_fetch_assoc($rs);
		header("Location:../index.php");
	}
	else
	{
		header("Location:../login.php?msg=Invalid User and Password.");
	}
}
####Function logout####
function logout()
{
	$_SESSION[login]=0;
	$_SESSION['user_details'] = 0;
	header("Location:../login.php?msg=Logout Successfullly.");
}
?>