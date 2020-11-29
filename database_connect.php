<?php


// $mysql_host='localhost';
// $mysql_user='root';
// $mysql_pass='pass123';
// $mysql_db='pizza';

//awardspace db_name: 3667817_pizza
//awardspace db_password: PfgsohjN7R3GD(36

$mysql_host='fdb29.awardspace.net';
$mysql_user='3667817_pizza';
$mysql_pass='PfgsohjN7R3GD(36';

$mysql_db='3667817_pizza';

$connect=@mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
if(!$connect)
{
	die('Could not connect :(');
}

?>