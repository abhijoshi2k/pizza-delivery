<?php

require 'database_connect.php';
require 'core_login.php';

?>


<!DOCTYPE html>
<html>
<head>
	<title>Account Details Editing | Bomino's Pizza</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="description" content="Web Development Mini-Project.">
    <meta name="author" content="Abhishek Joshi, Vineet Iyer, Vishak Kodethur">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#OD2C54">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#OD2C54">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#OD2C54">

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
    
<!-- Functions -->
    <script type="text/javascript">
        
        function menu(){

            let x = document.getElementById("navbar");

            if(x.style.maxHeight == '60px' || x.style.maxHeight == '' || x.style.height == '60px'){
                x.style.maxHeight = " 1000px";
                document.getElementById('bar1').style.transform = 'rotate(-45deg) translate(-3px,7px)';
                document.getElementById('bar3').style.transform = 'rotate(45deg) translate(-3px,-7px)';
                document.getElementById('bar2').style.opacity = '0';
                document.getElementById('notnav').style.display = 'block';
                setTimeout(function() {
                    x.style.transition = '';
                    x.style.transition = '0.5s cubic-bezier(0, 1, 0, 1)';
                }, 500);
            }
            else
            {
                x.style.maxHeight = "60px";
                document.getElementById('bar1').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar3').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('notnav').style.display = 'none';
                setTimeout(function() {
                    x.style.transition = '';
                    x.style.transition = '1s ease-in;';
                }, 500);
            }
        }

        function navchange() {
            if(window.innerWidth > 850 && window.scrollY > 2)
            {
                document.getElementById('nav-logo-image').style.marginTop = '5px';
                document.getElementById('nav-logo-image').style.height = '60px';
                document.getElementById('navbar-ul').style.marginTop = '20px';
                document.getElementById('navbar').style.height = '70px';
            }

            else if(window.innerWidth > 850 && window.scrollY <= 2)
            {
                document.getElementById('nav-logo-image').style.marginTop = '7px';
                document.getElementById('nav-logo-image').style.height = '70px';
                document.getElementById('navbar-ul').style.marginTop = '29px';
                document.getElementById('navbar').style.height = '83px';
            }

            else
            {
                document.getElementById('nav-logo-image').style.marginTop = '6px';
                document.getElementById('nav-logo-image').style.height = '40px';
                document.getElementById('navbar-ul').style.marginTop = '60px';
                document.getElementById('navbar').style.height = 'auto';
            }
        }

    </script>
</head>
<body>


    <nav class="position-fixed topnav" id="navbar">

        <div class="nav-logo position-absolute">
            <a href="index.php"><img src="images/15b78dc9-cf77-49fe-97f4-fe2b4e5fb36b_200x200.png" class="nav-logo-img" id="nav-logo-image" alt=""></a>
        </div>

        <div class="toggle-bars position-absolute" onclick="menu();">
            <div class="bar-1 bar" id="bar1"></div>
            <div class="bar-2 bar" id="bar2"></div>
            <div class="bar-3 bar" id="bar3"></div>
        </div>

        <ul class="navbar-ul mb-0" id="navbar-ul">
            <a href="index.php" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Home</div></li>
            </a>
            <a href="menu.php" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Our Menu</div></li>
            </a>
            <a href="order.php" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Order Now</div></li>
            </a>
            <?php
            if(loggedin())
            {
                ?>
                <a href="view_orders.php" class="navbar-link">
                    <li class="navbar-list"><div class="navbar-link-text d-inline">View Orders</div></li>
                </a>
                <a href="profile.php" class="navbar-link">
                    <li class="navbar-list active"><div class="navbar-link-text d-inline">Profile</div></li>
                </a>
                <a href="logout.php" class="navbar-link" id="reg-link">
                    <li class="navbar-list" id="reg-list"><div class="navbar-link-text d-inline">Logout</div></li>
                </a>
                <?php
            }
            else
            {
                ?>
                <a href="login.php" class="navbar-link" id="reg-link">
                    <li class="navbar-list" id="reg-list"><div class="navbar-link-text d-inline">Login</div></li>
                </a>
                <?php
            }
            ?>
        </ul>

    </nav>


    <div id="notnav" class="position-fixed h-100 w-100" onclick="menu();"></div>


<?php

if(isset($_GET['change']) || isset($_POST['new_username']) || isset($_POST['new_password']) || isset($_POST['firstname']) || isset($_POST['contact']) || isset($_POST['sec_qt']) || isset($_POST['del_pw']))
{
	if(!loggedin() && $_GET['change']=='1')
	{
		?>

		<div class="forgotbg">
			<div class="container-fluid h-100">
				<div class="row align-items-center h-100">
					<div class="col-12">
						<div class="card mx-auto forgot1card">
							<div class="card-title text-center forgot1cardtitle">
								<h2 class="title">Forgot Password</h2>
							</div>
							<div class="card-text text-center">
	                            <form action="change_info.php" method="POST" autocomplete="off">
	    							<br/>
	                                <p class="redpara"><label for="username"><b><i class="fa fa-user" aria-hidden="true"></i>
	                                Enter valid Username/Mobile Number:</b></label></p>
	    							<input type="text" name="username" id="username" class="form-control forgotinput mx-auto" placeholder="Username/Mobile Number" required>
	    							<br/>
	    							<input type="submit" class="btn btn-warning forgotbutton" value="Submit">
	                            </form>
	                            <br/><br/><br/>
								<a href="login.php" class="forgotlinkstyle">Click here to go back to login page</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		if(isset($_SESSION['flag']) && $_SESSION['flag']=='2')
		{
			?>
			<script type="text/javascript">
				alert('The username does not exist!');
			</script>
			<?php
			$_SESSION['flag']='0';
		}
		else if(isset($_SESSION['flag']) && $_SESSION['flag']=='3')
		{
			?>
			<script type="text/javascript">
				alert("Please provide username");
			</script>
			<?php
			$_SESSION['flag']='0';
		}
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

		<div class="changebg">
			<div class="container ">
				<div class="row mx-auto align-items-center ">
					<div class="col-12">
						<div class="card mx-auto changecard">
							<div class="card-title text-center changecardtitle">
								<h2>Change Username</h2>
							</div>
							<div class="card-text ">
	                            <form action="change_info.php" method="POST" autocomplete="off">
	    							<p class="changered"><label for="new_username"><i class="fa fa-user" aria-hidden="true"></i> New Username:</label></p>
	    							<input type="text" name="new_username" id="new_username" class="form-control changeinput" placeholder="Username" maxlength="30" value="<?php if(isset($_POST['new_username'])){echo($_POST['new_username']);} ?>" required><br/>

	    							<?php
	    							if(isset($duplicate_username))
	    							{
	    								if($duplicate_username>0)
		    							{
		    								?>
		    								<script type="text/javascript">
		    									alert('Given Username already exists!');
		    								</script>
		    								<?php
		    							}
		    						}
		    						else if(isset($username_validity) && $username_validity!=true)
									{
										?>

										<script type="text/javascript">
	    									alert('Given Username does not satisfy the criteria!');
	    								</script>

										<?php

									}
		    						?>

	    							<p class="changecriteria">Criteria for Username:
	    								<ol class="changecriteria">
	    								<li>Only contains <i>alphanumeric characters, underscore </i>and <i>dot</i>.</li>
	    								<li><i>Underscore</i> and <i>dot</i> cannot be at start of username.</li>
	    								<li><i>Underscore</i> and <i>dot</i> cannot be next to each other or used consecutively.</li>
	    								<li>At least 3 and at most 30 characters should be used.</li>
	    								</ol>
	    							</p>
	                                
	    							<div class="text-center">
	    								<input type="submit" class="btn btn-warning changebutton " value="Submit"><br/><br/>
	    							</div>
	                            </form>
	                            <div class="text-center">
	                                <a href="login.php" class="changelinkstyle">Go back to profile</a>
	                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		

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

		<div class="changebg">
			<div class="container ">
				<div class="row mx-auto align-items-center ">
					<div class="col-12">
						<div class="card mx-auto changecard">
							<div class="card-title text-center changecardtitle">
								<h2>Change Password</h2>
							</div>
							<div class="card-text ">
	                            <form action="change_info.php" method="POST" autocomplete="off">

	                            	<?php 

									if (isset($_POST['password_again']) && isset($_POST['new_password']) && $_POST['new_password']!=$_POST['password_again'])
									{

										?>

										<script type="text/javascript">
											alert('Entered Passwords do not match!');
										</script>

										<?php

									}

									else if(isset($password_validity) && $password_validity!=true)
	    							{
	    								?>

										<script type="text/javascript">
											alert('Password does not match the criteria!');
										</script>

										<?php
	    							}

									?>

	    							<p class="changered"><label for="password"><i class="fa fa-unlock-alt" aria-hidden="true"></i> New Password:</label></p>
	    							<input type="password" name="new_password" id="new_password" class="form-control changeinput" placeholder="Password" required>

	    							<p class="changecriteria">(The password should be alphanumeric, should contain at least 6 and at most 40 characters)
	    							</p><br/>
	    							<p class="changered"><label for="password_again"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirm Password:</label></p>
	    							<input type="password" id="password_again" name="password_again" class="form-control changeinput" placeholder="Retype Password" required>
	    							<br/>
	                                
	    							<div class="text-center">
	                                    <input type="submit" class="btn btn-warning changebutton " value="Submit"><br/><br/>
	                                </div>
	                            </form>
	                            <div class="text-center">
	                                <a href="login.php" class="changelinkstyle">Go back to profile</a>
	                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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

		<div class="changebg">
			<div class="container ">
				<div class="row mx-auto align-items-center ">
					<div class="col-12">
						<div class="card mx-auto changecard">
							<div class="card-title text-center changecardtitle">
								<h2>Change Name</h2>
							</div>
							<div class="card-text ">
								<form action="change_info.php" method="POST" autocomplete="off">
									<p class="changered"><label for="firstname"><i class="fa fa-user" aria-hidden="true"></i> New Firstname:</label></p>
									<input type="text" name="firstname" id="firstname" class="form-control changeinput" placeholder="Firstname" maxlength="40" required>
									<br/>
									<p class="changered"><label for="surname"><i class="fa fa-user" aria-hidden="true"></i> New Surname:</label></p>
									<input type="text" name="surname" id="surname" class="form-control changeinput" placeholder="Lastname" maxlength="40" required><br/>

									<div class="text-center">
	                                    <input type="submit" class="btn btn-warning changebutton " value="Submit"><br/><br/>
	                                </div>
	                            </form>
	                            <div class="text-center">
	                                <a href="login.php" class="changelinkstyle">Go back to profile</a>
	                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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

		<div class="changebg">
			<div class="container ">
				<div class="row mx-auto align-items-center ">
					<div class="col-12">
						<div class="card mx-auto changecard">
							<div class="card-title text-center changecardtitle">
								<h2>Change Mobile Number</h2>
							</div>
							<div class="card-text ">
								<form action="change_info.php" method="POST" autocomplete="off">
									<p class="changered"><label for="contact"><i class="fa fa-mobile" aria-hidden="true"></i> Mobile Number (without country code):</label></p>
									<input type="text" name="contact" id="contact" class="form-control changeinput" placeholder="Mobile Number" maxlength="10" required>

									<?php
									if(isset($contact_validity) && $contact_validity!=true)
									{
										?>
										<script type="text/javascript">
											alert('Please Enter Valid Contact Number!');
										</script>
										<?php
									}
									else if(isset($duplicate_contact))
									{
										if($duplicate_contact>0)
										{
											?>
											<script type="text/javascript">
												alert('This contact number is already registered!');
											</script>
											<?php
										}
									}
									?>

									<br/>

									<div class="text-center">
	                                    <input type="submit" class="btn btn-warning changebutton " value="Submit"><br/><br/>
	                                </div>
	                            </form>
	                            <div class="text-center">
	                                <a href="login.php" class="changelinkstyle">Go back to profile</a>
	                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		

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

		<div class="changebg">
			<div class="container ">
				<div class="row mx-auto align-items-center ">
					<div class="col-12">
						<div class="card mx-auto changecard">
							<div class="card-title text-center changecardtitle">
								<h2>Change Security Question</h2>
							</div>
							<div class="card-text ">
								<form action="change_info.php" method="POST" autocomplete="off">
									<p class="changered"><label for="sec_qt"><i class="fa fa-question" aria-hidden="true"></i> Enter New Security Question:</label></p>
									<input type="text" id="sec_qt" name="sec_qt" class="form-control changeinput" placeholder="Enter Security Question" maxlength="100" required><br/>
									<p class="changered"><label for="sec_ans"><i class="fa fa-arrow-right" aria-hidden="true"></i> Enter Answer:</label></p>
									<input type="text" id="sec_ans" name="sec_ans" class="form-control changeinput" placeholder="Enter Security Answer" maxlength="20" required>
									<p class="changecriteria">(The answer is not case sensitive)</p><br/>

									<div class="text-center">
	                                    <input type="submit" class="btn btn-warning changebutton " value="Submit"><br/><br/>
	                                </div>
	                            </form>
	                            <div class="text-center">
	                                <a href="login.php" class="changelinkstyle">Go back to profile</a>
	                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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

		<div class="changebg">
			<div class="container ">
				<div class="row mx-auto align-items-center ">
					<div class="col-12">
						<div class="card mx-auto changecard">
							<div class="card-title text-center changecardtitle">
								<h2>Delete Account</h2>
							</div>
							<?php
							if(isset($match_pw) && $match_pw!=1)
							{
								?>
								<script type="text/javascript">
									alert('Wrong Password!');
								</script>
								<?php
							}
							?>
							<div class="card-text ">
								<form action="change_info.php" method="POST" autocomplete="off">
									<p class="deleteaccgreen"><label for="del_pw"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Enter your password to proceed:</label></p>
									<input type="password" name="del_pw" id="del_pw" class="form-control changeinput" placeholder="Enter Password" required>
									<br/>
									<p class="deleteacccriteria">Are you sure you want to <b>DELETE</b> your account? This <b>CANNOT</b> be undone!</p>

									<div class="text-center">
	                                    <input type="submit" class="btn btn-warning deleteaccbutton " value="YES">
	                                    <a href="login.php"><button type="button" type="button" class="btn btn-warning deleteaccbutton">NO
	                                    </button></a><br/><br/>
	                                </div>
	                            </form>
	                            <div class="text-center">
	                                <a href="login.php" class="changelinkstyle">Go back to profile</a>
	                            </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
	else
	{
		header('Location: login.php');
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
						?>

						<div class="forgot2bg pt-5 mt-5">
							<div class="container-fluid h-100">
								<div class="row align-items-center h-100">
									<div class="col-12">
										<div class="card mx-auto forgot2card">
											<div class="card-title text-center forgot2cardtitle">
												<h2 class="title">Forgot Password</h2>
												<hr class="mx-auto my-4 hrline"/>
											</div>
											<div class="card-text text-center">
												<p class="parainfo"><b>Answer the following security question to reset password</b></p><br/>
												<form action="change_info.php" method="POST" autocomplete="off">
													<p class="redpara"><label for="answer"><b><?php echo $security_question; ?></b></label></p>
													<input type="text" name="answer" id="answer" class="form-control mx-auto forgot2input" placeholder="Enter Answer" required>

													<hr class="mx-auto my-4 hrline"/>

													<p class="parainfo"><b>Reset Password</b></p><br/>
													<p class="redpara"><label for="password"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password:</b></label></p>
													<input type="password" name="password" id="password" class="form-control mx-auto forgot2input" placeholder="Enter New Password" required>
													<p class="parabracket mx-auto criteria">( The password should be alphanumeric, should contain at least 6 and at most 40 characters )</p><br/>
													<p class="redpara"><label for="password_again"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirm Password:</b></label></p>
													<input type="password" id="password_again" name="password_again" class="form-control mx-auto forgot2input" placeholder="Confirm Password" required>
													<br/>
													
													<input type="submit" class="btn btn-warning forgot2button" value="Submit"><br/><br/>
												</form>
												<a href="login.php" class="forgot2linkstyle">Click here to go back to login page</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

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
				?>

				<div class="forgot2bg pt-5 mt-5">
					<div class="container-fluid h-100">
						<div class="row align-items-center h-100">
							<div class="col-12">
								<div class="card mx-auto forgot2card">
									<div class="card-title text-center forgot2cardtitle">
										<h2 class="title">Forgot Password</h2>
										<hr class="mx-auto my-4 hrline"/>
									</div>
									<div class="card-text text-center">
										<p class="parainfo"><b>Answer the following security question to reset password</b></p><br/>
										<form action="change_info.php" method="POST" autocomplete="off">
											<p class="redpara"><label for="answer"><b><?php echo $security_question; ?></b></label></p>
											<input type="text" name="answer" id="answer" class="form-control mx-auto forgot2input" placeholder="Enter Answer" required>

											<hr class="mx-auto my-4 hrline"/>

											<p class="parainfo"><b>Reset Password</b></p><br/>
											<p class="redpara"><label for="password"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password:</b></label></p>
											<input type="password" name="password" id="password" class="form-control mx-auto forgot2input" placeholder="Enter New Password" required>
											<p class="parabracket mx-auto criteria">( The password should be alphanumeric, should contain at least 6 and at most 40 characters )</p><br/>
											<p class="redpara"><label for="password_again"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirm Password:</b></label></p>
											<input type="password" id="password_again" name="password_again" class="form-control mx-auto forgot2input" placeholder="Confirm Password" required>
											<br/>
											
											<input type="submit" class="btn btn-warning forgot2button" value="Submit"><br/><br/>
										</form>
										<a href="login.php" class="forgot2linkstyle">Click here to go back to login page</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


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
									echo '<p class="pt-5 mt-5 container">Password has been reset.<br><a href="login.php">Login here</a></p>';
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
					if($flag==1)
					{
						?>
						<script type="text/javascript">
							alert('Please Fill Out All Fields');
						</script>
						<?php
					}

					?>

					<div class="forgot2bg pt-5 mt-5">
						<div class="container-fluid h-100">
							<div class="row align-items-center h-100">
								<div class="col-12">
									<div class="card mx-auto forgot2card">
										<div class="card-title text-center forgot2cardtitle">
											<h2 class="title">Forgot Password</h2>
											<hr class="mx-auto my-4 hrline"/>
										</div>
										<div class="card-text text-center">
											<p class="parainfo"><b>Answer the following security question to reset password</b></p><br/>
											<form action="change_info.php" method="POST" autocomplete="off">
												<p class="redpara"><label for="answer"><b><?php echo $security_question; ?></b></label></p>
												<input type="text" name="answer" id="answer" class="form-control mx-auto forgot2input" placeholder="Enter Answer" value="<?php if($flag!=2){echo ($answer);} ?>" required>

												<?php
												if($flag==2)
												{
													?>
													<script type="text/javascript">
														alert('Answer to the Security Question is wrong!');
													</script>
													<?php
												}
												else if($flag==3)
												{
													?>
													<script type="text/javascript">
														alert('Password did not match the criteria!');
													</script>
													<?php
												}
												else if($flag==4)
												{
													?>
													<script type="text/javascript">
														alert('Passwords do not match!');
													</script>
													<?php
												}
												?>

												<hr class="mx-auto my-4 hrline"/>

												<p class="parainfo"><b>Reset Password</b></p><br/>
												<p class="redpara"><label for="password"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password:</b></label></p>
												<input type="password" name="password" id="password" class="form-control mx-auto forgot2input" placeholder="Enter New Password" required>
												<p class="parabracket mx-auto criteria">( The password should be alphanumeric, should contain at least 6 and at most 40 characters )</p><br/>
												<p class="redpara"><label for="password_again"><b><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirm Password:</b></label></p>
												<input type="password" id="password_again" name="password_again" class="form-control mx-auto forgot2input" placeholder="Confirm Password" required>
												<br/>
												
												<input type="submit" class="btn btn-warning forgot2button" value="Submit"><br/><br/>
											</form>
											<a href="login.php" class="forgot2linkstyle">Click here to go back to login page</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					

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
	header('Location: login.php');
}

?>

	<script type="text/javascript">
        window.onresize = function() {
            let x = document.getElementById("navbar");
            navchange();
            if(window.innerWidth > 850)
            {
                x.style.maxHeight = "1000px";
                document.getElementById('bar1').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar3').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('notnav').style.display = 'none';
            }
            else
            {
                x.style.maxHeight = "60px";
                document.getElementById('bar1').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar3').style.transform = 'rotate(0deg) translate(0px,0px)';
                document.getElementById('bar2').style.opacity = '1';
                document.getElementById('notnav').style.display = 'none';
            }
        };

        window.onscroll = function() {
            navchange();
        }

    </script>




</body>
</html>