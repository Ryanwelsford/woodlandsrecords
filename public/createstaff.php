<?php
require '../database.php';
require '../loadtemplate.php';
if(isset($_POST['submit']))
{
    

}
$content = loadtemplate('../templates/createstaff.html.php',[]);
$header = 'Create Staff Record';
$title = 'Create Staff Record';
require '../templates/layout.html.php';
?>