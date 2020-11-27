<?php

require 'employee_core.php';
require 'database_connect.php';

if(loggedin() && isset($_POST['order_id'],$_POST['status']))
{
	if(!isset($_POST['override']))
	{
		$query = "SELECT status FROM orders WHERE order_id = ".$_POST['order_id'];
		$query_run = mysqli_query($connect,$query);

		while($row = mysqli_fetch_assoc($query_run))
		{
			if($row['status'] == '5' && ($_POST['status'] != '5' && $_POST['status'] != '6'))
			{
				?>

				<script type="text/javascript">
					alert('Client has cancelled the order! Changes could not be made');
					location.replace('<?php echo $http_referer ?>');
				</script>

				<?php
				die('Error!');
			}
		}
	}

	$query = "UPDATE orders SET status = ".mysqli_real_escape_string($connect,$_POST['status'])." WHERE order_id = ".mysqli_real_escape_string($connect,$_POST['order_id']);
	$query_run = mysqli_query($connect,$query);

	header("Location: ".$http_referer);
}

else
{
	header("Location: login.php");
}

?>