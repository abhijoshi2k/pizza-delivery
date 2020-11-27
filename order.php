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

	<h1>Order Placed Successfully</h1>
	<p><b>Order ID: </b><?php echo $_SESSION['insert_id']; ?></p>
	<p><b>Order TimeStamp: </b><?php echo $_SESSION['ts']; ?></p>
	<p><b>Address: </b><br><?php echo nl2br("$_SESSION[address]"); ?></p>
	<p><b>Contact Number provided: </b><?php echo $_SESSION['contact']; ?></p>
	<br>

	<table>
		<tr>
			<th>Sr.No.</th>
			<th>Item</th>
			<th>Quantity</th>
			<th>Net Cost</th>
			<th>Total</th>
		</tr>

	<?php

	for($i=0; $i<$_SESSION['number_of_items']; $i++)
	{
		?>

		<tr>
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $name[$i]; ?></td>
			<td><?php echo $quantity[$i]; ?></td>
			<td><?php echo $price[$i]; ?></td>
			<td><?php echo $item_total[$i]; ?></td>
		</tr>

		<?php
	}

	?>

	</table>
	<br>
	<h2>Total: <?php echo $_SESSION['tot']; ?></h2>
	<br>
	<form action="order_cancel.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
		<input type="hidden" name="order" value="<?php echo $_SESSION['insert_id']; ?>">
		<input type="submit" value="Cancel Order">
	</form>
	<br>
	<a href="view_orders.php">View all orders!</a>
	<br>
	<a href="order.php">Order More!</a>

	<?php
	unset($_SESSION['insert_id'],$_SESSION['ts'],$_SESSION['number_of_items'],$_SESSION['name'],$_SESSION['quantity'],$_SESSION['price'],$_SESSION['item_total'],$_SESSION['tot'],$_SESSION['address'],$_SESSION['contact']);
}

else if(loggedin())
{
	?>

	<script type="text/javascript">
		function changeInp(id,check)
		{
			var input = document.getElementById(id);
			if(check)
			{
				input.removeAttribute('disabled');
				input.value = 1;
				input.setAttribute('min', '1');
			}
			else
			{
				input.removeAttribute('min');
				input.value = 0;
				input.setAttribute('disabled', 'true');
			}
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

	<form action="order.php" method="POST" autocomplete="off">
		<table>
			<tr>
				<th>Sr.No.</th>
				<th>Item</th>
				<th>Cost</th>
				<th>Add to Cart</th>
				<th>Quantity</th>
			</tr>

		<?php
		while($menu_item = mysqli_fetch_assoc($query_run))
		{
			?>

			<tr>
				<td>
					<?php echo $count; ?>
				</td>
				<td>
					<?php echo $menu_item['item']; ?>
				</td>
				<td>
					<?php echo $menu_item['cost']; ?>
				</td>
				<td>
					<input type="checkbox" onchange="changeInp(this.getAttribute('item')+'_q',this.checked);" name="item[]" item="<?php echo $menu_item['id']; ?>" value="<?php echo $menu_item['id']; ?>">
				</td>
				<td>
					<input type="number" name="<?php echo $menu_item['id'].'_q'; ?>" id="<?php echo $menu_item['id'].'_q'; ?>" value="0" disabled required>
				</td>
			</tr>

			<?php
			$count++;
		}
		?>
		</table>

		<?php

		$query = "SELECT contact FROM `users` WHERE id=".$_SESSION['user_id'];
		$query_run = mysqli_query($connect,$query);

		while($row = mysqli_fetch_assoc($query_run))
		{
			$contact = $row['contact'];
		}

		?>

		<br>
		<label for="address">Address: </label><br>
		<textarea name="address" id="address" rows="5" cols="40" required></textarea>
		<br><br>
		<label for="contact">Contact Number: </label>
		<input type="text" id="contact" name="contact" value="<?php echo $contact; ?>" maxlength="10" required>
		<br><br>
		<input type="submit" value="Place Order">

	</form>

	<br>
	<a href="view_orders.php">View all orders!</a>

	<?php
}
else
{
	header('Location: login.php');
}

?>