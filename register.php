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

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
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
<body class="registerbody">

	<nav class="position-fixed topnav" id="navbar">

        <div class="nav-logo position-absolute">
            <a href="#"><img src="images/15b78dc9-cf77-49fe-97f4-fe2b4e5fb36b_200x200.png" class="nav-logo-img" id="nav-logo-image" alt=""></a>
        </div>

        <div class="toggle-bars position-absolute" onclick="menu();">
            <div class="bar-1 bar" id="bar1"></div>
            <div class="bar-2 bar" id="bar2"></div>
            <div class="bar-3 bar" id="bar3"></div>
        </div>

        <ul class="navbar-ul mb-0" id="navbar-ul">
            <a href="#" class="navbar-link">
                <li class="navbar-list active"><div class="navbar-link-text d-inline">Home</div></li>
            </a>
            <a href="#" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">About Us</div></li>
            </a>
            <a href="#" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Courses</div></li>
            </a>
            <a href="#" class="navbar-link">
                <li class="navbar-list"><div class="navbar-link-text d-inline">Login</div></li>
            </a>
            <a href="#" class="navbar-link" id="reg-link">
                <li class="navbar-list" id="reg-list"><div class="navbar-link-text d-inline">Register</div></li>
            </a>
        </ul>

    </nav>


	<div class="registerbg">
		<div class="container-fluid h-100">
			<div class="row pt-5 mt-5 h-100">
				<div class="col-12">
					<div class="card mx-auto registercard">
						<div class="card-title text-center registercardtitle">
							<h2>Register</h2>
						</div>
						<div class="card-text">
							<form action="register.php" method="POST" autocomplete="off">
								<hr class="mb-4 mt-1 hrline"/>

								<p class="redpara"><label for="firstname"><i class="fa fa-user" aria-hidden="true"></i> Firstname:</label></p>
								<input type="text" name="firstname" id="firstname" class="form-control registerinput" placeholder="Firstname" maxlength="40" value="<?php if(isset($_POST['firstname'])){echo ($_POST['firstname']);} ?>" required><br/>
								<p class="redpara"><label for="surname"><i class="fa fa-user" aria-hidden="true"></i> Surname:</label></p>
								<input type="text" name="surname" id="surname" class="form-control registerinput" placeholder="Lastname" maxlength="40" value="<?php if(isset($_POST['surname'])){echo($_POST['surname']);} ?>" required>
								<br/>

								<p class="redpara">
									<label for="contact">
										<i class="fa fa-mobile" aria-hidden="true"></i> Mobile Number (without country code):
									</label>
								</p>
								<input type="text" name="contact" id="contact" class="form-control registerinput" placeholder="Mobile Number" maxlength="10" value="<?php if(isset($_POST['contact'])){echo($_POST['contact']);} ?>" required>

								<?php
								if(isset($contact_validity) && $contact_validity!=true)
								{
									?>
									<script type="text/javascript">
										alert('Please enter valid mobile number!');
										document.getElementById('contact').focus();
									</script>
									<?php
								}
								?>
								<?php
								if(isset($duplicate_contact))
								{
									if($duplicate_contact>0)
									{
										?>
										<script type="text/javascript">
											alert('Contact Number is already registered!');
											document.getElementById('contact').focus();
										</script>
										<?php
									}
								}
								?>
								<br/>

								<hr class="my-4 hrline"/><br/>
								
								<p class="redpara"><label for="username"><i class="fa fa-user" aria-hidden="true"></i> Username:</label></p>
								<input type="text" name="username" id="username" class="form-control registerinput" placeholder="Username" maxlength="30" value="<?php if(isset($_POST['username'])){echo($_POST['username']);} ?>" required>

								<?php
								if(isset($duplicate_username))
								{
									?>
									<script type="text/javascript">
										alert('Given username already exists!');
										document.getElementById('username').focus();
									</script>
									<?php
								}
								?>
								<br/>
								<p class="criteria">Criteria for Username:
									<ol class="criteria">
									<li>Only contains <i>alphanumeric characters, underscore </i>and <i>dot</i>.</li>
									<li><i>Underscore</i> and <i>dot</i> cannot be at start of username.</li>
									<li><i>Underscore</i> and <i>dot</i> cannot be next to each other or used consecutively.</li>
									<li>At least 3 and at most 30 characters should be used.</li>
									</ol>
								</p>
								
								<hr class="my-2" class="hrline"/><br/>

								
								
								<p class="redpara"><label for="password"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password:</label></p>
								<input type="password" name="password" id="password" class="form-control registerinput" placeholder="Password" value="<?php if(isset($_POST['password'])){echo($_POST['password']);} ?>" maxlength="40" required>
								<p class="criteria">(The password should be alphanumeric, should contain at least 6 and at most 40 characters)
								</p><br/>
								<p class="redpara"><label for="password_again"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Confirm Password:</label></p>
								<input type="password" id="password_again" name="password_again" class="form-control registerinput" placeholder="Retype Password" value="<?php if(isset($_POST['password_again'])){echo($_POST['password_again']);} ?>" required><br/>

								<?php
								if(isset($password_validity) && $password_validity!=true)
								{

								?>

								<script type="text/javascript">
									alert('The password should be alphanumeric, should contain at least 6 and at most 40 characters.');
								</script>

								<?php
								}

								else if (isset($_POST['password_again']) && isset($_POST['password']) && $_POST['password']!=$_POST['password_again'])
								{

								?>

								<script type="text/javascript">
									alert('Entered Passwords do not Match!');
									document.getElementById('password').focus();
								</script>

								<?php

								}

								?>
								
								<hr class="my-4" class="hrline"/><br/>

								<p class="redpara"><label for="sec_qt"><i class="fa fa-question" aria-hidden="true"></i> Enter Security Question:
								</label></p>
								<input type="text" id="sec_qt" name="sec_qt" class="form-control registerinput" placeholder="Enter Security Question" maxlength="100" value="<?php if(isset($_POST['sec_qt'])){echo($_POST['sec_qt']);} ?>" required><br/>
								<p class="redpara"><label for="sec_ans"><i class="fa fa-arrow-right" aria-hidden="true"></i> Enter Answer:</label>
								</p>
								<input type="text" id="sec_ans" name="sec_ans" class="form-control registerinput" placeholder="Enter Security Answer" maxlength="20" value="<?php if(isset($_POST['sec_ans'])){echo($_POST['sec_ans']);} ?>" required>
								<p class="criteria">(The answer is not case sensitive)</p>
								
								<hr class="my-2" class="hrline"/><br/>
								
								<img class="capimage" src="captcha.php" id="generate"><br/>
								<br/>
								<p class="redpara"><label for="captcha"><i class="fa fa-arrow-right" aria-hidden="true"></i> Captcha:</label></p>
								<input type="text" name="captcha" id="captcha" class="form-control registerinput" 
								placeholder="Enter the 4-digit Captcha" required>
								<button type="button" class="btn btn-success changecapbutton" onclick="document.getElementById('generate').src='captcha.php'">Change Captcha</button><br/><br/>

								<?php

								if(isset($wrong))
								{
									?>
									<script type="text/javascript">
										alert('Please retry CAPTCHA!');
										document.getElementById('captcha').focus();
									</script>
									<?php
								}

								?>
								
								<hr class="my-2" class="hrline"/><br/>
								
								<div class="text-center">
									<input type="submit" class="btn btn-warning  registerbutton" value="Register">
								</div>
							</form>
							<div class="text-center">
								<a href="LoginPage.html" class="registerlinkstyle">Already have an account? Login here</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

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

<?php

}
else
{
	header('Location: profile.php');
}

?>