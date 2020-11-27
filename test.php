<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin() && isset($_GET['req']) && $_GET['req'] == '2' && isset($_SESSION['order_id']))
{
	$query = "SELECT status, order_id FROM `orders` WHERE order_id=".$_SESSION['order_id'];
	$query_run = mysqli_query($connect,$query);

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

		$order_detail = new stdClass;

		@$order_detail->id = $row['order_id'];
		@$order_detail->status = $status;
	}

	echo json_encode($order_detail);
}

?>