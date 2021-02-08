<?php
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
session_start();
echo <<<_INIT
<!doctype html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="theme-color" content="#7952b3">
    <!-- Custom styles for this template -->
    <link href="assets/cover.css" rel="stylesheet">
    <link rel='stylesheet' href='assets/styles.css'>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

_INIT;
require_once 'functions.php';
$userstr = 'Welcome Guest';
if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = true;
    $userstr = "Logged in as: $user";
}
else $loggedin = false;
echo <<<_MAIN
    <title>Star Social</title>
  </head>
  <body class="d-flex h-100 text-center text-white bg-dark">
  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0">Star Social</h3>
          
_MAIN;
if ($loggedin)
{
echo <<<_LOGGEDIN
          <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link active" aria-current="page" href='members.php?view=$user'>Home</a>
            <a class="nav-link" href="members.php">Members</a>
            <a class="nav-link" href="friends.php">Friends</a>
            <a class="nav-link" href="messages.php">Messages</a>
            <a class="nav-link" href="profile.php">Edit Profile</a>
            <a class="nav-link" href="logout.php">Log out</a>
          </nav>
        </div>
      </header>
        
_LOGGEDIN;          
}
else
{
echo <<<_GUEST
          
          <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            <a class="nav-link" href="signup.php">Sign Up</a>
            <a class="nav-link" href="login.php">Login</a>
          </nav>
        </div>
      </header>
    
_GUEST;
}    
?>
          


