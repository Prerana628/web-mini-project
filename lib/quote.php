<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_quote")
	{
		save_quote();
		exit;
	}
	if($_REQUEST[act]=="delete_quote")
	{
		delete_quote();
		exit;
	}
	if($_REQUEST[act]=="get_report")
	{
		get_report();
		exit;
	}
	###Code for save quote#####
	function save_quote()
	{
		$R=$_REQUEST;
		if($R[quote_id])
		{
			$statement = "UPDATE `quote` SET";
			$cond = "WHERE `quote_id` = '$R[quote_id]'";
			$msg = "Data Updated Successfully.";
		}
		else
		{
			$statement = "INSERT INTO `quote` SET";
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`quote_package_id` = '$R[quote_package_id]', 
				`quote_name` = '$R[quote_name]', 
				`quote_mobile` = '$R[quote_mobile]', 
				`quote_email` = '$R[quote_email]', 
				`quote_budget` = '$R[quote_budget]', 
				`quote_guests` = '$R[quote_guests]', 
				`quote_event_details` = '$R[quote_event_details]', 
				`quote_description` = '$R[quote_description]'". 
				 $cond;
		$rs = mysql_query($SQL) or die(mysql_error());
		if($_SESSION['user_details']['user_level_id'] == 1)
		{
			header("Location:../quote-report.php?msg=$msg");
			exit;
		}
		header("Location:../quote-confirmation.php?msg=$msg");
		exit;
	}
#########Function for delete quote##########3
function delete_quote()
{
	$SQL="SELECT * FROM quote WHERE quote_id = $_REQUEST[quote_id]";
	$rs=mysql_query($SQL);
	$data=mysql_fetch_assoc($rs);
	
	/////////Delete the record//////////
	$SQL="DELETE FROM quote WHERE quote_id = $_REQUEST[quote_id]";
	mysql_query($SQL) or die(mysql_error());
	
	//////////Delete the image///////////
	if($data[quote_image])
	{
		unlink("../uploads/".$data[quote_image]);
	}
	header("Location:../quote-report.php?msg=Deleted Successfully.");
}
##############Function for reporting ##################3
function get_report()
{
$fname = 'myCSV.csv';
$fp = fopen($fname,'w');
$column_name = '"ID","quote_name","quote_add1","quote_add2","quote_state","quote_email","quote_city","quote_mobile","quote_gender","quote_dob","quote_nl_id","quote_image"'."\n\r";
fwrite($fp,$column_name);	
	
$SQL="SELECT * FROM quote,city WHERE quote_city = city_id";
$rs=mysql_query($SQL);
while($data=mysql_fetch_assoc($rs))
{
	$csvdata=implode(",",$data)."\n\r";
	fwrite($fp,$csvdata);		
}
fclose($fp);
header('Content-type: application/csv');
header("Content-Disposition: inline; filename=".$fname);
readfile($fname);
}
?>