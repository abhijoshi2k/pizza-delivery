<?php

require 'core_login.php';
require 'database_connect.php';


if(loggedin())
{
	header('Location: profile.php');
}
else
{
	include 'loginform.php';
	echo 'New here? <a href="register.php">Register now!</a>';
}

?>