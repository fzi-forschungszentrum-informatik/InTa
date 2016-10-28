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
 * Die error.php dient dazu dem Nutzer anzuzeigen, dass beim Login ein Fehler auftrat. Er wird dann auf die login.php Seite verwiesen.
 */ 
 
// Falls ein Fehler auftritt 
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (! $error) {
    $error = 'Fehler: Es trat ein unbekannter Fehler auf, versuchen Sie Ihre Aktion zu einem sp&auml;teren Zeitpunkt nochmals..';
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-LoginFail</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
    <script src="js/app.js" type="text/javascript"></script>

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
<center><p style="padding-top:50px;" id="infoText"><?php echo $error; ?><p>Versuchen Sie bitte Ihre Anfrage <a style="color:white" href="login.php">hier</a> erneut.</p></center>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>