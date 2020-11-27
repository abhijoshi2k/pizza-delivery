<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin())
{
	?>
	<script type="text/javascript">
		alert('Registered Successfully!');
		location.replace('login.php');
	</script>
	<?php
}
else
{
	header("Location: login.php");
}

?>