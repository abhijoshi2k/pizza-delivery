<?php

require 'employee_core.php';

session_destroy();
header('Location: '.$http_referer);

?>