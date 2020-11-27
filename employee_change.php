<?php

require 'database_connect.php';
require 'employee_core.php';

if(loggedin() && isset($_POST['password']) && isset($_POST['password_again']) && !empty($_POST['password']) && !empty($_POST['password_again']))
{
	$pw = $_POST['password'];
	$pwa = $_POST['password_again'];
	if($pw != $pwa)
	{
		$_SESSION['employee_flag'] = '1';
		header('Location: employee_change.php');
	}
	else if(checkpassword($pw))
	{
		$id=$_SESSION['employee_id'];
		$password_hash=md5($pw);
		$query="UPDATE employees SET password = '".mysqli_real_escape_string($connect,$password_hash)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
		$query_run = mysqli_query($connect,$query);
		$_SESSION['employee_flag'] = '3';
		header('Location: employee_change.php');
	}
	else
	{
		$_SESSION['employee_flag'] = '2';
		header('Location: employee_change.php');
	}

}

else if(loggedin() && isset($_SESSION['employee_flag']) && $_SESSION['employee_flag'] == '3')
{
	$_SESSION['employee_flag'] = '0';
	?>
	<script type="text/javascript">
		alert('Password Changed Successfully!');
		location.replace(location.href.replace('employee_change.php', 'employee_orders.php'));
	</script>
	<?php
}

else if(loggedin())
{
	if(isset($_SESSION['employee_flag']) && $_SESSION['employee_flag'] == '1')
	{
		$_SESSION['employee_flag'] = '0';
		?>
		<script type="text/javascript">
			alert('Passwords Do Not Match!');
		</script>
		<?php
	}
	else if(isset($_SESSION['employee_flag']) && $_SESSION['employee_flag'] == '2')
	{
		$_SESSION['employee_flag'] = '0';
		?>
		<script type="text/javascript">
			alert('Password must be alphanumeric and at least 6 and at most 40 characters long!');
		</script>
		<?php
	}
	?>

	<form action="employee_change.php" method="POST">
		<a href="employee_login.php">Click to go back to employee login page!</a>
		<h1>Change Password</h1>
		<label for="password">Enter password</label>
		<input type="password" name="password" required>
		<br><br>
		<label for="password_again">Enter password again</label>
		<input type="password" name="password_again" required>
		<br><br>
		<input type="submit" value="Submit">
	</form>

	<?php
}

else
{
	header('Location: login.php');
}

?>