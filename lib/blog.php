<?php
	include_once("../includes/db_connect.php");
	include_once("../includes/functions.php");
	if($_REQUEST[act]=="save_blog")
	{
		save_blog();
		exit;
	}
	if($_REQUEST[act]=="delete_blog")
	{
		delete_blog();
		exit;
	}
	if($_REQUEST[act]=="get_report")
	{
		get_report();
		exit;
	}
	###Code for save blog#####
	function save_blog()
	{
		$R=$_REQUEST;
		$image_name = $_FILES[blog_image][name];
		$location = $_FILES[blog_image][tmp_name];
		if($image_name!="")
		{
			move_uploaded_file($location,"../uploads/".$image_name);
		}
		else
		{
			$image_name = $R[avail_image];
		}
		$blog_nl_id=implode(",",$R[blog_nl_id]);
		if($R[blog_id])
		{
			$statement = "UPDATE `blog` SET";
			$cond = "WHERE `blog_id` = '$R[blog_id]'";
			$msg = "Data Updated Successfully.";
		}
		else
		{
			$statement = "INSERT INTO `blog` SET";
			$cond = "";
			$msg="Data saved successfully.";
		}
		$SQL=   $statement." 
				`blog_package_id` = '$R[blog_package_id]', 
				`blog_image` = '$image_name', 
				`blog_culture_id` = '$R[blog_culture_id]',
				`blog_religion_id` = '$R[blog_religion_id]',
				`blog_date` = '".time()."', 
				`blog_title` = '$R[blog_title]', 
				`blog_description` = '$R[blog_description]'". 
				 $cond;
		$rs = mysql_query($SQL) or die(mysql_error());
		header("Location:../blog-report.php?msg=$msg");
	}
#########Function for delete blog##########3
function delete_blog()
{
	$SQL="SELECT * FROM blog WHERE blog_id = $_REQUEST[blog_id]";
	$rs=mysql_query($SQL);
	$data=mysql_fetch_assoc($rs);
	
	/////////Delete the record//////////
	$SQL="DELETE FROM blog WHERE blog_id = $_REQUEST[blog_id]";
	mysql_query($SQL) or die(mysql_error());
	
	//////////Delete the image///////////
	if($data[blog_image])
	{
		unlink("../uploads/".$data[blog_image]);
	}
	header("Location:../blog-report.php?msg=Deleted Successfully.");
}
##############Function for reporting ##################3
function get_report()
{
$fname = 'myCSV.csv';
$fp = fopen($fname,'w');
$column_name = '"ID","blog_name","blog_add1","blog_add2","blog_state","blog_email","blog_city","blog_mobile","blog_gender","blog_dob","blog_nl_id","blog_image"'."\n\r";
fwrite($fp,$column_name);	
	
$SQL="SELECT * FROM blog,city WHERE blog_city = city_id";
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