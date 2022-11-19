<?php

$db_name = 'mysql:host=localhost;dbname=blog_db';
$user_name = 'Elder';
$user_password = 'admin1234';

$conn = new PDO($db_name, $user_name, $user_password);
