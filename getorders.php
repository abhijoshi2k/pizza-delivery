<?php

require 'employee_core.php';
require 'database_connect.php';

if(loggedin() && isset($_GET['req']) && $_GET['req'] == '1')
{
	?>

	<tr>
		<th>Order #</th>
		<th>Username</th>
		<th>Order Details</th>
		<th>Total</th>
		<th>Address</th>
		<th>Contact</th>
		<th>Status</th>
		<th>Time</th>
		<th>Change</th>
	</tr>

	<?php

	$query = "SELECT orders.order_id, users.username, orders.order_list, orders.order_quantity, orders.order_total, orders.address, orders.contact, orders.status, orders.order_time FROM orders LEFT JOIN users ON orders.user_id = users.id WHERE orders.status != 4 AND orders.status != 6 ORDER BY orders.order_id DESC";
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
		else if($row['status']=='5')
		{
			$status = 'Cancelled';
		}

		?>

		<form action="order_edit.php" method="POST" id="<?php echo $row['order_id']; ?>">
			<input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
			<input type="hidden" name="status" value="<?php echo ((int)$row['status'] + 1); ?>">
		</form>

		<tr>
			<td><?php echo $row['order_id']; ?></td>
			<td><i><?php echo $row['username']; ?></i></td>
			<td><?php echo $details; ?></td>
			<td><?php echo $row['order_total']; ?></td>
			<td style="padding: 10px 0;"><?php echo nl2br("$row[address]"); ?></td>
			<td><?php echo $row['contact']; ?></td>
			<td><b><?php echo $status ?></b></td>
			<td><?php echo $row['order_time']; ?></td>
			<td>
				<form action="order_edit.php" method="POST" id="<?php echo $row['order_id']; ?>">
					<input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
					<input type="hidden" name="status" value="<?php echo ((int)$row['status'] + 1); ?>">
					<input class="sub-btn" type="submit" value="Next Status">
				</form>
				
			</td>
		</tr>

		<?php
	}
}

else if(loggedin() && isset($_GET['req']) && $_GET['req'] == '2')
{
	$query = "SELECT order_id FROM orders WHERE status != 4 AND status != 6 ORDER BY order_id";
	$query_run = mysqli_query($connect,$query);

	while($row = mysqli_fetch_assoc($query_run))
	{
		?><option value="<?php echo $row['order_id'] ?>"><?php echo $row['order_id']; ?></option><?php
	}
}

else if(loggedin() && isset($_GET['req']) && $_GET['req'] == '3')
{
	?>
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

}

else if(loggedin() && isset($_GET['req']) && $_GET['req'] == '4')
{
	$query = "SELECT order_id FROM orders WHERE 1 ORDER BY order_id";
	$query_run = mysqli_query($connect,$query);

	while($row = mysqli_fetch_assoc($query_run))
	{
		?><option value="<?php echo $row['order_id'] ?>"><?php echo $row['order_id']; ?></option><?php
	}
}

else
{
	http_response_code(404);
}

?>