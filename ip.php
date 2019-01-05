<?php
//if you have a internet php server,you can update the file to server and access the file path and get you internet ip address
	echo $_SERVER["REMOTE_ADDR"]?:($_SERVER["HTTP_CLIENT_IP"]?:$_SERVER["HTTP_X_FORWARDED_FOR"]);
?>
