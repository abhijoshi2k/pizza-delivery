<?php

require 'database_connect.php';
require 'core_login.php';

if(isset($_GET['change']) || isset($_POST['new_username']) || isset($_POST['new_password']) || isset($_POST['firstname']) || isset($_POST['contact']) || isset($_POST['sec_qt']) || isset($_POST['del_pw']))
{
	if(!loggedin() && $_GET['change']=='1')
	{
		?>

		<h1>Forgot Password</h1>
		<a href="login.php">Click to go back to login page.</a><br><br>
		<?php if(isset($_SESSION['flag']) && $_SESSION['flag']=='2'){echo "<b>The username does not exist!</b><br><br>"; $_SESSION['flag']='0';} else if(isset($_SESSION['flag']) && $_SESSION['flag']=='3'){ ?><script type="text/javascript">alert("Please provide username");</script><?php $_SESSION['flag']='0';} ?>
		<form action="change_info.php" method="POST">
			<label for="username">Enter valid username or phone number: </label><input type="text" name="username" id="username" autocomplete="off" required><br>
			<input type="submit" value="Submit">
		</form>

		<?php
	}
	else if(loggedin() && (isset($_POST['new_username']) || (isset($_GET['change']) && $_GET['change']=='2')))
	{
		if(isset($_POST['new_username']) && !empty($_POST['new_username']))
		{
			$username=$_POST['new_username'];
			$username_validity=checkusername(mysqli_real_escape_string($connect,$username));
			if($username_validity)
			{
				$query = "SELECT username FROM users WHERE username='".mysqli_real_escape_string($connect,$username)."'";
				$query_run = mysqli_query($connect,$query);
				$duplicate_username = mysqli_num_rows($query_run);

				if($duplicate_username==0)
				{
					$id=$_SESSION['user_id'];
					$query="UPDATE users SET username = '".mysqli_real_escape_string($connect,$username)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
					$query_run = mysqli_query($connect,$query);
					$_SESSION['flag']='4';
					header('Location: login.php');
				}
			}
		}

		?>
		<h1>Change username</h1>
		<a href="login.php">Go back to profile</a><br><br>
		<form action="change_info.php" method="POST">
			<label for="new_username">New Username: </label><input type="text" name="new_username" id="new_username" autocomplete="off" maxlength="30" value="<?php if(isset($_POST['new_username'])){echo($_POST['new_username']);} ?>" required><?php if(isset($duplicate_username)){if($duplicate_username>0){ echo " The username <i><b>".$username."</b></i> already exists!"; }} ?><br>

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
			<input type="submit" value="Submit">
			
		</form>

		<?php
	}
	else if(loggedin() && (isset($_POST['new_password']) || (isset($_GET['change']) && $_GET['change']=='3')))
	{
		if(isset($_POST['new_password']) && !empty($_POST['new_password']) && isset($_POST['password_again']) && !empty($_POST['password_again']))
		{
			$password=$_POST['new_password'];
			$password_again=$_POST['password_again'];
			$password_validity=checkpassword(mysqli_real_escape_string($connect,$password));
			if($password_validity)
			{
				if($password==$password_again)
				{
					$id=$_SESSION['user_id'];
					$password_hash=md5($password);
					$query="UPDATE users SET password = '".mysqli_real_escape_string($connect,$password_hash)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
					$query_run = mysqli_query($connect,$query);
					$_SESSION['flag']='5';
					header('Location: login.php');
				}
			}
		}

		?>

		<h1>Change password</h1>
		<a href="login.php">Go back to profile</a><br><br>
		<form action="change_info.php" method="POST">

			<?php 

			if (isset($_POST['password_again']) && isset($_POST['new_password']) && $_POST['new_password']!=$_POST['password_again'])
			{

			?>

			<br><b>The entered passwords did not match!</b><br><br>

			<?php

			}

			?>

			<label for="password">Password: </label><input type="password" name="new_password" id="new_password" autocomplete="off" required><?php if(isset($password_validity) && $password_validity!=true){echo "<br><b>The password should be alphanumeric, should contain at least 6 and at most 40 characters.</b>";} else {echo "<br>The password should be alphanumeric, should contain at least 6 and at most 40 characters.";} ?><br><br>
			<label for="password_again">Confirm Password: </label><input type="password" autocomplete="off" id="password_again" name="password_again" required><br><br>
			<input type="submit" value="Submit">

		</form>


		<?php
	}
	else if(loggedin() && (isset($_POST['firstname']) || (isset($_GET['change']) && $_GET['change']=='4')))
	{
		if(isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['surname']) && !empty($_POST['surname']))
		{
			$firstname=$_POST['firstname'];
			$surname=$_POST['surname'];
			$id=$_SESSION['user_id'];
			$query="UPDATE users SET firstname = '".mysqli_real_escape_string($connect,$firstname)."', surname = '".mysqli_real_escape_string($connect,$surname)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
			$query_run = mysqli_query($connect,$query);
			$_SESSION['flag']='6';
			header('Location: login.php');
		}

		?>

		<h1>Change name</h1>
		<a href="login.php">Go back to profile</a><br><br>
		<form action="change_info.php" method="POST">
			<label for="firstname">Firstname: </label><input type="text" name="firstname" autocomplete="off" maxlength="40" id="firstname" required>
			<label for="surname"> Surname: </label><input type="text" name="surname" id="surname" autocomplete="off" maxlength="40" required><br><br>
			<input type="submit" value="Submit">
		</form>

		<?php
	}
	else if(loggedin() && (isset($_POST['contact']) || (isset($_GET['change']) && $_GET['change']=='5')))
	{
		if(isset($_POST['contact']) && !empty($_POST['contact']))
		{
			$contact=$_POST['contact'];
			$contact_validity=checkcontact(mysqli_real_escape_string($connect,$contact));
			if($contact_validity)
			{
				$contact_hash=($contact);
				$query = "SELECT username FROM users WHERE contact='".mysqli_real_escape_string($connect,$contact_hash)."'";
				$query_run = mysqli_query($connect,$query);
				$duplicate_contact = mysqli_num_rows($query_run);

				if($duplicate_contact==0)
				{
					$id=$_SESSION['user_id'];
					$query="UPDATE users SET contact = '".mysqli_real_escape_string($connect,$contact_hash)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
					$query_run = mysqli_query($connect,$query);
					$_SESSION['flag']='7';
					header('Location: login.php');
				}
			}
		}

		?>

		<h1>Change Mobile number</h1>
		<a href="login.php">Go back to profile</a><br><br>
		<form action="change_info.php" method="POST">
			<label for="contact">Mobile number (without country code): </label><input type="text" name="contact" id="contact" autocomplete="off" maxlength="10" required><?php if(isset($contact_validity) && $contact_validity!=true) {echo " <b>Enter valid <i>mobile</i> number</b>";} ?><?php if(isset($duplicate_contact)){if($duplicate_contact>0){ echo " The contact number is already registered!"; }} ?><br><br>
			<input type="submit" value="Submit">
		</form>

		<?php
	}
	else if(loggedin() && (isset($_POST['sec_qt']) || (isset($_GET['change']) && $_GET['change']=='6')))
	{
		if(isset($_POST['sec_qt']) && !empty($_POST['sec_qt']) && isset($_POST['sec_ans']) && !empty($_POST['sec_ans']))
		{
			$sec_qt=$_POST['sec_qt'];
			$sec_ans=$_POST['sec_ans'];
			$id=$_SESSION['user_id'];
			$sec_hash=md5(strtolower($sec_ans));
			$query="UPDATE users SET security_question = '".mysqli_real_escape_string($connect,$sec_qt)."', answer = '".mysqli_real_escape_string($connect,$sec_hash)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
			$query_run = mysqli_query($connect,$query);
			$_SESSION['flag']='8';
			header('Location: login.php');
		}

		?>

		<h1>Change Security question</h1>
		<a href="login.php">Go back to profile</a><br><br>
		<form action="change_info.php" method="POST">
			<label for="sec_qt">Enter security Question: </label><input type="text" autocomplete="off" id="sec_qt" name="sec_qt" maxlength="100" required><br><br>
			<label for="sec_ans">Answer: </label><input type="text" autocomplete="off" id="sec_ans" name="sec_ans" maxlength="20" required> The answer is <b>not</b> case sensitive.<br><br>
			<input type="submit" value="Submit">
		</form>

		<?php
	}
	else if(loggedin() && (isset($_POST['del_pw']) || (isset($_GET['change']) && $_GET['change']=='7')))
	{
		if(isset($_POST['del_pw']) && !empty($_POST['del_pw']))
		{
			$password=$_POST['del_pw'];
			$password_hash=md5($password);
			$id=$_SESSION['user_id'];
			$query="SELECT id FROM users WHERE id='".mysqli_real_escape_string($connect,$id)."' AND password='".mysqli_real_escape_string($connect,$password_hash)."'";
			$query_run = mysqli_query($connect,$query);
			$match_pw = mysqli_num_rows($query_run);
			if($match_pw==1)
			{
				$query = "DELETE FROM users WHERE id='".mysqli_real_escape_string($connect,$id)."'";
				$query_run = mysqli_query($connect,$query);
				unset($_SESSION['user_id']);
				$_SESSION['flag']='9';
				header('Location: login.php');
			}
		}

		?>

		<h1>Delete Account</h1>
		<a href="login.php">Go back to profile</a><br><br>
		<form action="change_info.php" method="POST">
			<?php if(isset($match_pw) && $match_pw!=1) {echo "<b>Wrong password!</b><br><br>";} ?>
			<label for="del_pw">Enter your password to proceed: </label><input type="password" name="del_pw" id="del_pw" autocomplete="off" required><br><br>
			Are you sure you want to <b>DELETE</b> your account? This <b>cannot</b> be undone!<br><br>
			<input type="submit" value="YES">    
			<a href="login.php"><button type="button">NO</button></a>
		</form>

		<?php
	}
	else if(loggedin())
	{
		echo '<b>Error 404:</b> Page not found.<br><a href="login.php">Click to go back to profile page.</a>';
	}
	else
	{
		echo '<b>Error 404:</b> Page not found.<br><a href="login.php">Click to go back to login page.</a>';
	}
}

if(!loggedin() && ((isset($_POST['username']) && !empty($_POST['username'])) || (isset($_POST['password']) && isset($_POST['password_again']) && isset($_POST['answer']))))
{
	if(isset($_POST['username']) && !empty($_POST['username']))
	{
		$username = $_POST['username'];
		$query = "SELECT id, security_question, answer FROM users WHERE username='".mysqli_real_escape_string($connect,$username)."'";
		if($query_run = mysqli_query($connect,$query))
		{
			$query_num_rows=mysqli_num_rows($query_run);
			if($query_num_rows!=1)
			{
				$contact=md5($username);
				$query = "SELECT id, security_question, answer FROM users WHERE contact='".mysqli_real_escape_string($connect,$contact)."'";
				if($query_run = mysqli_query($connect,$query))
				{
					$query_num_rows=mysqli_num_rows($query_run);
					if($query_num_rows!=1)
					{
						$_SESSION['flag']='2';
						header('Location: change_info.php?change=1');
					}
					else if($query_num_rows==1)
					{
						while($user_detail=mysqli_fetch_assoc($query_run))
						{
							$security_question = $user_detail['security_question'];
							$answer = $user_detail['answer'];
							$id = $user_detail['id'];
						}
						$_SESSION['username']=$id;
						echo "<b>Answer the following security question and then enter new password</b><br><br>";
						echo '<a href="login.php">Click to go back to login page</a><br><br>';
						?>

						<form action="change_info.php" method="POST">
							<label for="answer"><?php echo $security_question; ?>: </label><input type="text" name="answer" id="answer" autocomplete="off" required><br>
							<br><label for="password">Password: </label><input type="password" name="password" id="password" autocomplete="off" required> The password should be alphanumeric, should contain at least 6 and at most 40 characters.<br><br>
							<label for="password_again">Confirm Password: </label><input type="password" autocomplete="off" id="password_again" name="password_again" required><br><br>
							<input type="submit" value="Submit">
						</form>

						<?php
					}
				}
				else
				{
					$_SESSION['flag']='1';
					header('Location: login.php');
				}
			}
			else if($query_num_rows==1)
			{
				while($user_detail=mysqli_fetch_assoc($query_run))
				{
					$security_question = $user_detail['security_question'];
					$answer = $user_detail['answer'];
					$id = $user_detail['id'];
				}
				$_SESSION['username']=$id;
				echo "<b>Answer the following security question and then enter new password</b><br><br>";
				echo '<a href="login.php">Click to go back to login page</a><br><br>';
				?>

				<form action="change_info.php" method="POST">
					<label for="answer"><?php echo $security_question; ?>: </label><input type="text" name="answer" id="answer" autocomplete="off" required><br>
					<br><label for="password">Password: </label><input type="password" name="password" id="password" autocomplete="off" required> The password should be alphanumeric, should contain at least 6 and at most 40 characters.<br><br>
					<label for="password_again">Confirm Password: </label><input type="password" autocomplete="off" id="password_again" name="password_again" required><br><br>
					<input type="submit" value="Submit">
				</form>

				<?php
			}
		}
		else
		{
			$_SESSION['flag']='1';
			header('Location: login.php');
		}
	}
	else
	{
		$answer=$_POST['answer'];
		$password=$_POST['password'];
		$password_again=$_POST['password_again'];
		$id=$_SESSION['username'];
		if(!empty($answer) && !empty($password) && !empty($password_again))
		{
			$query = "SELECT answer FROM users WHERE id='".mysqli_real_escape_string($connect,$id)."'";
			if($query_run = mysqli_query($connect,$query))
			{
				$query_num_rows=mysqli_num_rows($query_run);
				if($query_num_rows!=1)
				{
					$_SESSION['flag']='1';
					header('Location: login.php');
				}
				else if($query_num_rows==1)
				{
					$answer_hash=md5(strtolower($answer));
					while($row=mysqli_fetch_assoc($query_run))
					{
						$answer_og=$row['answer'];
					}
					if($answer_og==$answer_hash)
					{
						if(checkpassword($password))
						{
							if($password==$password_again)
							{
								$password_hash = md5($password);
								$query="UPDATE users SET password = '".mysqli_real_escape_string($connect,$password_hash)."' WHERE id = '".mysqli_real_escape_string($connect,$id)."'";
								if($query_run = mysqli_query($connect,$query))
								{
									session_destroy();
									echo 'Password has been reset.<br><a href="login.php">Login here</a>';
								}
								else
								{
									$_SESSION['flag']='1';
									header('Location: login.php');
								}
							}
							else
							{
								$flag=4;
							}
						}
						else
						{
							$flag=3;
						}
					}
					else
					{
						$flag=2;
					}
				}
			}
			else
			{
				$_SESSION['flag']='1';
				header('Location: login.php');
			}
		}
		else
		{
			$flag = 1;
		}
		if(isset($flag))
		{
			$query = "SELECT security_question FROM users WHERE id='".mysqli_real_escape_string($connect,$id)."'";
			if($query_run = mysqli_query($connect,$query))
			{
				$query_num_rows=mysqli_num_rows($query_run);
				if($query_num_rows!=1)
				{
					echo "Server is down. Try again later";
				}
				else if($query_num_rows==1)
				{
					while($row=mysqli_fetch_assoc($query_run))
					{
						$security_question=$row['security_question'];
					}
					echo "<b>Answer the following security question and then enter new password</b><br><br>";
					echo '<a href="login.php">Click to go back to login page</a><br><br>';
					if($flag==1)
					{
						echo "<b>Please enter all fields</b><br><br>";
					}

					?>

					<form action="change_info.php" method="POST">
						<label for="answer"><?php echo $security_question; ?>: </label><input type="text" name="answer" id="answer" autocomplete="off" value="<?php if($flag!=2){echo ($answer);} ?>" required><br>
						<?php

						if($flag==2)
						{
							echo "<b>Wrong answer to security question</b><br>";
						}

						?>
						<br><label for="password">Password: </label><input type="password" name="password" id="password" autocomplete="off" required> The password should be alphanumeric, should contain at least 6 and at most 40 characters.<br>
						<?php

						if($flag==3)
						{
							echo "<b>Password did not match the criteria</b>";
						}
						else if($flag==4)
						{
							echo "<b>The two passwords do not match</b>";
						}

						?>
						<br><br>
						<label for="password_again">Confirm Password: </label><input type="password" autocomplete="off" id="password_again" name="password_again" required><br><br>
						<input type="submit" value="Submit">
					</form>

					<?php
				}
			}
			else
			{
				$_SESSION['flag']='1';
				header('Location: login.php');
			}
		}
	}
}
else if(isset($_POST['username']) && empty($_POST['username']))
{
	$_SESSION['flag']='3';
	header('Location: change_info.php?change=1');
}

if((!isset($_POST['username']) && !isset($_GET['change']) && !isset($_POST['password']) && !isset($_POST['password_again']) && !isset($_POST['answer'])) && !isset($_POST['new_username']) && !isset($_GET['change']) && !isset($_POST['name']) && !isset($_POST['contact']) && !isset($_POST['sec_qt']) &&!isset($_POST['del_pw']))
{
	if(!loggedin())
	{
		echo '<b>Error 404:</b> Page not found.<br><a href="login.php">Click to go back to login page.</a>';
	}
	else
	{
		echo '<b>Error 404:</b> Page not found.<br><a href="login.php">Click to go back to profile page.</a>';
	}
}

?>