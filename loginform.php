<?php

if(isset($_POST['username']) && isset($_POST['password']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$password_hash=md5($password);
	if(!empty($username) && !empty($password))
	{
		$query = "SELECT id FROM users WHERE username = '".mysqli_real_escape_string($connect,$username)."' AND password = '".mysqli_real_escape_string($connect,$password_hash)."'";
		if($query_run = mysqli_query($connect,$query))
		{
			$query_num_rows=mysqli_num_rows($query_run);
			if($query_num_rows!=1)
			{
				$contact=($username);
				$query = "SELECT id FROM users WHERE contact = '".mysqli_real_escape_string($connect,$contact)."' AND password = '".mysqli_real_escape_string($connect,$password_hash)."'";
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
							$_SESSION['user_id']=$user_id['id'];
							header('Location: login.php');
						}
					}
				}
			}
			else if($query_num_rows==1)
			{
				while($user_id=mysqli_fetch_assoc($query_run))
				{
					$_SESSION['user_id']=$user_id['id'];
					header('Location: login.php');
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

if(isset($_SESSION['flag']) && $_SESSION['flag']=='1')
{
	echo "<b>Your request could not be completed at the moment. Try again later</b>";
	$_SESSION['flag']='0';
}
else if(isset($_SESSION['flag']) && $_SESSION['flag']=='9')
{
	$_SESSION['flag']='0';
	session_destroy();
	?>
	<script type="text/javascript">alert("Your account has been deleted!\nWe are sad to see you go :(");</script>
	<?php
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Login page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="description" content="Official website of IEEE student chapter of SIES GST, Navi Mumbai.">
    <meta name="keywords" content="IEEE, ieee, sies, gst, siesgst, official, student, website, home">
    <meta name="author" content="IEEE SIES GST Student Chapter">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#000">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#000">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">

    <!-- //Meta tag Keywords -->
    
    <!-- Bootstrap -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Google Fonts -->

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="icon" href="images/favicon.png">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
</head>
<body class="loginbody">

<?php if(isset($incorrect) && $incorrect){ ?>

	<script type="text/javascript">
		alert('Incorrect Username or Password');
	</script>

<?php } ?>

	<div class="loginbg">
		<div class="container-fluid h-100">
			<div class="row align-items-center h-100">
				<div class="col-12">
					<div class="card mx-auto logincard">
						<div class="card-title text-center logincardtitle">
							<h2>Login</h2>
							<br/>
						</div>
						<div class="card-text text-center">
							<form action="<?php echo $current_file; ?>" method="POST">
								<p class="redpara"><label for="username"><b><i class="fa fa-user" aria-hidden="true"></i> Username / Mobile Number:</b></label></p>
								<input type="text" id="username" name="username" class="form-control logininput mx-auto" placeholder="Username/Mobile Number" autocomplete="off" required>
								<br/>
								<p class="redpara"><label for="password"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i>
								Password:</b></label></p>
								<input type="password" id="password" name="password" class="form-control logininput mx-auto" placeholder="Password" required>
								<br/>
								<input type="submit" class="btn btn-warning loginbutton" value="Login">
								<br/>
								<a href="change_info.php?change=1" class="loginlinkstyle">Forgot Password?</a><br/><br/>
								<h5 class="my-0 py-0"><a href="register.php" class="loginlinkstyle">New here? Register now.</a></h5>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>