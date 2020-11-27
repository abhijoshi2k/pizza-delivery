<?php

require 'core_login.php';

session_destroy();
header('Location: '.$http_referer);

?>