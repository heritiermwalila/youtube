<?php require_once('config.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="assets/js/actions.js"></script>
    <title>Youtube Clone</title>
</head>
<body>
    <div id="page-container">
        <div id="head-container">
        <button class="show-hide-nav"><img src="assets/images/icons/menu.png"></button>
        <a href="index.php" class="logo-container"><img src="assets/images/icons/VideoTubeLogo.png" alt="site logo" title="logo"></a>
        <div class="search-container">
            <form action="search.php" method="GET">
                <input type="text" class="search-input" name="term" placeholder="Search...">
                <button class="button search-btn"><img src="assets/images/icons/search.png" alt=""></button>
            </form>
        </div>
        <div class="right-icons-container">
            <a href="upload.php">
                <img src="assets/images/icons/upload.png" alt="">
            </a>
            <a href="upload.php">
                <img src="assets/images/icons/app.png" alt="">
            </a>
            <a href="upload.php">
                <img src="assets/images/icons/forward.png" alt="">
            </a>
            <a href="upload.php">
                <img src="assets/images/icons/avatar.png" alt="">
            </a>
        </div>
        </div>
        <div id="sidebar-container" style="display:none">
        </div>
        <div id="main-body-container">
            <div id="content-container">