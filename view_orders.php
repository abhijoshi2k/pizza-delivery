<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin())
{
	$query = "SELECT order_id, order_total, status, order_time FROM `orders` WHERE user_id=".$_SESSION['user_id']." ORDER BY order_id DESC";
	$query_run = mysqli_query($connect,$query);

	?>

	<h1>All Orders</h1>
	<ol type="1" id="orders">
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
			<li>
				<b>Order ID: </b><?php echo $row['order_id']; ?> | 
				<b>Status: </b><span class="order-status"><?php echo $status; ?></span>
				<br><br>
				<b>Bill Amount: </b>₹<?php echo $row['order_total']; ?> | 
				<b>Order Time: </b><?php echo $row['order_time']; ?>
				<br><br>
				
				<form style="display: inline-block;" action="order_details.php" id="<?php echo $row['order_id']; ?>" method="POST">
					<input type="hidden" name="order" value="<?php echo $row['order_id']; ?>">
					<input type="submit" value="Order Details" form="<?php echo $row['order_id']; ?>">
				</form>

				<span class="cancel-span">

				<?php

				if($status == 'Order Received')
				{
					?>
					<form style="display: inline-block;" action="order_cancel.php" id="<?php echo $row['order_id'].'_c'; ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
						<input type="hidden" name="order" value="<?php echo $row['order_id']; ?>">
						<input type="submit" value="Cancel Order">
					</form>
					<?php
				}

				?>

				</span>
				
				<hr>
				<br>
			</li>
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
		    				cancel[i].innerHTML = '<form style="display: inline-block;" action="order_cancel.php" id="' + response[i].id + '_c' + '" method="POST" onsubmit="return confirm(\'Are you sure you want to cancel your order?\');"><input type="hidden" name="order" value="' + response[i].id + '"><input type="submit" value="Cancel Order"></form>';
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

	<?php
}
else
{
	header('Location: login.php');
}

?>