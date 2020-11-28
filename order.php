<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin() && isset($_POST['address']) && isset($_POST['contact']) && !empty($_POST['address']) && !empty($_POST['contact']))
{
	if(!isset($_POST['item']))
	{
		$_SESSION['flag'] = '1';
		header('Location: order.php');
		die('error!');
	}
	if(!checkcontact($_POST['contact']))
	{
		$_SESSION['flag'] = '2';
		header('Location: order.php');
		die('error!');
	}

	$address = $_POST['address'];
	$contact = $_POST['contact'];
	$item = $_POST['item'];

	$pizzas = array();
	$quantity = array();
	$price = array();
	$name = array();
	$item_total = array();
	$total = 0;

	foreach ($item as $pizza) {
		array_push($pizzas, $pizza);
		array_push($quantity, $_POST[$pizza.'_q']);
		$query = "SELECT cost,item FROM `menu` WHERE id=".$pizza;
		$query_run = mysqli_query($connect,$query);
		while($menu_item = mysqli_fetch_assoc($query_run))
		{
			array_push($price, $menu_item['cost']);
			array_push($name, $menu_item['item']);
			array_push($item_total, ((int)$menu_item['cost'] * (int)$_POST[$pizza.'_q']));
			$total = $total + ((int)$menu_item['cost'] * (int)$_POST[$pizza.'_q']);
		}
	}

	$pizzas_str = implode(" ", $pizzas);
	$quantity_str = implode(" ", $quantity);

	date_default_timezone_set('Asia/Kolkata');
	$time = date("d/m/Y h:i:sa").' IST';

	$query = "INSERT INTO `orders` (user_id,order_list,order_quantity,order_total,address,contact,status,order_time) VALUES (".$_SESSION['user_id'].",'".$pizzas_str."','".$quantity_str."',".$total.",'".mysqli_real_escape_string($connect,$address)."',".$contact.",0,'".$time."')";
	if($query_run = mysqli_query($connect,$query))
	{
		$insert_id = mysqli_insert_id($connect);
	}

	$number_of_items = count($pizzas);

	$_SESSION['insert_id'] = $insert_id;
	$_SESSION['ts'] = $time;
	$_SESSION['number_of_items'] = $number_of_items;
	$_SESSION['name'] = implode("_", $name);
	$_SESSION['quantity'] = $quantity_str;
	$_SESSION['price'] = implode(" ", $price);
	$_SESSION['item_total'] = implode(" ", $item_total);
	$_SESSION['tot'] = (string)$total;
	$_SESSION['address'] = $address;
	$_SESSION['contact'] = $contact;

	header('Location: order.php');
}



else if(isset($_SESSION['insert_id'],$_SESSION['ts'],$_SESSION['number_of_items'],$_SESSION['name'],$_SESSION['quantity'],$_SESSION['price'],$_SESSION['item_total'],$_SESSION['tot'],$_SESSION['address'],$_SESSION['contact']))
{
	$name = explode("_", $_SESSION['name']);
	$quantity = explode(" ", $_SESSION['quantity']);
	$price = explode(" ", $_SESSION['price']);
	$item_total = explode(" ", $_SESSION['item_total']);
	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Place Order</title>
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
	                <li class="navbar-list active"><div class="navbar-link-text d-inline">Order Now</div></li>
	            </a>
	            <?php
	            if(loggedin())
	            {
	                ?>
	                <a href="view_orders.php" class="navbar-link">
	                    <li class="navbar-list"><div class="navbar-link-text d-inline">View Orders</div></li>
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

			<div class="ordersuccessbg">
				<div class="container">
					<div class="row mx-auto ordersuccessrow">
						<div class="col-12 ordersuccesstitlecol">
							<div class="ordersuccesstitlebox text-center">
								<p><h1 class="ordersuccesstitle">Order Placed Successfully</h1></p>
							</div>
						</div>
						<div class="col-12 ordersuccessdetailscol">
							<div class="ordersuccessdetails">
								<p class="ordersuccessdetailsitem"><b>Order ID:</b><span> <?php echo $_SESSION['insert_id']; ?></span></p>
								<p class="ordersuccessdetailsitem"><b>Order Time Stamp:</b><span> <?php echo $_SESSION['ts']; ?></span></p>
								<p class="ordersuccessdetailsitem"><b>Address:</b><br><span>
									<?php echo nl2br("$_SESSION[address]"); ?>
								</span></p>
								<p class="ordersuccessdetailsitem"><b>Contact Number Provided:</b><span> <?php echo $_SESSION['contact']; ?></span></p>
							</div>
						</div>
						<div class="col-12 ordersuccesstablecol">
							<div class="ordersuccesstablebox">
								<table class="ordersuccesstable">
									<thead>
										<tr>
											<th>SrNo.</th>
											<th>Item</th>
											<th>Quantity</th>
											<th>Net Cost</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php

										for($i=0; $i<$_SESSION['number_of_items']; $i++)
										{
											?>

											<tr class="tableitems">
												<td><?php echo ($i+1); ?></td>
												<td><?php echo $name[$i]; ?></td>
												<td><?php echo $quantity[$i]; ?></td>
												<td><?php echo $price[$i]; ?></td>
												<td><?php echo $item_total[$i]; ?></td>
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
								<p class="mb-0"><b>Grand Total:<span> <?php echo $_SESSION['tot']; ?></span></b></p>
							</div>
						</div>
						<div class="col-12 ordersuccesscancelcol">
							<br/>
							<form action="order_cancel.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
								<div class="ordersuccesscancel text-center">
									<input type="hidden" name="order" value="<?php echo $_SESSION['insert_id']; ?>">
									<button type="submit" class="btn btn-dark ordersuccesscancelbtn">Cancel Order</button>
								</div>
							</form>
						</div>
						<div class="col-12 ordersuccesslinks text-center">
							<br/>
							<p><a href="view_orders.php" class="ordersuccesslinksitem">View all orders</a></p>
							<p><a href="order.php" class="ordersuccesslinksitem">Order more!</a></p>
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






</body>
</html>

		<?php
		unset($_SESSION['insert_id'],$_SESSION['ts'],$_SESSION['number_of_items'],$_SESSION['name'],$_SESSION['quantity'],$_SESSION['price'],$_SESSION['item_total'],$_SESSION['tot'],$_SESSION['address'],$_SESSION['contact']);
	}




	else if(loggedin())
	{
		?>

		<!DOCTYPE html>
		<html>
		<head>
			<title>Place Order</title>
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
		                <li class="navbar-list active"><div class="navbar-link-text d-inline">Order Now</div></li>
		            </a>
		            <?php
		            if(loggedin())
		            {
		                ?>
		                <a href="view_orders.php" class="navbar-link">
		                    <li class="navbar-list"><div class="navbar-link-text d-inline">View Orders</div></li>
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

		<script type="text/javascript">
			function changeInp(id,check)
			{
				var input = document.getElementById(id);
				if(check)
				{
					input.removeAttribute('disabled');
					input.value = 1;
					input.setAttribute('min', '1');
					tot();
				}
				else
				{
					input.removeAttribute('min');
					input.value = 0;
					input.setAttribute('disabled', 'true');
					tot();
				}
			}

			function tot()
			{
				var cost = document.getElementsByClassName('order-cost');
				var quantity = document.getElementsByClassName('order-quantity');

				var total = 0, temp_q;

				for(var i=0;i<cost.length;i++)
				{
					if(isNaN(parseInt(quantity[i].value, 10)))
					{
						temp_q = 0;
					}
					else
					{
						temp_q = parseInt(quantity[i].value, 10);
					}
					total += (parseInt(cost[i].innerHTML, 10) * temp_q);
				}

				document.getElementById('grand-tot').innerHTML = total;
			}
		</script>


		<?php
		$query = "SELECT id, item, cost FROM `menu` WHERE included=1";
		$query_run = mysqli_query($connect,$query);
		$count = 1;

		if(isset($_SESSION['flag']) && $_SESSION['flag'] == '1')
		{
			$_SESSION['flag'] = '0';
			?>
			<script type="text/javascript">
				alert('Please select Pizzas!');
			</script>
			<?php
		}
		else if(isset($_SESSION['flag']) && $_SESSION['flag'] == '2')
		{
			$_SESSION['flag'] = '0';
			?>
			<script type="text/javascript">
				alert('Please enter valid Phone Number!');
			</script>
			<?php
		}
		?>


		<!-- PLACE ORDER SECTION -->

			<div class="ordersuccessbg">
				<div class="container">
					<div class="row mx-auto pb-1 ordersuccessrow">
						<div class="col-12 ordersuccesstitlecol">
							<div class="ordersuccesstitlebox text-center">
								<p><h1 class="ordersuccesstitle">Place Order</h1></p>
							</div>
						</div>
						<div class="col-12 ordersuccesstablecol">
							<div class="ordersuccesstablebox">
								<form action="order.php" method="POST" autocomplete="off">
									<table class="ordersuccesstable">
										<thead>
											<tr>
												<th>SrNo.</th>
												<th>Item</th>
												<th>Cost</th>
												<th>Add to Cart</th>
												<th>Quantity</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while($menu_item = mysqli_fetch_assoc($query_run))
											{
												?>

												<tr class="tableitems">
													<td>
														<?php echo $count; ?>
													</td>
													<td>
														<?php echo $menu_item['item']; ?>
													</td>
													<td class="order-cost">
														<?php echo $menu_item['cost']; ?>
													</td>
													<td>
														<input type="checkbox" class="checkboxsize " onchange="changeInp(this.getAttribute('item')+'_q',this.checked);" name="item[]" item="<?php echo $menu_item['id']; ?>" value="<?php echo $menu_item['id']; ?>">
													</td>
													<td>
														<input type="number" class="order-quantity form-control" onkeyup="tot();" onchange="tot();" name="<?php echo $menu_item['id'].'_q'; ?>" id="<?php echo $menu_item['id'].'_q'; ?>" value="0" disabled required>
													</td>
												</tr>

												<?php
												$count++;
											}
											?>
										</tbody>
									</table>
									<?php

									$query = "SELECT contact FROM `users` WHERE id=".$_SESSION['user_id'];
									$query_run = mysqli_query($connect,$query);

									while($row = mysqli_fetch_assoc($query_run))
									{
										$contact = $row['contact'];
									}

									?>
								</div>
							</div>

							<div class="col-12 ordersuccesstotalcol">
								<div class="ordersuccesstotal">
										<p class="mb-0"><b>Grand Total: <span id="grand-tot">0</span></b></p>
								</div>
							</div>

							<div class="col-12">
								<div class="row bg-grey">	
									<div class="col-sm-6 col-12  ordersuccessdetailscol">
										<div class="ordersuccessdetails text-left">

											<p class="ordersuccessdetailsitem"><label for="address"><b>Address: </b></label></p>
											<textarea name="address" class="form-control inpshadow" id="address" rows="3" cols="40" required></textarea>
											
										</div>
									</div>
									<div class="col-sm-6 col-12  ordersuccessdetailscol">
										<div class="ordersuccessdetails text-left">

											<p class="ordersuccessdetailsitem"><label for="contact"><b>Contact Number: </b></label></p>
											<input type="text" class="form-control inpshadow" id="contact" name="contact" value="<?php echo $contact; ?>" maxlength="10" required>
											
										</div>
									</div>
								</div>	
							</div>

							<div class="text-center col-12 ">
								<button type="submit" class="btn btn-success ordersuccesscancelbtn"  >Place order</button>
							</div>
								
								
							</div>
						</form>	 
					</div>
				</div>
			</div>

		<!-- PLACE ORDER SECTION -->

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
		header('Location: login.php');
	}

	?>