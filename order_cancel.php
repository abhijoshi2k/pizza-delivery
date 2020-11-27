<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin())
{
	if(isset($_POST['order']))
	{
		$order_id = $_POST['order'];
		$query = "SELECT user_id, status FROM `orders` WHERE order_id=".$order_id;
		$query_run = mysqli_query($connect,$query);

		while($row = mysqli_fetch_assoc($query_run))
		{
			$user_id = $row['user_id'];
			$status = $row['status'];
		}
		if($status != '0')
		{
			?>
			<script type="text/javascript">
				alert('The order cannot be cancelled as we have started preparing it!');
				location.replace('<?php echo $http_referer ?>');
			</script>
			<?php
			die();
		}
		if($user_id == $_SESSION['user_id'])
		{
			$query = "UPDATE orders SET status=5 WHERE order_id=".mysqli_real_escape_string($connect,$order_id);
			$query_run = mysqli_query($connect,$query);

			?>

			<script type="text/javascript">
				alert('Order Cancelled Successfully');
				location.replace('<?php echo $http_referer ?>');
			</script>

			<?php
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