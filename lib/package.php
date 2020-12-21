<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_package")
	{
		save_package();
		exit;
	}
	if($_REQUEST[act]=="delete_package")
	{
		delete_package();
		exit;
	}
	if($_REQUEST[act]=="get_report")
	{
		get_report();
		exit;
	}
	###Code for save package#####
	function save_package()
	{
		$R=$_REQUEST;
		$image_name = $_FILES[package_image][name];
		$location = $_FILES[package_image][tmp_name];
		if($image_name!="")
		{
			move_uploaded_file($location,"../uploads/".$image_name);
		}
		else
		{
			$image_name = $R[avail_image];
		}
		$package_nl_id=implode(",",$R[package_nl_id]);
		if($R[package_id])
		{
			$statement = "UPDATE `package` SET";
			$cond = "WHERE `package_id` = '$R[package_id]'";
			$msg = "Data Updated Successfully.";
		}
		else
		{
			$statement = "INSERT INTO `package` SET";
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`package_title` = '$R[package_title]', 
				`package_pt_id` = '$R[package_pt_id]', 
				`package_start_price` = '$R[package_start_price]', 
				`package_image` = '$image_name', 
				`package_description` = '$R[package_description]'". 
				 $cond;
		$rs = mysql_query($SQL) or die(mysql_error());
		header("Location:../package-report.php?msg=$msg");
	}
#########Function for delete package##########3
function delete_package()
{
	$SQL="SELECT * FROM package WHERE package_id = $_REQUEST[package_id]";
	$rs=mysql_query($SQL);
	$data=mysql_fetch_assoc($rs);
	
	/////////Delete the record//////////
	$SQL="DELETE FROM package WHERE package_id = $_REQUEST[package_id]";
	mysql_query($SQL) or die(mysql_error());
	
	//////////Delete the image///////////
	if($data[package_image])
	{
		unlink("../uploads/".$data[package_image]);
	}
	header("Location:../package-report.php?msg=Deleted Successfully.");
}
##############Function for reporting ##################3
function get_report()
{
$fname = 'myCSV.csv';
$fp = fopen($fname,'w');
$column_name = '"ID","package_name","package_add1","package_add2","package_state","package_email","package_city","package_mobile","package_gender","package_dob","package_nl_id","package_image"'."\n\r";
fwrite($fp,$column_name);	
	
$SQL="SELECT * FROM package,city WHERE package_city = city_id";
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