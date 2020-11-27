<?php

require 'employee_core.php';
require 'database_connect.php';


if(loggedin())
{
	header('Location: employee_orders.php');
}
else
{
	include 'employee_loginform.php';
}

?>