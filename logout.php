<?php
session_start(); 
setcookie(session_name(), '', time() - 60*60);

unset($_SESSION['alogin']);
session_destroy(); // destroy session
header("location:index.php"); 
?>

