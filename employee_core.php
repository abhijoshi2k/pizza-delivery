<?php

ob_start();
session_start();
$current_file = $_SERVER['SCRIPT_NAME'];
if (isset($_SERVER['HTTP_REFERER']))
{
	$http_referer = $_SERVER['HTTP_REFERER'];
}

function loggedin()
{
	if(isset($_SESSION['employee_id']) && !empty($_SESSION['employee_id']))
		return true;
	else
		return false;
}

function getuserfield($field)
{
	global $connect;
	$query= "SELECT $field FROM employees WHERE id='".$_SESSION['employee_id']."'";
	if($query_run = mysqli_query($connect,$query))
	{
		while($query_result=mysqli_fetch_assoc($query_run))
		{
			return $query_result[$field];
		}
	}
}

function checkpassword($str)
{
	if(preg_match('/^(?=.*[A-Za-z])(?=.*\d).{6,40}$/', $str))
	{
		return true;
	}
	return false;
}

?>