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

				?><b>Order ID: </b><?php echo $_POST['order'];
				?><br>
				<b>Order Status: </b><span id="status"><?php echo $status;
				?></span><br>
				<b>Order received at: </b><?php echo $row['order_time'];
				?><br><br><?php

				?>

				<table>
					<tr>
						<th>Sr.No.</th>
						<th>Item</th>
						<th>Cost/Item</th>
						<th>Quantity</th>
						<th>Item Total</th>
					</tr>
					<?php

					for($i=0; $i<$count; $i++)
					{
						?>

						<tr>
							<td><?php echo ($i+1); ?></td>
							<td><?php echo $item[$i]; ?></td>
							<td><?php echo $cost[$i]; ?></td>
							<td><?php echo $quantity[$i]; ?></td>
							<td><?php echo ((int)$cost[$i] * (int)$quantity[$i]); ?></td>
						</tr>

						<?php
					}

					?>
				</table>

				<h2>Total: <?php echo $row['order_total']; ?></h2>
				<p><b>Address:</b><br><?php echo nl2br("$row[address]"); ?></p>
				<p><b>Contact: </b><?php echo $row['contact']; ?></p>

				<span id="cancel">

				<?php

				if($status == 'Order Received')
				{
					?>

					<form action="order_cancel.php" id="<?php echo $_POST['order'].'_c'; ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
						<input type="hidden" name="order" value="<?php echo $_POST['order']; ?>">
						<input type="submit" id="sub-btn" value="Cancel Order" form="<?php echo $_POST['order'].'_c'; ?>">
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
					    			document.getElementById('cancel').innerHTML = '<form style="display: inline-block;" action="order_cancel.php" id="' + response.id + '_c' + '" method="POST" onsubmit="return confirm(\'Are you sure you want to cancel your order?\');"><input type="hidden" name="order" value="' + response.id + '"><input type="submit" value="Cancel Order"></form>';
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