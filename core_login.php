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
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
		return true;
	else
		return false;
}

function getuserfield($field)
{
	global $connect;
	$query= "SELECT $field FROM users WHERE id='".$_SESSION['user_id']."'";
	if($query_run = mysqli_query($connect,$query))
	{
		while($query_result=mysqli_fetch_assoc($query_run))
		{
			return $query_result[$field];
		}
	}
}

function checkusername($str)
{
	if (preg_match('/^[a-z](_(?!(\.|_))|\.(?!(_|\.))|[a-z0-9]){1,29}$/', $str))
	{
		return 1;
	}
	return 0;
}

function checkpassword($str)
{
	if(preg_match('/^(?=.*[A-Za-z])(?=.*\d).{6,40}$/', $str))
	{
		return true;
	}
	return false;
}

function checkcontact($str)
{
	if(preg_match("/^[6789][0-9]{9}$/", $str))
	{
		return true;
	}
	return false;
}

?>