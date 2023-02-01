<?php

define('DB_NAME', 'login_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');

$string = "mysql:host=localhost;dbname=login_db";
if(!$connection = new PDO($string,DB_USER,DB_PASS))
{
    die("Failed to connect");
};

?>