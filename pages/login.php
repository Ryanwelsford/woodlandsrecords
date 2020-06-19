<?php
require '../database.php';
require '../loadtemplate.php';
$content = loadtemplate('../templates/login.html.php',[]);
$header = 'Login';
$title = 'Login';
require '../templates/loginlayout.html.php';
?>