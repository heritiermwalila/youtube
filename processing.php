<?php 
require_once('includes/header.php'); 
?>
<?php
if(!$_SERVER['REQUEST_METHOD'] === 'POST'){
    echo 'HELLO';
    exit();
}else{
    echo 'Bey';
}
?>
<?php require_once('includes/footer.php'); ?>