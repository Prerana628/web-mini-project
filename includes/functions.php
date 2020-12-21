<?php
$SERVER_PATH = "http://127.0.0.1:81/online_wedding_planner/";
session_start();
##Function for generating the dynamic options #######
function get_new_optionlist($table,$id_col,$value_col,$selected=0)
{
	$SQL="SELECT * FROM $table ORDER BY $value_col";
	$rs=mysql_query($SQL);
	$option_list="<option value=''>Please Select</option>";
	while($data=mysql_fetch_assoc($rs))
	{
		if($selected==$data[$id_col])
		{
			$option_list.="<option value='$data[$id_col]' selected>$data[$value_col]</option>";
		}
		else
		{
			$option_list.="<option value='$data[$id_col]'>$data[$value_col]</option>";
		}
	}
	return $option_list;
}
##Function for generating the dynamic options #######
function get_checkbox($name,$table,$id_col,$value_col,$selected=0)
{
	$selected_array=explode(",",$selected);
	$SQL="SELECT * FROM $table ORDER BY $value_col";
	$rs=mysql_query($SQL);
	$option_list="";
	while($data=mysql_fetch_assoc($rs))
	{
		if(in_array($data[$id_col],$selected_array))
		{
			$option_list.="<input type='checkbox' value='$data[$id_col]' name='".$name."[]' id='$name' checked>$data[$value_col]<br>";
		}
		else
		{
			$option_list.="<input type='checkbox' value='$data[$id_col]' name='".$name."[]' id='$name'>$data[$value_col]<br>";
		}
	}
	return $option_list;
}
?>