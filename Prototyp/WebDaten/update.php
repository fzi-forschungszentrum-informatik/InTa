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
 * Die update.php dient zum bearbeiten der interaktionen. Es werden zunächst die Infos aus der Datenbank geladen und in die Formularfelder kopiert. Diese
 * können vom Nutzer bearbeitet werden. Danach kann er diese abschicken und die neuen Werte werden in die Datenbank geschrieben über die POST Methode in setData.php
 * mit dem code update.
 */

// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// Startet die Session
sec_session_start();
// SQL-Query
$stmt = $mysqli->prepare("SELECT title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide FROM interactions WHERE id = ?");
// Bindet die id ein
$stmt->bind_param('i', $_GET["id"]);
$stmt->execute();
$stmt->store_result();
// Speichert die Ergebnisse der Abfrage in die Variablen
$stmt->bind_result($title, $type, $user_id, $password, $presentation, $presentation_id, $date, $slide, $slideID, $question, $settings, $representation_type, $qr_slide, $representation_slide);
$stmt->fetch();
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
<?php if (login_check($mysqli) == true) : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"><div id="user_id" style="display:none"><?php echo htmlentities($_SESSION['user_id']); ?></div><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.html'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;"><?php echo htmlentities($_SESSION['username']); ?></div><a href="javascript:;" style="color:white; float:right" onclick="logout()">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a> | <a style="color:white;" href="overview.php">&Uuml;berblick</a> | <a style="color:white;" href="update.php?id=<?php echo $_GET["id"]; ?>">Bearbeiten</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">
<div class="pure-g" id="view_one" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Interaktion ID <?php echo $_GET["id"]; ?></h3>
            <?php 
			
            echo '<form class="pure-form pure-form-aligned">
    		<fieldset>
            <div class="pure-control-group">
                <label for="title">Title</label>
                <input id="title" type="text" value="'.$title.'">
            </div>
			
			<div class="pure-control-group">
                <label for="type">Typ</label>
                <input id="type" type="text" value="'.$type.'" readonly>
            </div>
			
			<div class="pure-control-group">
                <label for="userid">Nutzer-ID</label>
                <input id="userid" type="text" value="'.$user_id.'" readonly>
            </div>
			
			<div class="pure-control-group">
                <label for="password">Password</label>
                <input id="password" type="text" value="'.$password.'">
            </div>
			
			<div class="pure-control-group">
                <label for="presentation">Präsentation</label>
                <input id="presentation" type="text" value="'.$presentation.'">
            </div>
			
			<div class="pure-control-group">
                <label for="presentation_id">Präsentations-ID</label>
                <input id="presentation_id" type="text" value="'.$presentation_id.'" readonly>
            </div>
			
			<div class="pure-control-group">
                <label for="date">Datum</label>
                <input id="date" type="text" value="'.$date.'" readonly>
            </div>
            
            
        	</fieldset>
			</form>';
			?>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    		<h3 style="visibility:hidden">Part 2</h3>
    		<?php 
			echo '<form class="pure-form pure-form-aligned">
    		<fieldset>
            <div class="pure-control-group">
                <label for="slide">Slide</label>
                <input id="slide" type="text" value="'.$slide.'">
            </div>
			
			<div class="pure-control-group">
                <label for="slideID">Slide-ID</label>
                <input id="slideID" type="text" value="'.$slideID.'" readonly>
            </div>
			
			<div class="pure-control-group">
                <label for="question">Frage</label>
                <input id="question" type="text" value="'.$question.'">
            </div>
			
			<div class="pure-control-group">
                <label for="settings">Einstellungen</label>
                <input id="settings" type="text" value=\''.$settings.'\'>
            </div>
			
			<div class="pure-control-group">
                <label for="representation_type">Präsentations-Typ</label>
                <input id="representation_type" type="text" value="'.$representation_type.'">
            </div>
			
			<div class="pure-control-group">
                <label for="qr_slide">QR-Slide</label>
                <input id="qr_slide" type="text" value="'.$qr_slide.'">
            </div>
			
			<div class="pure-control-group">
                <label for="representation_slide">Graph-Slide</label>
                <input id="representation_slide" type="text" value="'.$representation_slide.'">
            </div>
            
            
        	</fieldset>
			</form>';
			?>
    		<button class="button blue" style="width:300px;" onclick="update_i()">&Auml;nderungen speichern</button>
    </div>
    </div>
</div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->
</div> <!-- Page-End -->
<script>
update_i = function ()
{
var $_GET = {};
	document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
        return decodeURIComponent(s.split("+").join(" "));
    }
    $_GET[decode(arguments[1])] = decode(arguments[2]);
	});
		
// Ändert die eingegebenen Daten aus dem Formular in der Datenbank für die jeweilige Interaction
		$.post("setData.php",
    	{
		  code: "update",
		  interactionID: $_GET["id"],
		  userID: $("#userid").val(),
		  title: $("#title").val(),
		  type:$("#type").val(),
		  password:$("#password").val(),
		  presentation:$("#presentation").val(),
		  presentationid: $("#presentation_id").val(),
		  date:$("#date").val(),
		  slide:$("#slide").val(),
		  slide_id:$("#slide_id").val(),
		  qr_slide:$("#qr_slide").val(),
		  representation_slide: $("#representation_slide").val(),
		  settings: $("#settings").val(),
		  question: $("#question").val(),
		  representationType: $("#representation_type").val()
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
		  		$("#content").html("Ihre Interaktion wurde gespeichert, eine Auflistung all Ihrer Interaktionen finden Sie im Hauptmenu unter<a href='overview.php'> &Uuml;bersicht</a>.");
	  		}
	  		else
	  		{
		  		$("#content").html("Bei der Datenbanksynchronisation trat ein Fehler auf, versuchen Sie diese Aktion zu einem sp&auml;teren Zeitpunkt nochmals.");
	  		};
    	});
}
</script>
<?php else : ?>
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