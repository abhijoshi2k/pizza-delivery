<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$password_hash=md5($password);
	if(!empty($username) && !empty($password))
	{
		$query = "SELECT id FROM employees WHERE username = '".mysqli_real_escape_string($connect,$username)."' AND password = '".mysqli_real_escape_string($connect,$password_hash)."'";
		if($query_run = mysqli_query($connect,$query))
		{
			$query_num_rows=mysqli_num_rows($query_run);
			if($query_num_rows!=1)
			{
				$contact=($username);
				$query = "SELECT id FROM employees WHERE contact = '".mysqli_real_escape_string($connect,$contact)."' AND password = '".mysqli_real_escape_string($connect,$password_hash)."'";
				if($query_run = mysqli_query($connect,$query))
				{
					$query_num_rows=mysqli_num_rows($query_run);
					if($query_num_rows!=1)
					{
						$incorrect = true;
					}
					else if($query_num_rows==1)
					{
						while($user_id=mysqli_fetch_assoc($query_run))
						{
							$_SESSION['employee_id']=$user_id['id'];
							header('Location: employee_login.php');
						}
					}
				}
			}
			else if($query_num_rows==1)
			{
				while($user_id=mysqli_fetch_assoc($query_run))
				{
					$_SESSION['employee_id']=$user_id['id'];
					header('Location: employee_login.php');
				}
			}
		}
		else
		{
			echo "We are experiencing connectivity issues. Try again later.";
		}
	}
	else
	{
		echo 'You must supply a username and password';
	}
}

?>
<h1>LOGIN</h1>
<p><?php if(isset($incorrect) && $incorrect){echo 'Invalid Username or Password!';} ?></p>
<form action="<?php echo $current_file; ?>" method="POST">
<label for="username">Username or mobile number: </label><input type="text" id="username" name="username" autocomplete="off" required><br><br>
<label for="password">Password: </label><input type="password" id="password" name="password" autocomplete="off" required><br><br>
<input type="submit" value="Login"><br><br>
</form>