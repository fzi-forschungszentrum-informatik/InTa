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
 * Die evaluation2.php dient zur Anzeige der Evaluationsfragen, die dem Nutzer auf dem Smartphone angezeigt werden.
 * Die Fragen sind jeweils auf einer eigenen jQuery Mobile Page, zwischen denen der Nutzer hin und her springen kann (durch id=page gekennzeichnet). 
 * Die in den jeweiligen Formularfelder eingegebenen Antworten werden abgerufen, sowie Nutzerdaten (IP, HOST) und per POST Methode an die setData.php Datei gesendet mit
 * dem code answers. Diese werden in der setData.php Datei per SQL-Query in die Datenbank gespeichert.
 */

// Bindet die db_connect.php ein zum Aufbau der Datenbankverbindung
include_once 'includes/db_connect.php';

// Holt sich die IP, den HOSTNAME und die InteractionID
$ip = $_SERVER['REMOTE_ADDR'];
$hostname = gethostbyaddr($ip);
$interaction_id = $_GET["id"];

echo '
<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Evaluation</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="js/jquery.mobile-1.4.4.min.js" type="text/javascript"></script>
	

    <!-- CSS-Files -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet" /> -->
	<link href="css/fonts_googleapis.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery.mobile-1.4.4.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" />    
	 
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
</style>';
echo '
<div data-role="page" id="page1" class="page">

  <div data-role="header" class="header">
  <h1>Evaluation</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Herzlich Willkommen zur Umfrage</p>
  <a href="#page2" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page2" class="page">

  <div data-role="header" class="header">
  <h1>Block 1: Anwendung (Frage 1 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Die App hat tadellos funktioniert.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer1" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page3" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page3" class="page">

  <div data-role="header" class="header">
  <h1>Block 1: Anwendung (Frage 2 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Die Funktionalit&auml;t der App ist ausreichend.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer2" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page4" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page4" class="page">

  <div data-role="header" class="header">
  <h1>Block 1: Anwendung (Frage 3 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Die Bedienung der App ist einfach und intuitiv.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer3" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page5" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page5" class="page">

  <div data-role="header" class="header">
  <h1>Block 1: Anwendung (Frage 4 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Die Gestaltung der App ist ansprechend.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer4" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page6" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page6" class="page">

  <div data-role="header" class="header">
  <h1>Block 1: Anwendung (Frage 5 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Die Darstellung der Ergebnisse in der Pr&auml;sentation sind ansprechend.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer5" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page7" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page7" class="page">

  <div data-role="header" class="header">
  <h1>Block 2: Audience Response Systeme (Frage 6 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Ich halte ein solches System f&uuml;r sinnvoll</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer6" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page8" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page8" class="page">

  <div data-role="header" class="header">
  <h1>Block 2: Audience Response Systeme (Frage 7 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Ein solches System ist mir vertraut.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer7" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page9" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page9" class="page">

  <div data-role="header" class="header">
  <h1>Block 2: Audience Response Systeme (Frage 8 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Ein solches System ist f&uuml;r Workshops/Gruppenarbeit geeignet.</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer8" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page10" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page10" class="page">

  <div data-role="header" class="header">
  <h1>Block 2: Audience Response Systeme (Frage 9 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Ein solches System f&ouml;rdert die Interaktion</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer9" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page11" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page11" class="page">

  <div data-role="header" class="header">
  <h1>Block 2: Audience Response Systeme (Frage 10 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Bitte bewerten Sie die folgenden Aussagen:</p><br \>
  <p>Ein solches System f&ouml;rdert das Interesse</p>
  <form id="form"><label for="slider">(Skala von 0 trifft &uuml;berhaupt nicht zu bis 10 trifft voll und ganz zu)</label>
  <input type="range" name="slider" id="answer10" value="5" min="0" max="10" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page12" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>';

echo '
<div data-role="page" id="page12" class="page">

  <div data-role="header" class="header">
  <h1>Block 3: Kartenabfrage (Frage 11 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Was sind die St&auml;rken/Schw&auml;chen der papierbasierten Variante</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer11" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page13" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page13" class="page">

  <div data-role="header" class="header">
  <h1>Block 3: Kartenabfrage (Frage 12 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Was sind die St&auml;rken/Schw&auml;chen der digitalen Variante</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer12" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page14" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page14" class="page">

  <div data-role="header" class="header">
  <h1>Block 3: Kartenabfrage (Frage 13 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Welches der beiden Varianten w&uuml;rden Sie bevorzugen und warum?</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer13" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page15" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page15" class="page">

  <div data-role="header" class="header">
  <h1>Block 3: Kartenabfrage (Frage 14 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Welches der beiden Varianten liefert bessere Ergebnisse und warum?</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer14" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page16" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page16" class="page">

  <div data-role="header" class="header">
  <h1>Block 3: Kartenabfrage (Frage 15 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Welches der beiden Varianten l&auml;sst sich schneller durchf&uuml;hren und warum?</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer15" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page17" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page17" class="page">

  <div data-role="header" class="header">
  <h1>Block 4: Allgemein (Frage 16 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Falls ein Fehler auftrat, beschreiben Sie diesen kurz.</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer16" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page18" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page18" class="page">

  <div data-role="header" class="header">
  <h1>Block 4: Allgemein (Frage 17 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Was hat Ihnen an der Anwendung besonders gut gefallen?</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer17" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page19" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page19" class="page">

  <div data-role="header" class="header">
  <h1>Block 4: Allgemein (Frage 18 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Was w&uuml;rden Sie an der Anwendung verbessern?</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer18" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page20" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page20" class="page">

  <div data-role="header" class="header">
  <h1>Block 4: Allgemein (Frage 19 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Wo sehen Sie weitere Anwendungsm&ouml;glichkeiten f&uuml;r die Anwendung?</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer19" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a href="#page21" class="ui-btn ui-btn-inline" data-transition="none">weiter</a>
  </center>
  </div>

</div>

<div data-role="page" id="page21" class="page">

  <div data-role="header" class="header">
  <h1>Block 4: Allgemein (Frage 20 / 20)</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Sonstige Kommentare</p>
  <form id="form"><label for="slider"></label>
  <input type="text" name="text" id="answer20" placeholder="Ihre Antwort" /></form>
  <a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a><a type="button" class="ui-btn ui-btn-inline" onclick="sendAnswer()" value="senden">senden</a>
  </center>
  </div>

</div>

<div data-role="page" id="ende" class="page">

  <div data-role="header" class="header">
  <h1>Ende</h1>
  <a href="#info"><i class="fa fa-bars fa-2x"></i></a>
  </div>
	
  <div data-role="main" class="ui-content">
  <center><p>Vielen Dank f&uuml;r Ihre Teilnahme an dieser Evaluation!</p>
  </center>
  </div>

</div>




<div data-role="page" id="info" class="page">
  
  <div data-role="header" class="header">
  <h1>Information</h1>
  </div>

  <div data-role="main" class="ui-content">
    <center>
	<p>
- Erweiterung von Standardpr&auml;sentationssoftware zur F&ouml;rderung der Publikumsinteraktion -<br />
Institut f&uuml;r Angewandte Informatik<br />
und Formale Beschreibungsverfahren<br />
des Karlsruher Instituts f&uuml;r Technologie<br /><br />

Referent: Prof. Dr. Andreas Oberweis<br />
Betreuer: Dipl.-Inform.Wirt Sascha Alpers<br /><br /></p><br />
<p><a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zur&uuml;ck</a></p>
	</center>
  </div>

</div>

<script>
sendAnswer = function(type)
{
	var answer = \'q1:\'+$("#answer1").val()+\'q2:\'+$("#answer2").val()+\'q3:\'+$("#answer3").val()+\'q4:\'+$("#answer4").val()+\'q5:\'+$("#answer5").val()+\'q6:\'+$("#answer6").val()+\'q7:\'+$("#answer7").val()+\'q8:\'+$("#answer8").val()+\'q9:\'+$("#answer9").val()+\'q10:\'+$("#answer10").val()+\'q11:\'+$("#answer11").val()+\'q12:\'+$("#answer12").val()+\'q13:\'+$("#answer13").val()+\'q14:\'+$("#answer14").val()+\'q15:\'+$("#answer15").val()+\'q16:\'+$("#answer16").val()+\'q17:\'+$("#answer17").val()+\'q18:\'+$("#answer18").val()+\'q19:\'+$("#answer19").val()+\'q20:\'+$("#answer20").val();
	
	console.log(answer);
	var timestamp = new Date();
  	var timestamp_read = timestamp.toLocaleDateString() + " " +timestamp.toLocaleTimeString();
	
	var pseudoip="";
	var track="";
	pseudoip = localStorage.getItem("pseudoip");
	console.log(pseudoip);
	if ((pseudoip === null) || (pseudoip == "") || (typeof pseudoip == "undefined"))
	{
		pseudoip = timestamp_read+"r:"+Math.random();
		localStorage.setItem("pseudoip", pseudoip);
		console.log(localStorage.getItem("pseudoip"));
	}
	else
	{track = pseudoip;}

 	var $_GET = {};
	document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }
    $_GET[decode(arguments[1])] = decode(arguments[2]);
	});
	
	 $.post("setData.php",
  	{
	  	  id:'; echo $interaction_id.',
		  code: "answers",		  
		  answer: answer,
		  ip: "'; 
// Gibt die IP Adresse aus
echo $_SERVER['REMOTE_ADDR']  .  

'",
		  os: "'; 
// Gibt das OS aus
$agent = $_SERVER['HTTP_USER_AGENT'];

if(preg_match('/Linux/',$agent)) $os = 'Linux';
elseif(preg_match('/Win/',$agent)) $os = 'Windows';
elseif(preg_match('/Mac/',$agent)) $os = 'Mac';
else $os = 'UnKnown';
echo $os  .  

'",
          usrinfo: track,

		  hostname: "';
// Gibt die hostname aus
echo $hostname.
'",
          country: "'; 
// Gibt die Sprache aus
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
echo $lang  .  

'",
          date: timestamp_read
	  
  },function(data,status){
	  if (status == "success")
	  {
		  console.log("Ihre Antwort wurde gespeichert.");
		  parent.location.href = "#ende";
	  }
	  else
	  {
		  console.log("Es trat ein Fehler auf, starten Sie diese Aktion bitte zu einem sp&auml;teren Zeitpunkt nochmals.");
	  };
	  
	  });
}
</script>

</body>
</html>';
?>