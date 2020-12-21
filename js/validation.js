goods="0123456789."; // onKeypress="goods='abcd'; return limitchar(event)"
function limitchar(e)
{
	var key, keychar;
	if (window.event)
		key=window.event.keyCode;
	else if (e)
		key=e.which;
	else
		return true;
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	goods = goods.toLowerCase();
	if (goods.indexOf(keychar) != -1)
	{
		goods="0123456789.";
		return true;
	}
	if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	{
		goods="0123456789.";
		return true;
	}
	return false;
}
/////Function for passengar_valid//////
function passengar_valid(frm_obj)
{
	if(frm_obj.pass_name.value=="")
	{
		alert("Please enter the name.");
		return false;
	}
	if(frm_obj.pass_add1.value=="")
	{
		alert("Please enter the address.");
		return false;
	}
	if(frm_obj.pass_city.value==0)
	{
		alert("Please select the city.");
		return false;
	}
	if(frm_obj.pass_state.value==0)
	{
		alert("Please select the state.");
		return false;
	}
	if(frm_obj.pass_country.value==0)
	{
		alert("Please select the country.");
		return false;
	}
	if(frm_obj.pass_gender[0].checked==false && frm_obj.pass_gender[1].checked==false)
	{
		alert("Please select the gender.");
		return false;
	}
	if(frm_obj.pass_dob.value=="")
	{
		alert("Please enter the DOB.");
		return false;
	}
	return true;
}
function delete_passengar(pass_id)
{
		if(confirm("Do you want to delete the passengar?"))
		{
			this.document.frm_pass.pass_id.value=pass_id;
			this.document.frm_pass.act.value="delete_passengar";
			this.document.frm_pass.submit();
		}
}