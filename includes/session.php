<?php
 session_start(); 
 session_regenerate_id();
if (!isset($_SESSION['alogin'])) { 
    
    header('location:../index.php');

?>
<?php
}
$session_id=$_SESSION['alogin'];
$session_depart = $_SESSION['arole'];
?>

