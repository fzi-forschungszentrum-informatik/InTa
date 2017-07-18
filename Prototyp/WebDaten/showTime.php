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
 * Die shwoTime.php dient zum anzeigen der Fragen auf den mobilen Endgeräten. Hier werden zunächst die Daten der Interaktion aus der Datenbank
 * geladen und anschließend den Code-Block für den jeweiligen Fragetyp. Die unterschiedlichen jQuery mobile Pages zeigen die Willkommensseite,
 * falls Passwort aktiviert, die Passwortseite und die eigentliche Frageseite an. Duchr die checkPasswort Funktion wird
 * das eingegebene Passwort überprüft. Nach eingabe der Antworten werden diese über die sendAnswer Funktion
 * über die POST Methode an setData gesendet und dort durch die jeweilige SQL-Query in die Datenbank gespeichert.
 * Es werden noch weitere Daten wie IP und Hostname in der Datenbank gespeichert.
 */

// Bindet die db_connect.php ein zum Aufbau der Datenbankverbindung
include_once 'includes/db_connect.php';

// SQL-Query
$stmt = $mysqli->prepare("SELECT type, question, title, password, settings  FROM interactions WHERE id = ? LIMIT 1");
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $interaction_id);
// Holt sich die in der URL mitgelieferte id und speichert sie in einer Variablen
$interaction_id = $_GET["id"];
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();

// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($type, $question, $title, $password, $settings);
$stmt->fetch();

// SQL-Query
$stmt = $mysqli->prepare("SELECT codeblock_mobile FROM question_types WHERE name = ? LIMIT 1");
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $type);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();

// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($codeblock_mobile);
$stmt->fetch();

$ip = $_SERVER['REMOTE_ADDR'];
$hostname = gethostbyaddr($ip);

echo '
<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>'; 
// Gibt den Titel aus
echo $title  .  
	'</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="js/jquery.mobile-1.4.5.min.js" type="text/javascript"></script>
	

    <!-- CSS-Files -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet" /> -->
	<link href="css/fonts_googleapis.css" rel="stylesheet" type="text/css" />
	<link href="css/jquery.mobile-1.4.5.min.css" rel="stylesheet" type="text/css" />
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
</style>
';
if ($password == NULL)
{
	echo '<div data-role="page" id="page_one" class="page">
	
	<div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Umfrage</h1>
  </div>

  <div data-role="main" class="ui-content">
    <center>';
if ($codeblock_mobile == NULL) {
        echo('ID nicht gefunden. <br>');
        echo('<a class="ui-btn ui-btn-inline" onclick="location.href=\'\index.php\'">Zurück</a>');
} else {
echo ('	<p>Herzlich Willkommen zur Umfrage</p>
	<a class="ui-btn ui-btn-inline" data-transition="none" href="#page_two">weiter</a>');
}
echo('
	</center>
  </div>

</div>');
}
else
{
	echo '<div data-role="page" id="page_one" class="page">
	
	<div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Passwort</h1>
  </div>

  <div data-role="main" class="ui-content">
    <center>
	<p>Die Umfrage ist Passwortgesch&uuml;tzt, geben Sie bitte das Passwort ein:</p>
	<p id="pwrong" style="color:red"></p>
	<form>
		<input type="password" name="password" id="password">
		<a class="ui-btn ui-btn-inline" data-transition="none" onClick="checkPassword()">senden</a>
	</form>
	</center>
  </div>

</div>';
}





echo '
<div data-role="page" id="page_two" class="page">

  <div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>'; 
// Gibt den Titel aus
echo $title  .  

'</h1>
</div>

  <div data-role="main" class="ui-content">
    <center id="message">
	<p style="padding-bottom:50px;">'; 
// Gibt die Frage aus
echo $question  . 
'</p>'; 
// Gibt den Quellcode für die Anzeige des jeweiligen Fragetyps aus
echo $codeblock_mobile .'

sendAnswer = function(type)
{
	console.log($("#answer").val());
	var timestamp = new Date();
  	var timestamp_read = timestamp.getTime();

 	var $_GET = {};
	document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }
    $_GET[decode(arguments[1])] = decode(arguments[2]);
	});
	
	if((localStorage.getItem("send"+$_GET["id"])=="true") && (settings["only_one_answer"] == "true"))
	{
		parent.location.href = "#page_six";
		location.reload();
	}
	else
	{	
	
	 $.post("setData.php",
  {
	  	  id: $_GET["id"],
		  code: "answers",		  
		  answer: $("#answer").val(),
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
          usrinfo: "",

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
		  localStorage.setItem("send"+$_GET["id"],"true");
		  if(settings["only_one_answer"] == "true")
		  {
			parent.location.href = "#page_five";
			location.reload();
		  }
		  else
		  {
		  parent.location.href = "#page_four";
		  location.reload();
		  }
	  }
	  else
	  {
		  console.log("Es trat ein Fehler auf, starten Sie diese Aktion bitte zu einem sp&auml;teren Zeitpunkt nochmals.");
	  };
	  
	  });

	}
}
</script>




</center>
  </div>

</div>
<div data-role="page" id="info" class="page">
  <div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Information</h1>
</div>

  <div data-role="main" class="ui-content">
    <center>
	<p>
- Erweiterung von Standardpr&auml;sentationssoftware zur F&ouml;rderung der Publikumsinteraktion -<br />
Institut für Angewandte Informatik<br />
und Formale Beschreibungsverfahren<br />
des Karlsruher Instituts für Technologie<br /><br />

Referent: Prof. Dr. Andreas Oberweis<br />
Betreuer: Dipl.-Inform.Wirt Sascha Alpers<br /><br /></p><br />
<p><a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zurück</a></p>
	</center>
	
  </div>

</div>

<div data-role="page" id="page_four" class="page">
  <div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Information</h1>
</div>

  <div data-role="main" class="ui-content">
    <center>
	<p>
	Ihre Antwort wurde gesendet!<br \> (Sie k&ouml;nnen weitere Antworten einreichen, wenn Sie m&ouml;chten.)</p>
	<p><a href="#" class="ui-btn ui-btn-inline" data-transition="none" data-rel="back">zurück</a></p>
	</center>
  </div>

</div>

<div data-role="page" id="page_five" class="page">
  <div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Information</h1>
</div>

  <div data-role="main" class="ui-content">
    <center>
	<p>
	Ihre Antwort wurde gesendet!<br \> (Sie k&ouml;nnen nur eine Antwort senden)</p>
	</center>
  </div>

</div>

<div data-role="page" id="page_six" class="page">
  <div data-role="panel" id="mypanel">
    <or data-role="listview">
		<li onclick="location.href=\'#page_one\'; location.reload();">Home</li>
		<li onclick="location.href=\'\index.php\'">ID-Eingabe</li>
		<li onclick="location.href=\'#info\'; location.reload();">Info</li>
    </or>
	</div><!-- /panel -->
	
  <div data-role="header" class="header">
  <a href="#mypanel"><i class="fa fa-bars fa-2x"></i></a>
  <h1>Information</h1>
</div>

  <div data-role="main" class="ui-content">
    <center>
	<p>Sie k&ouml;nnen keine weiteren Antworten senden.</p>
	</center>
  </div>

</div>

<script>
var password;
var settings = jQuery.parseJSON(\' '; 
// Schreibt die Settings in ein JavaScript Objekt
echo $settings  . 
' \');

checkPassword = function()
{
	var $_GET = {};
	document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }
    $_GET[decode(arguments[1])] = decode(arguments[2]);
});

	$.post("getData.php",
    {
		  code: "password",
		  id: $_GET["id"],
		  password:  $("#password").val()
    },function(data,status)
		 {
      		if (status == "success")
	  		{
				if(data == "true")
				{
					parent.location.href = "#page_two";
					location.reload();
					
				}
				else
				{
					$("#pwrong").html("Passwort war falsch, versuchen Sie es erneut!");
				}
	  		}
    	});
}
</script>
</body>
</html>';
?>
