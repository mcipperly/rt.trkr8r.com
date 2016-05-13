<?php session_start(); 
if(isset($_SESSION['lastact']) && (time() - $_SESSION['lastact']) > 43200) {
  $_SESSION['lastact'] = time();
  Header("HTTP/1.1 302 Moved Temporarily");
  Header("Location: /admin/logout.php");
} else {
  $_SESSION['lastact'] = time();
} ?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title><?php print($site_org) ?> | Volunteer Registration</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" media="screen">
    <link rel="stylesheet" href="/assets/css/global-style.css" media="screen">
    <link rel="stylesheet" href="/assets/css/user-facing-style.css" media="screen">
    <link rel="stylesheet" href="/assets/css/print-style.css" media="print">
    <link rel="icon" type="image/png" href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_Favicon.png">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_HiRes.png" rel="apple-touch-icon">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_AppleTouch_76x76.png" rel="apple-touch-icon" sizes="76x76">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_AppleTouch_120x120.png" rel="apple-touch-icon" sizes="120x120">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_AppleTouch_152x152.png" rel="apple-touch-icon" sizes="152x152">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_AppleTouch_180x180.png" rel="apple-touch-icon" sizes="180x180">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_HiRes.png" rel="icon" sizes="192x192">
    <link href="<?php $_SERVER['SERVER_NAME'];?>/assets/imgs/PaperOut_Normal.png" rel="icon" sizes="128x128">

    <!--[if lt IE 9]>
            <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>  
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script src="//use.fontawesome.com/e1c94424d2.js"></script>

    <script src="/assets/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-plain';</script>

</head>

<body>
    <div class="container">
