<?php

/**
 * Copyright 2014-2016 FZI Forschungszentrum Informatik
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * Contribute by Lorenz Haas
 * Masterthesis
 * - Erweiterung von Standardpräsentationssoftware zur Förderung der Publikumsinteraktion -
 * Institut für Angewandte Informatik
 * und Formale Beschreibungsverfahren
 * des Karlsruher Instituts für Technologie
 *
 * Referent: Prof. Dr. Andreas Oberweis
 * Betreuer: Dipl.-Inform.Wirt Sascha Alpers
 *
 *
 */
 
/**
 * Quellcode-Beschreibung 
 * Die create.php dient zur Erstellung von Interaktionen, dabei werden zunächst aus der Datenbank die vorhandenen
 * Fragetypen geladen. Im HTML-Code wird ein Eingabe-Formular für den Nutzer angezeigt, in dem er Titel, Fragetyp und Passwort (optional) eingeben kann.
 * Die Werte Präsentation, UserID, Datum, Folie und FolienID werden automatisch ausgefüllt. Präsentationstitel, Folie und FolienID wird durch eine Funktion aus der Office-API
 * bestimmt. Je nach Auswahl des Fragetyps, wird aus der Datenbank der Quellcode für den zweiten (Frageeinstellungen) und dritten View (Darstellungseinstellungen) geladen.
 * Die vom Nutzer eingegebenen Daten werden per POST-Methode an setData.php gesendet unter dem code interactions wird der entsprechende SQL Befehl ausgeführt und die Daten
 * für die Interaktion in die Datenbank gespeichert.
 */
 

// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// Startet die PHP-Session
sec_session_start();

// SQL-Query
$sql = 'SELECT * FROM question_types';
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Menu</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
    <script src="js/app.js" type="text/javascript"></script>
    <script src="js/audienceResponseSystem.js" type="text/javascript"></script>

    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" />     
</head>

<body>
<?php
// Überprüft die Login-Daten, falls korrekt wird der nachfolgende Code ausgeführt
if (login_check($mysqli) == true) : 
?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.php'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;"><?php echo htmlentities($_SESSION['username']); ?></div><a href="javascript:;" style="color:white; float:right" onclick="logout()">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a> | <a style="color:white;" href="create.php">Erstellen</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">
<div class="pure-g" id="view_one" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Interaktion</h3>
            <p>Allgemeine Einstellungen:
            </p>
            <form class="pure-form pure-form-aligned">
    		<fieldset>
            <div class="pure-control-group">
                <label for="title">Title</label>
                <input id="title" type="text" placeholder="Umfrage-Titel">
            </div>
            
            <div class="pure-control-group">
                <label for="pollType">Fragetyp</label>
                    <select id="pollType" class="ars-select">
                    	<optgroup label="einzelne Fragetypen">
                    	<?php
						// Ruft die Fragetypen aus der Datenbank ab 
						while($row = $result->fetch_assoc())
						{
							if($row['name']!="MultiQuestionSet")
							{
    						echo '<option>'.$row['name'] . "</option>\n";
							}
							else
							{	
							echo '<optgroup label="gruppierte Fragetypen"><option>'.$row['name'] . "</option></optgroup>\n";
							}
						}?>
                        </optgroup>
                    </select>
            </div>
            
            <div class="pure-control-group">
            	<label for="password">Passwortschutz (optional)</label>
            	<input id="password" type="text" placeholder="Passwort">
        	</div>
    
            <div class="pure-control-group">
                <label for="ptitle">Pr&auml;sentation</label>
                <input id="ptitle" type="text" value="Präsentation 1" disabled>
            </div>
            
            <div class="pure-control-group" style="display:none">
                <label for="userID">UserID</label>
                <input id="userID" type="text" value="<?php echo htmlentities($_SESSION['user_id']); ?>" disabled>
            </div>
            
            <div class="pure-control-group">
                <label for="date">Datum</label>
                <input id="date" type="text" value="Datum" disabled>
            </div>
            
            <div class="pure-control-group">
                <label for="slide">Folie</label>
                <input id="slide" type="text" value="" disabled>
            </div>
            
            <div class="pure-control-group">
                <label for="slideID">FolienID</label>
                <input id="slideID" type="text" value="" disabled>
            </div>
        	</fieldset>
			</form>
			<button class="button blue" style="width:100px;" id="view_one_button" onclick="change_view('view_one_button')">weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <p>In den Allgemeinen Einstellungen, k&ouml;nnen Sie den Titel, den Fragetyp und optional ein Pa&szlig;wort f&uuml;r Ihre Umfrage anlegen.</p>
    <h3>Beispiel</h3>
    <center><p><img src="images/freitext_text.png" height="500"\></p></center>
    </div>
    </div>
</div>

<div class="pure-g" id="view_two" style="display:none; padding-left:15px;">
<!-- Dieser Block wird aus der Datenbank geladen -->
    
<!-- Block Ende -->    
</div>

<div class="pure-g" id="view_three" style="display:none; padding-left:15px;">
<!-- Dieser Block wird aus der Datenbank geladen -->    

<!-- Block Ende -->   
</div>

<div style="display:none; color:grey;" id="view_four">
<center id="message"></center>
</div>

</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->

</div> <!-- Page-End -->

<?php
// SQL-Query 
$sql2 = 'SELECT * FROM question_types';
// Ausführung der Anfrage und Error-Handling
if(!$result2 = $mysqli->query($sql2)){
	
	die('There was an error running the query [' . $mysqli->error . ']');
	

}
echo '
<script>
$(document).ready(function () {
	
	// Erstellt aktuellen Timestamp 
  	var timestamp = new Date();
  	var timestamp_read = timestamp.getTime();
  	$("#date").attr(\'value\',timestamp_read)
  
    // Setzt die Variablen für die Folie und den Präsentationstitel
	var slide = "0";
	var url = "";
	$("#ptitle").attr(\'value\',url);
	$("#slide").attr(\'value\',slide);    
});

function change_view(button)
{
  	
		
  // Navigation: Wechsel zu den unterschiedlichen Formular-Abschnitten 
  if(button == "view_one_button")
  {	
  	$("#view_one").hide();
  	$("#view_two").show();
	showType($("#pollType").val());
  }
  else if (button == "view_two_button")
  {
  	$("#view_two").hide();
  	$("#view_three").show();
  }
  else if (button == "view_two_button_back")
  {
  	$("#view_two").hide();
  	$("#view_one").show();
  }
  else if (button == "view_three_button_back")
  {
  	$("#view_three").hide();
  	$("#view_two").show();
  }
  else if (button == "send")
  {
	  
  	$("#view_three").hide();
	$("#view_four").show();
		
		var slideID = "0";
		// Speichert die eingegebenen Daten aus dem Formular in der Datenbank unter Interaction
		$.post("setData.php",
    	{
		  code: "interactions",
		  userID: $("#userID").val(),
		  title: $("#title").val(),
		  type:$("#pollType").val(),
		  password:$("#password").val(),
		  presentation:$("#ptitle").val(),
		  presentationid: localStorage.getItem("presentation_id"),
		  //presentationid: app.getValue("presentation_id"),
		  date:$("#date").val(),
		  slide:$("#slide").val(),
		  slide_id:slideID,
		  qr_slide:"0",
		  representation_slide: "0",
		  settings: settings,
		  question: $("#question").val(),
		  representationType: $("#representationType").val()
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
		  		$("#message").html(\'Ihre Interaktion wurde gespeichert, eine Auflistung all Ihrer Interaktionen finden Sie im Hauptmen&uuml; unter<a href="overview.php"> &Uuml;bersicht</a>.\'); 				console.log(data);
	  		}
	  		else
	  		{
		  		$("#message").html("Bei der Datenbanksynchronisation trat ein Fehler auf, versuchen Sie diese Aktion zu einem sp&auml;teren Zeitpunkt nochmals.");
	  		};
    	});
  		}
};

// L&auml;dt den jeweiligen Quellcode aus der Datenbank und setzt ihn im HTML Code ein
function showType(type) 
{
  var data = {';
// gibt Anfrage-Ergebnisse aus und speichert es in einem JavasScript Objekt
while($row2 = $result2->fetch_assoc())
	{
    	echo $row2['name']. ":'".utf8_encode(utf8_decode($row2['codeblock_form']))."',";
	}
echo '};
var data2 ={';

// SQL-Query 
$sql3 = 'SELECT * FROM question_types';
// Ausführung der Anfrage und Error-Handling
if(!$result3 = $mysqli->query($sql3)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
// gibt Anfrage-Ergebnisse aus und speichert es in einem JavasScript Objekt
while($row3 = $result3->fetch_assoc())
	{
    	echo $row3['name']. ":'".utf8_encode(utf8_decode($row3['codeblock_display']))."',";
	}
echo '};
$("#view_two").html(data[type]);	
$("#view_three").html(data2[type]);
	
}</script>';
// Beendet die Datenbankverbindung
$stmt->close();
$mysqli->close();
?>

<?php 
// Wird Ausgeführt falls der Login nicht korrekt war
else : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"></div>

<!-- Content-Start -->
<div id="content">
<center>Sie haben nicht die Berechtigung f&uuml;r diese Seite.<br/>Loggen Sie sich bitte zuerst <a onClick="logout();">hier</a> ein.</center>
</div>

<!-- Footer-Start -->
<div id="footer"><div id="console" style="color:black; float:left"></div><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></div>
</div> <!-- Page-End -->
<script>
$(document).ready(function () 
{
	javascript:location.href='login.php';
})
</script>
<?php endif; ?>
</body>
</html>