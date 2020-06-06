<?php
require '../database.php';
require '../loadtemplate.php';
$content = loadtemplate('../templates/home.html.php',[]);
$header = "Home";
$title = "Home";
require '../templates/layout.html.php';
?>