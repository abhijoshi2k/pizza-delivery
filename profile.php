<?php

require 'core_login.php';
require 'database_connect.php';


if(loggedin())
{
	$username = getuserfield('username');
	$firstname = getuserfield('firstname');
	$surname = getuserfield('surname');
	if(isset($_SESSION['flag']))
	{
		if($_SESSION['flag']=='4')
		{
			$_SESSION['flag']='0';
			?>
			<script type="text/javascript">alert("Username changed successfully");</script>
			<?php
		}
		else if($_SESSION['flag']=='5')
		{
			$_SESSION['flag']='0';
			?>
			<script type="text/javascript">alert("Password changed successfully");</script>
			<?php
		}
		else if($_SESSION['flag']=='6')
		{
			$_SESSION['flag']='0';
			?>
			<script type="text/javascript">alert("Name changed successfully");</script>
			<?php
		}
		else if($_SESSION['flag']=='7')
		{
			$_SESSION['flag']='0';
			?>
			<script type="text/javascript">alert("Mobile number changed successfully");</script>
			<?php
		}
		else if($_SESSION['flag']=='8')
		{
			$_SESSION['flag']='0';
			?>
			<script type="text/javascript">alert("Security question changed successfully");</script>
			<?php
		}
	}
	echo '<b><i>'.$username.'</i></b><br>';
	echo 'You\'re logged in, '.$firstname.' '.$surname.'.<br><br>';
	?>

	<a href="change_info.php?change=2">Change username</a><br><br>
	<a href="change_info.php?change=3">Change password</a><br><br>
	<a href="change_info.php?change=4">Change name</a><br><br>
	<a href="change_info.php?change=5">Change mobile number</a><br><br>
	<a href="change_info.php?change=6">Change security question</a><br><br><br>
	<a href="order.php"><b>Order Now!</b></a><br><br><br>
	<a href="logout.php"><b>Logout</b></a><br><br><br>
	<a href="change_info.php?change=7">Delete Account</a>

	<?php
}
else
{
	header('Location: login.php');
}

?>