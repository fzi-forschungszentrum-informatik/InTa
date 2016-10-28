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
 * Die impressum.php dient zum Anzeigen des Impressums in der mobilen WebApp der Teilnehmer auf ihren Smartphones.
 */
 
 // Bindet die nötigen PHP-Files ein
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Info</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
    <script src="js/app.js" type="text/javascript"></script>
    <script src="js/audienceResponseSystem.js" type="text/javascript"></script>
    

    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />   
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" /> 
</head>

<body>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"></div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">
<center><img src="images/fzi-logo-w.png" height="100"/><p>- Erweiterung von Standardpr&auml;sentationssoftware zur F&ouml;rderung der Publikumsinteraktion -</p><p>Institut f&uuml;r Angewandte Informatik<br/>und Formale Beschreibungsverfahren<br/>des Karlsruher Instituts f&uuml;r Technologie</p><p>Referent: Prof. Dr. Andreas Oberweis<br/>Betreuer: Dipl.-Inform.Wirt Sascha Alpers</p><p>Karlsruhe, den 15.08.2014</p><p>Diese Webapplikation wird auf den Webservern<bt/>des FZI Forschungszentrum Informatik gehostet<br/>Es gilt das <a href="http://www.fzi.de/footer/impressum/" style="color:white; text-decoration:underline;">Impressum</a> des Hauptauftrittes</p><button id="back" class="button white" onclick="javascript:location.href='index.php'">zur&uuml;ck</button></center><!-- Content-End -->
</div>

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>
