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
 * Die qr.php dient zum Anzeigen des Interaktions QR-Codes und der SHORT-URL. Zunächst wird die Frage aus der Datenbank 
 * abgerufen. Durch das jquery-qrcode Framework wird der QR-Code aus dem Link und der InteraktionsID erstellt und angezeigt. In der document(ready) Funktion sind die Eigen-
 * schaften des QR Code hinterlegt.
 */

// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/psl-config.php';

// Holt die GET-Variablen
$preview = $_GET["preview"];
$source = $_GET["source"];
// SQL-Query
$stmt = $mysqli->prepare("SELECT question  FROM interactions WHERE id = ? LIMIT 1");
// Bindet die interaction_id ein
$stmt->bind_param('s', $interaction_id);
$interaction_id = $_GET["interaction_id"];
$stmt->execute();
$stmt->store_result();

// Schreibt die Ergebnisse
$stmt->bind_result($question);
$stmt->fetch();
// Gibt den HTML-Code aus
echo '
<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>AudienceResponseSystem-QRCode</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
    <!-- <script src="js/office.js" type="text/javascript"></script> -->
	<script src="js/jquery.qrcode-0.11.0.js" type="text/javascript"></script>

	
    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" />     
</head>

<body>
<!-- Page-Start -->
<div id="page">';
if($preview == true){echo '<a href="javascript:;"><h1 id="x" style="color:grey; float:right; padding-right: 30px; font-weight:lighter;" onclick="javascript:location.href=\''.$source.'.php\'">X</h1></a>';};

echo '
	<center>
	<h1><b>'.$question.'</b></h1>
	<div id="qr" style="padding-top:20px"></div>
	<h1 id="link">Link: <b>';
	echo constant("URL").'</b>  <br \><br \>Umfrage-ID: <b>'.$interaction_id.'</b><br \><br \><a class="fa fa-bar-chart-o fa-lg" style="padding-left:10px;" onClick="parent.location.href =\''. "graph.php?source=overview&preview=true&interaction_id=".$interaction_id.'\'"></a></h1>
    </center>
</div> <!-- Page-End -->

</body>
<script>
$(document).ready(function () 
{		
  $("#qr").qrcode({
    "render": "div",
	"size": 400,
    "width": 200,
    "height": 200,
    "color": "#3a3",
    "text": "';
	
	//echo 'https://inta.fzi.de/inta/showTime.php?id='.$interaction_id.'"
	echo base_url() . 'showTime.php?id=' . $interaction_id.'"
});
});
</script>
</html>'
?>
