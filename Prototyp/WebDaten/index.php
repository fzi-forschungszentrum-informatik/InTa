<?php

/**
 * Copyright (C) 2014 Lorenz Haas
 * Masterthesis
 * - Erweiterung von Standardpräsentationssoftware zur Förderung der Publikumsinteraktion -
 * Institut für Angewandte Informatik
 * und Formale Beschreibungsverfahren
 * des Karlsruher Instituts für Technologie
 *
 * Referent: Prof. Dr. Andreas Oberweis
 * Betreuer: Dipl.-Inform.Wirt Sascha Alpers
 *
 * Karlsruhe, den 15 Juli 2014
 *
 */
 
  /**
 * Quellcode-Beschreibung 
 * Die index.php ist die Startseite für den Teilnehmer auf dem Smartphone. Im Freitextfeld kann der Teilnehmer die jeweilige InteraktionsID eingeben.
 * constant("URL") wird die Server-URL eingebunden und der Nutzer wird zur showTime.php Datei mit der ID in der URL weitergeleitet.
 */
 
 // Bindet die nötigen PHP-Files ein 
 include_once 'includes/db_connect.php';
 include_once 'includes/functions.php';
 include_once 'includes/psl-config.php';
 
 
 // Gibt den HTML Quellcode aus 
 echo '
 <!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="InTa">
    
	<title>InTa - Index</title>
	
	<!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="js/jquery.mobile-1.4.4.min.js" type="text/javascript"></script>
	

    <!-- CSS-Files -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet" /> -->
	<link href="css/fonts_googleapis.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery.mobile-1.4.4.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery.mobile-1.4.4.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" /> 
	
	<!-- non-retina iPhone vor iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon57.png" sizes="57x57">
    <!-- non-retina iPad vor iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon72.png" sizes="72x72">
    <!-- non-retina iPad iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon76.png" sizes="76x76">
    <!-- retina iPhone vor iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon114.png" sizes="114x114">
    <!-- retina iPhone iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon120.png" sizes="120x120">
    <!-- retina iPad vor iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon144.png" sizes="144x144">
    <!-- retina iPad iOS 7 -->
    <link rel="apple-touch-icon" href="images/icon152.png" sizes="152x152">
    <!--Android-->
    <link rel="shortcut icon" href="images/icon196.png" sizes="196x196">
	   
</head>

<body>
<style type="text/css">
body {
  margin: 0;
  font-size: 20px;
  font-family: "Source Sans Pro", helvetica, sans-serif !important;
  font-weight: 200 !important;
  color: #6e6e6e !important;
}
  
h1 
{
	color:white !important;
	text-decoration:none !important;
    font-weight: 400 !important;
	text-shadow:none !important;
}

a
{
	background-color:rgb(73,173,255) !important;
	color:white !important;
	font-family: "Source Sans Pro", helvetica, sans-serif !important;
	border-style:none !important;
	font-weight: 400 !important;
	box-shadow: none !important;
	border-radius: 10px !important;
	text-shadow:none !important;
	text-decoration:none !important;
}

.page
{
	background-color:white
}

.header
{
	background-color:rgb(73,173,255) !important;
}
</style>
<div data-role="page" id="page_one" class="page">
  <div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'">Home</li>
		<li onclick="location.href=\'impressum.php\'">Impressum</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Umfrage</h1>
  </div>

  <div data-role="main" class="ui-content">
    <center>
	<p>Herzlich Willkommen zur Umfrage</p>
    <p>Geben Sie hier bitte die Umfrage-ID ein:</p>
	<form>
    	<input type="text" name="id" id="id">
		<a class="ui-btn ui-btn-inline" data-transition="none" onClick="goto()">weiter</a>
	</form>
	</center>
  </div>
  
</div>
<script>
goto = function()
{
	var id = $("#id").val();
	window.location.href = "https://inta.fzi.de/inta/showTime.php?id="+id;

}
</script>
</body>
</html>';
?>