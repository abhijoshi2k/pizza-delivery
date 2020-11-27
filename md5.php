<?php
	
	if(isset($_GET['str']) && !empty($_GET['str']))
	{
		echo md5($_GET['str']);
	}

?>