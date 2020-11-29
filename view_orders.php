<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin())
{
	$query = "SELECT order_id, order_total, status, order_time FROM `orders` WHERE user_id=".$_SESSION['user_id']." ORDER BY order_id DESC";
	$query_run = mysqli_query($connect,$query);

	?>

<!DOCTYPE html>
<html>
<head>
	<title>All Orders | Bomino's Pizza</title>
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
                document.getElementById('nav-logo-image').style.height = '48px';
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
                    <li class="navbar-list active"><div class="navbar-link-text d-inline">View Orders</div></li>
                </a>
                <a href="profile.php" class="navbar-link">
                    <li class="navbar-list"><div class="navbar-link-text d-inline">Profile</div></li>
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

<!-- ALL ORDERS SECTION -->

	<div class="ordersuccessbg">
		<div class="container">
			<div class="row mx-auto pb-1  ordersuccessrow">
				<div class="col-12 ordersuccesstitlecol">
					<div class="ordersuccesstitlebox text-center">
						<p><h1 class="ordersuccesstitle">All Orders</h1></p>
					</div>
				</div> 
				<div class="col-12 ">
					<ol>

						<?php

						while($row = mysqli_fetch_assoc($query_run))
						{
							if($row['status']=='0')
							{
								$status = 'Order Received';
							}
							else if($row['status']=='1')
							{
								$status = 'Preparing';
							}
							else if($row['status']=='2')
							{
								$status = 'Awaiting Delivery';
							}
							else if($row['status']=='3')
							{
								$status = 'Out for Delivery';
							}
							else if($row['status']=='4')
							{
								$status = 'Delivered';
							}
							else if($row['status']=='5' || $row['status']=='6')
							{
								$status = 'Cancelled';
							}
							?>

						<li class="listdetailsli">
							<br/>
							<div class="row listdetailitems">
							<p class=" col-sm-6 col-12"><b>Order ID: </b><span><?php echo $row['order_id']; ?></span></p>  
							<p class=" col-sm-6 col-12"><b>Status: </b><span class="order-status"><?php echo $status; ?></span></p>  
							<p class=" col-sm-6 col-12"><b>Bill Amount: ₹</b><span><?php echo $row['order_total']; ?></span></p> 
							<p class=" col-sm-6 col-12"><b>Order Time: </b><span><?php echo $row['order_time']; ?></span></p>
							</div>
							<br/>
							<div class="text-center">
								<form style="display: inline-block;" action="order_details.php" id="<?php echo $row['order_id']; ?>" method="POST">
									<input type="hidden" name="order" value="<?php echo $row['order_id']; ?>">
									<input type="submit" class="btn btn-success orderdetaillisbtn" value="Order Details" form="<?php echo $row['order_id']; ?>">
								</form>

								<span class="cancel-span">
									<?php

									if($status == 'Order Received')
									{
										?>
										<form style="display: inline-block;" action="order_cancel.php" id="<?php echo $row['order_id'].'_c'; ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
											<input type="hidden" name="order" value="<?php echo $row['order_id']; ?>">
											<input type="submit" class="btn btn-dark orderdetaillisbtn" value="Cancel Order">
										</form>
										<?php
									}

									?>
								</span>
							</div>

						</li>
						<hr class="my-4">
						<?php
						}

						?>
					</ol>

					<script type="text/javascript">
						setInterval(function() {

							var xmlhttp = new XMLHttpRequest();
						    xmlhttp.onreadystatechange = function() {
						    	if (this.readyState == 4 && this.status == 200) {
						    		var response = this.responseText;
						    		response = JSON.parse(response);

						    		var cancel = document.getElementsByClassName('cancel-span');
						    		var stat = document.getElementsByClassName('order-status');

						    		for(var i=0; i<cancel.length; i++)
						    		{
						    			stat[i].innerHTML = response[i].status;
						    			if(response[i].status == 'Order Received')
						    			{
						    				cancel[i].innerHTML = '<form style="display: inline-block;" action="order_cancel.php" id="' + response[i].id + '_c' + '" method="POST" onsubmit="return confirm(\'Are you sure you want to cancel your order?\');"><input type="hidden" name="order" value="' + response[i].id + '"><input type="submit" class="btn btn-dark orderdetaillisbtn" value="Cancel Order"></form>';
						    			}
						    			else
						    			{
						    				cancel[i].innerHTML = '';
						    			}
						    		}
						      	}
						    };
						    xmlhttp.open("GET","update_orders.php?req=1",true);
						    xmlhttp.send();

						}, 10000);
					</script>
				</div>
			</div>
		</div>
	</div>

<!-- ALL ORDERS SECTION -->

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


<footer class="footer pt-4 pb-4">
    <div class="container text-white">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <h3 class="text-center">Our Branches</h3>
                <p class="text-center">
                    Mumbai
                    <br>
                    Chennai
                    <br>
                    Bangalore
                </p>
            </div>
            <div class="col-lg-4 col-sm-6 col-12 pt-sm-0 pt-3">
                <h3 class="text-center">Reach Out to Us</h3>
                <p class="text-center pt-2">
                    <i class="fas fa-phone-alt"></i> 9876987699
                </p>
                <p class="text-center">
                    <i class="fas fa-envelope"></i> contact@bominos.com
                </p>
            </div>
            <div class="col-lg-4 col-12 pt-lg-0 pt-3">
                <h3 class="text-center">Our Safety Norms</h3>
                <p class="text-center">
                    All our Employees Wear Masks
                    <br>
                    Contact-less Delivery
                    <br>
                    Temperature checking of all employees
                </p>
            </div>
        </div>
    </div>
</footer>


</body>
</html>

	<?php
}
else
{
	header('Location: login.php');
}

?>