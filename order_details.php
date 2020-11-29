<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin())
{
	if(isset($_POST['order']))
	{
		$_SESSION['order_id'] = $_POST['order'];
		$query = "SELECT user_id FROM `orders` WHERE order_id=".$_POST['order'];
		$query_run = mysqli_query($connect,$query);

		while($row = mysqli_fetch_assoc($query_run))
		{
			$user_id = $row['user_id'];
		}
		if($user_id == $_SESSION['user_id'])
		{
			$query = "SELECT order_list, order_quantity, order_total, address, contact, status, order_time FROM `orders` WHERE order_id=".$_POST['order'];
			$query_run = mysqli_query($connect,$query);

			while($row = mysqli_fetch_assoc($query_run))
			{
				$list = explode(" ", $row['order_list']);
				$quantity = explode(" ", $row['order_quantity']);

				$count = count($list);

				$query = "SELECT item, cost FROM menu WHERE id=";

				for($i=0; $i<$count; $i++)
				{
					$query = $query.$list[$i]." OR id=";
				}
				$query = $query."0";

				$query_run2 = mysqli_query($connect,$query);

				$item = array();
				$cost = array();

				while($row2 = mysqli_fetch_assoc($query_run2))
				{
					array_push($item, $row2['item']);
					array_push($cost, $row2['cost']);
				}

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

<!DOCTYPE html>
<html>
<head>
	<title>Order Details | Bomino's Pizza</title>
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


<!-- ORDER SUCCESS SECTION -->

	<div class="ordersuccessbg ">
		<div class="container">
			<div class="row mx-auto ordersuccessrow">
				<div class="col-12 ordersuccesstitlecol">
					<div class="ordersuccesstitlebox text-center">
						<p><h1 class="ordersuccesstitle">Order Details</h1></p>
					</div>
				</div>
				<div class="col-12 ordersuccessdetailscol">
					<div class="ordersuccessdetails">
						<p class="ordersuccessdetailsitem"><b>Order ID:</b><span> <?php echo $_POST['order']; ?></span></p>
						<p class="ordersuccessdetailsitem"><b>Order status: </b><span id="status"><?php echo $status; ?></span></p>
						<p class="ordersuccessdetailsitem"><b>Order recieved at:</b><span> <?php echo $row['order_time']; ?></span></p>						
					</div>
				</div>
				<div class="col-12 ordersuccesstablecol">
					<div class="ordersuccesstablebox">
						<table class="ordersuccesstable">
							<thead>
								<tr>
									<th>Sr no.</th>
									<th>Item</th>
									<th>Quantity</th>
									<th>Net Cost</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php

								for($i=0; $i<$count; $i++)
								{
									?>
									<tr class="tableitems">
										<td><?php echo ($i+1); ?></td>
										<td><?php echo $item[$i]; ?></td>
										<td><?php echo $cost[$i]; ?></td>
										<td><?php echo $quantity[$i]; ?></td>
										<td><?php echo ((int)$cost[$i] * (int)$quantity[$i]); ?></td>
									</tr>
									<?php
								}

								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-12 ordersuccesstotalcol">
					<div class="ordersuccesstotal">
						<p class="mb-0"><b>Grand Total:<span> <?php echo $row['order_total']; ?></span></b></p>
					</div>
				</div>
                <div class="col-12 ordersuccessdetailscol">
                    <br/>
                    <div class="ordersuccessdetails">
                        <p class="ordersuccessdetailsitem"><b>Address:</b><br><span><?php echo nl2br("$row[address]"); ?></span></p>
                        <p class="ordersuccessdetailsitem"><b>Contact Number Provided:</b><span> <?php echo $row['contact']; ?></span></p>
                    </div>
                </div>
				<div class="col-12 ordersuccesscancelcol">
					<br/>
					<span id="cancel">

						<?php

						if($status == 'Order Received')
						{
							?>
							<form action="order_cancel.php" id="<?php echo $_POST['order'].'_c'; ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
								<div class="ordersuccesscancel text-center">
									<input type="hidden" name="order" value="<?php echo $_POST['order']; ?>">
									<button type="submit" class="btn  btn-dark ordersuccesscancelbtn" id="sub-btn" form="<?php echo $_POST['order'].'_c'; ?>">Cancel Order</button>
								</div>
							</form>
							<?php
						}

						?>
					</span>

					<script type="text/javascript">
						setInterval(function() {

							var xmlhttp = new XMLHttpRequest();
						    xmlhttp.onreadystatechange = function() {
						    	if (this.readyState == 4 && this.status == 200) {
						    		var response = this.responseText;

						    		response = JSON.parse(response);

						    		document.getElementById("status").innerHTML = response.status;

						    		if(response.status == 'Order Received')
						    		{
						    			document.getElementById('cancel').innerHTML = '<form action="order_cancel.php" id="' + response.id + '_c' + '" method="POST" onsubmit="return confirm(\'Are you sure you want to cancel your order?\');"><div class="ordersuccesscancel text-center"><input type="hidden" name="order" value="' + response.id + '"><button type="submit" class="btn  btn-dark ordersuccesscancelbtn" id="sub-btn">Cancel Order</button></div></form>';
						    		}
						    		else
						    		{
						    			document.getElementById('cancel').innerHTML = '';
						    		}
						      	}
						    };
						    xmlhttp.open("GET","update_orders.php?req=2",true);
						    xmlhttp.send();

						}, 10000);
					</script>


	                <div class="col-12 ordersuccesslinks text-center">
	                    <p><a href="view_orders.php" class="ordersuccesslinksitem">View all orders</a></p>
	                </div>
				</div>
				
			</div>
		</div>
	</div>
<!-- ORDER SUCCESS SECTION -->

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
		}
		else
		{
			header('Location: view_orders.php');
		}
	}
	else
	{
		header('Location: view_orders.php');
	}
}
else
{
	header('Location: login.php');
}

?>