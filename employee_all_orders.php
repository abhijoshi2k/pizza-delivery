<?php

require 'employee_core.php';
require 'database_connect.php';


if(loggedin())
{
	$username = getuserfield('username');
	$firstname = getuserfield('firstname');
	$surname = getuserfield('surname');
	
	echo '<b><i>'.$username.'</i></b><br>';
	echo 'You\'re logged in, '.$firstname.' '.$surname.'.<br><br>';
	?>

	<a href="employee_change.php">Change Password</a>

	<br>

	<a href="employee_logout.php"><b>Logout</b></a>
	<br><br>

	<?php

	$query = "SELECT order_id FROM orders WHERE 1 ORDER BY order_id";
	$query_run = mysqli_query($connect,$query);

	?>

	<script type="text/javascript">
		setInterval(function() {

			var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		    	if (this.readyState == 4 && this.status == 200) {
		    		document.getElementById("table").innerHTML = this.responseText;
		      	}
		    };
		    xmlhttp.open("GET","getorders.php?req=3",true);
		    xmlhttp.send();

		}, 10000);

		setInterval(function() {

			var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		    	if (this.readyState == 4 && this.status == 200) {
		    		document.getElementById("id_list").innerHTML = this.responseText;
		      	}
		    };
		    xmlhttp.open("GET","getorders.php?req=4",true);
		    xmlhttp.send();

		}, 10000);
	</script>

	<form action="order_edit.php" autocomplete="off" method="POST">

		<label for="order_id">Order #: </label>
		<input name="order_id" id="order_id" list="id_list" required>
		<datalist id="id_list">
			<?php

			while($row = mysqli_fetch_assoc($query_run))
			{
				?><option value="<?php echo $row['order_id'] ?>"><?php echo $row['order_id']; ?></option><?php
			}

			?>
		</datalist>

		<label for="order_status">Status: </label>
		<input name="status" id="order_status" list="status_list" required>
		<datalist id="status_list">
			<option value="0">Order Received</option>
			<option value="1">Preparing</option>
			<option value="2">Awaiting Delivery</option>
			<option value="3">Out for Delivery</option>
			<option value="4">Delivered</option>
			<option value="5">Cancelled</option>
			<option value="6">Cancelled (Acknowledged)</option>
		</datalist>

		<input type="hidden" name="override" value="yes">

		<input type="submit" value="Change Status">
		
	</form>
	<p><a href="employee_orders.php">View active orders</a></p>

	<table cellspacing="5" id="table">
		<tr>
			<th>Order #</th>
			<th>Username</th>
			<th>Order Details</th>
			<th>Total</th>
			<th>Address</th>
			<th>Contact</th>
			<th>Status</th>
			<th>Time</th>
		</tr>

		<?php

		$query = "SELECT orders.order_id, users.username, orders.order_list, orders.order_quantity, orders.order_total, orders.address, orders.contact, orders.status, orders.order_time FROM orders LEFT JOIN users ON orders.user_id = users.id WHERE 1 ORDER BY orders.order_id DESC";
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

			$details = "";

			$q_count = 0;

			while($row2 = mysqli_fetch_assoc($query_run2))
			{
				$details = $details.$row2['item']." x".$quantity[$q_count].", ";

				$q_count++;
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
			else if($row['status']=='5')
			{
				$status = 'Cancelled';
			}
			else if($row['status']=='6')
			{
				$status = 'Cancelled (Acknowledged)';
			}

			?>

			<tr>
				<td><?php echo $row['order_id']; ?></td>
				<td><i><?php echo $row['username']; ?></i></td>
				<td><?php echo $details; ?></td>
				<td><?php echo $row['order_total']; ?></td>
				<td style="padding: 10px 0;"><?php echo nl2br("$row[address]"); ?></td>
				<td><?php echo $row['contact']; ?></td>
				<td><b><?php echo $status ?></b></td>
				<td><?php echo $row['order_time']; ?></td>
			</tr>

			<?php
		}

		?>
	</table>

	<?php
}
else
{
	header('Location: employee_login.php');
}

?>