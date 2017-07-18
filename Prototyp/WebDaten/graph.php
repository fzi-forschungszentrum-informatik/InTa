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
 * Die graph.php dient zum Anzeigen der Interaktionsergebnisse. Zunächst wird der Darstellungstyp und die Frage aus der Datenbank abgerufen, sowie der Quellcode für die Darstellung.
 * Diese werden per PHP in den HTML-Code eingebaut und dargestellt.
 */
 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

$preview = $_GET["preview"];
$source = $_GET["source"];
$interaction_id = $_GET["interaction_id"];

// SQL-Query
$stmt = $mysqli->prepare("SELECT representation_type, question  FROM interactions WHERE id = ? LIMIT 1");
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $interaction_id);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($type, $question);
$stmt->fetch();


// SQL-Query
$stmt = $mysqli->prepare("SELECT codeblock_representation_type FROM representation_types WHERE name = ? LIMIT 1");
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $type);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();

// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($codeblock_representation_type);
$stmt->fetch();

// Schreibt den HTML Quellcode
echo '
<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Question</title>
    
    <!-- JavaScript-Files -->
    <!-- <script src="js/jquery-1.9.1.js" type="text/javascript"></script> -->
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
	<!--
    <script src="http://code.jquery.com/jquery.tagcloud.js"></script>
	<script src="http://code.jquery.com/jquery.circliful.js"></script>
	<script src="http://code.jquery.com/jquery.highcharts.js"></script>
	<script src="http://code.jquery.com/jquery.dataTables.js"></script>	
	-->
	<script src="js/jquery.tagcloud.js" type="text/javascript"></script>
	<script src="js/jquery.circliful.js" type="text/javascript"></script>
	<script src="js/highcharts.js" type="text/javascript"></script>
	<script src="js/jquery.dataTables.js" type="text/javascript"></script>
	

    <!-- CSS-Files -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet" />
	<link href="css/fonts_googleapis.css" rel="stylesheet" type="text/css" />
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery.circliful.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css" />   
</head>

<body>
<style type="text/css">
#question {
  padding-top: 15px;
  font-size: 20px;
  font-family: "Source Sans Pro", helvetica, sans-serif !important;
  font-weight: 200 !important;
  color: #6e6e6e !important;
}
</style>
<!-- Page-Start -->
<div id="page">
<center id="question">'.$question.'</center>
<script>var interaction_id = "'; 
// Gibt die ID aus
echo utf8_encode($interaction_id)  . 
'";
</script>
';

if($preview == true){echo '<a href="javascript:;"><h1 id="x" style="color:grey; float:right; padding-right: 30px; font-weight:lighter;" onclick="javascript:location.href=\''.$source.'.php\'">X</h1></a>';};

// Gibt den Quellcode für die Anzeige des jeweiligen Anzeigetyps aus
echo utf8_encode($codeblock_representation_type) .'
	
</div> <!-- Page-End -->
</body>
</html>';
?>
