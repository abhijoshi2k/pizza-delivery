<!DOCTYPE html>
<html>
<head>
	<title></title>


</head>
<body>

<?php

require 'core_login.php';
require 'database_connect.php';

if(!loggedin())
{
	echo 'Already have an account? <a href="login.php">Login here</a>.<br><br>';
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_again']) && isset($_POST['firstname']) && isset($_POST['surname']) && $_POST['password']==$_POST['password_again'] && isset($_POST['sec_qt']) && isset($_POST['sec_ans']) && isset($_POST['contact']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];
		$firstname = $_POST['firstname'];
		$surname = $_POST['surname'];
		$sec_qt = $_POST['sec_qt'];
		$sec_ans = $_POST['sec_ans'];
		$contact = $_POST['contact'];
	
		if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_again']) && !empty($_POST['firstname']) && !empty($_POST['surname']) && !empty($_POST['sec_qt']) && !empty($_POST['sec_ans']) && !empty($_POST['contact']))
		{
			if(strlen($firstname)<=40 && strlen($surname)<=40)
			{
				$contact_validity=checkcontact(mysqli_real_escape_string($connect,$contact));
				if($contact_validity)
				{
					$contact_hash=($contact);
					$query = "SELECT username FROM users WHERE contact='".mysqli_real_escape_string($connect,$contact_hash)."'";
					$query_run = mysqli_query($connect,$query);
					$duplicate_contact = mysqli_num_rows($query_run);
					if($duplicate_contact==0)
					{
						$username_validity=checkusername(mysqli_real_escape_string($connect,$username));
						if($username_validity)
						{
							$password_validity=checkpassword(mysqli_real_escape_string($connect,$password));
							if($password_validity)
							{
								$query = "SELECT username FROM users WHERE username='".mysqli_real_escape_string($connect,$username)."'";
								$query_run = mysqli_query($connect,$query);
								$duplicate_username = mysqli_num_rows($query_run);

								if($duplicate_username==0)
								{
									//session_start();  //In this case, the session is already started in 'core_login.php'. So we are not starting again. Else, session start is necessary for captcha!
									if(isset($_POST['captcha']) && $_POST['captcha']==$_SESSION['captcha'])
									{

										$password_hash = md5($password);
										$sec_hash = md5(strtolower($sec_ans));
										$query = "INSERT INTO users VALUES ('"."','".mysqli_real_escape_string($connect,$username)."','".mysqli_real_escape_string($connect,$password_hash)."','".mysqli_real_escape_string($connect,$firstname)."','".mysqli_real_escape_string($connect,$surname)."','".mysqli_real_escape_string($connect,$contact_hash)."','".mysqli_real_escape_string($connect,$sec_qt)."','".mysqli_real_escape_string($connect,$sec_hash)."')";
										if($query_run = mysqli_query($connect,$query))
										{
											$insert_id = mysqli_insert_id($connect);
											$_SESSION['user_id'] = $insert_id;
											header('Location: register_success.php');
										}
										else
										{
											echo "<b>Sorry, we could not register you at this time. Try again later!</b>";
										}
									}
									else
									{
										$wrong=true;
									}
								}
							}
						}
					}
				}
			}
		}
		else
		{
			echo "<b>Please fill all details.</b><br><br>";
		}
	}

	?>

	

	



	<form action="register.php" method="POST">
		<label for="firstname">Firstname: </label><input type="text" name="firstname" autocomplete="off" maxlength="40" id="firstname" value="<?php if(isset($_POST['firstname'])){echo ($_POST['firstname']);} ?>" required>
		<label for="surname"> Surname: </label><input type="text" name="surname" id="surname" autocomplete="off" maxlength="40" value="<?php if(isset($_POST['surname'])){echo($_POST['surname']);} ?>" required><br><br>
		<label for="contact">Mobile number (without country code): </label><input type="text" name="contact" id="contact" autocomplete="off" maxlength="10" value="<?php if(isset($_POST['contact'])){echo($_POST['contact']);} ?>" required><?php if(isset($contact_validity) && $contact_validity!=true) {echo " <b>Enter valid <i>mobile</i> number</b>";} ?><?php if(isset($duplicate_contact)){if($duplicate_contact>0){ echo " The contact number is already registered!"; }} ?><br><br>
		<label for="username">Username: </label><input type="text" name="username" id="username" autocomplete="off" maxlength="30" value="<?php if(isset($_POST['username'])){echo($_POST['username']);} ?>" required><?php if(isset($duplicate_username)){if($duplicate_username>0){ echo " The username <i><b>".$username."</b></i> already exists!"; }} ?><br>

		<?php

		if(isset($username_validity) && $username_validity!=true)
		{
			?>

			<br><b>
				Criteria for username:<br>
				1. Only contains <i>alphanumeric</i> characters, <i>underscore</i> and <i>dot. (No CAPITAL characters)</i><br>
				2. The username should start with an alphabet.<br>
				3. <i>Underscore</i> and <i>dot.</i> cannot be next to each other or used consecutively.<br>
				4. At least 3 and at most 30 characters should be used.<br>
			</b>

			<?php

		}
		else
		{
			?>

			Criteria for username:<br>
			1. Only contains <i>alphanumeric</i> characters, <i>underscore</i> and <i>dot.</i><br>
			2. <i>Underscore</i> and <i>dot.</i> cannot be at start of username.<br>
			3. <i>Underscore</i> and <i>dot.</i> cannot be next to each other or used consecutively.<br>
			4. At least 3 and at most 30 characters should be used.

			<?php
		}

		?>

		<br><br>

		<?php 

		if (isset($_POST['password_again']) && isset($_POST['password']) && $_POST['password']!=$_POST['password_again'])
		{

		?>

		<br><b>The entered passwords did not match!</b><br><br>

		<?php

		}

		?>

		<label for="password">Password: </label><input type="password" name="password" id="password" autocomplete="off" value="<?php if(isset($_POST['password'])){echo($_POST['password']);} ?>" required><?php if(isset($password_validity) && $password_validity!=true){echo "<br><b>The password should be alphanumeric, should contain at least 6 and at most 40 characters.</b>";} else {echo "<br>The password should be alphanumeric, should contain at least 6 and at most 40 characters.";} ?><br><br>
		<label for="password_again">Confirm Password: </label><input type="password" autocomplete="off" id="password_again" name="password_again" value="<?php if(isset($_POST['password_again'])){echo($_POST['password_again']);} ?>" required><br><br>

		<label for="sec_qt">Enter security Question: </label><input type="text" autocomplete="off" id="sec_qt" name="sec_qt" maxlength="100" value="<?php if(isset($_POST['sec_qt'])){echo($_POST['sec_qt']);} ?>" required><br><br>
		<label for="sec_ans">Answer: </label><input type="text" autocomplete="off" id="sec_ans" name="sec_ans" maxlength="20" value="<?php if(isset($_POST['sec_ans'])){echo($_POST['sec_ans']);} ?>" required> The answer is <b>not</b> case sensitive.<br><br>
		
		<img src="captcha.php" id="generate"><br>
		<label for="captcha">Captcha: </label><input type="text" placeholder="Enter the 4-digit captcha" name="captcha" autocomplete="off" maxlength="4" id="captcha" value=""> <button type="button" onclick="document.getElementById('generate').src='captcha.php'">Change captcha!</button><br>

		<?php

		if(isset($wrong))
		{
			echo "<b>Please retry captcha</b><br>";
		}

		?>
		
		<br>
		<input type="submit" value="Register">
	</form>

	<?php

}
else
{
	echo 'You are already registered and logged in!<br><a href="login.php">Click to go back to profile page.</a>';
}

?>

</body>
</html>