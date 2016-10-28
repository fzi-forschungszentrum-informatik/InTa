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
 * Die overview.php zeigt die vom Nutzer angelegten Interaktionen an. Es werden zunächst sämtliche für die NutzerID hinterlegten Interaktionen aus der Datenbank
 * geladen und in die Tabelle geschrieben. In der letzten Spalte der Tabelle sind die möglichen Aktionen gespeichert. Diese rufen Funktionen der audienceResponseSystem.js auf
 * Darunter z.B. die Office API zum abrufen der aktuellen FolienID.
 */

// Setzt die Zeitzone auf Europa/Berlin
date_default_timezone_set('Europe/Berlin'); 
// Bindet die nötigen PHP-Files ein
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// Startet die PHP-Session
sec_session_start();

// SQL-Query
$stmt = $mysqli->prepare("SELECT id, title, type, presentation, date, slide, slide_id, presentation_id, question, representation_type, qr_slide, representation_slide FROM interactions WHERE user_id = ?");
// Bindet die user_id ein
$stmt->bind_param('i', $_SESSION['user_id']);
// Führt die SQL Anfrage aus
$stmt->execute();
$stmt->store_result();
// Speichert die Ergebnisse
$stmt->bind_result($id, $title, $type, $presentation, $date, $slide, $slideID, $presentation_id, $question, $representation_type, $qr_slide, $representation_slide);
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
    <script src="js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="js/MicrosoftAjax.js" type="text/javascript"></script>
	
    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css" />     
</head>

<body>
<?php if (login_check($mysqli) == true) : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"><div id="user_id" style="display:none"><?php echo htmlentities($_SESSION['user_id']); ?></div><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.php'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;"><?php echo htmlentities($_SESSION['username']); ?></div><a href="javascript:;" style="color:white; float:right" onclick="logout()">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a> | <a style="color:white;" href="overview.php">&Uuml;berblick</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="message"></div>
<div id="content" style="overflow-y: auto;">
<center>
<table id="table" class="display">
    <thead>
        <tr>
            <th>I. ID</th>
            <!-- <th>P. ID</th> -->
            <th>Titel</th>
            <th>Frage</th>
            <th>Typ</th>
            <th>Darstellung</th>
            <th>Datum</th>
            <!-- <th>QR</th> -->
            <!-- <th>Graph</th> -->
           <th>Aktionen</th>
        </tr>
    </thead>

    <tbody>
<?php 
while($stmt->fetch())
	{
    //Schreibt die Interaction-Daten in die Tabelle
	echo 
	'<tr id="interaction'.$slideID.'"><td>'.$id.'</td>
	<!-- <td id="presentation_id'.$presentation_id.'">'.$presentation_id.'</td> -->
	<td>';if(strlen($title) > 15){echo $title = substr($title,0,15)."...";}else{echo $title;};echo'</td>
	<td>';if(strlen($question) > 15){echo $question = substr($question,0,15)."...?";}else{echo $question;};echo'</td>
	<td>'.$type.'</td><td>'.$representation_type.'</td><td>'.date('r', $date/1000).'</td>
	<!-- <td id="qr_'.$qr_slide.'" onclick="setZeroQR(\''.$qr_slide.'\',\''.$id.'\')">'.$qr_slide.'</td> -->
	<!-- <td id="graph_'.$representation_slide.'" onclick="setZeroGraph(\''.$representation_slide.'\',\''.$id.'\')">'.$representation_slide.'</td> -->
	<td>
	<a href="javascript:;">
	<i style="padding-left:10px" class="fa fa-trash fa-lg" onclick="delete_interaction('.$id.')" title="Interaktion löschen" alt="Interaktion löschen"></i>
	</a>
	<a href="javascript:;">
	<i class="fa fa-edit fa-lg" style="padding-left:10px" 
	onclick="update_interaction('.$id.')" title="Interaktion bearbeiten" alt="Interaktion bearbeiten"></i>
	</a>
	
	<a href="javascript:;">
	<i class="fa fa-file-text-o fa-lg" style="padding-left:10px" 
	onclick="location.href=\'showData.php?id='.$id.'\'" title="Statistiken" alt="Statistiken"></i>
		</a>
		
	<a href="javascript:;">
	<i class="fa fa-qrcode fa-lg" style="padding-left:10px"
	onclick="location.href=\'qr.php?interaction_id='.$id.'\'" title="QR zuweisen" alt="QR zuweisen"></i>
	</a>
	
	<a href="javascript:;">
	<i class="fa fa-bar-chart-o fa-lg" style="padding-left:10px;" 
	onclick="location.href=\'graph.php?interaction_id='.$id.'\'" title="Graph zuweisen" alt="Graph zuweisen" id="mode_graph'.$id.'"></i></a></td></tr>';  
    //echo '<tr id="interaction'.$slideID.'"><td>'.$id.'</td><td>'.$presentation_id.'</td><td>'.$title.'</td><td>'.$question.'</td><td>'.$type.'</td><td>'.$representation_type.'</td><td>'.$date.'</td><td id="qr_'.$qr_slide.'">'.$qr_slide.'</td><td id="graph_'.$representation_slide.'">'.$representation_slide.'</td><td><a href="javascript:;"><i style="padding-left:10px" class="fa fa-trash fa-lg" onclick="delete_interaction('.$id.')" title="Interaktion löschen" alt="Interaktion löschen"></i></a><a href="javascript:;"><i class="fa fa-edit fa-lg" style="padding-left:10px" title="Interaktion bearbeiten" alt="Interaktion bearbeiten"></i></a><a href="javascript:;"><i class="fa fa-file-text-o fa-lg" style="padding-left:10px" onclick="location.href=\'showData.php?id='.$id.'\'" title="Statistiken" alt="Statistiken"></i></a><a href="javascript:;"><i class="fa fa-qrcode fa-lg" style="padding-left:10px" onclick="mode_qr('.$id.')" title="QR zuweisen" alt="QR zuweisen" id="mode_qr'.$id.'"></i></a><a href="javascript:;"><i class="fa fa-bar-chart-o fa-lg" style="padding-left:10px;" onclick="mode_graph('.$id.')" title="Graph zuweisen" alt="Graph zuweisen" id="mode_graph'.$id.'"></i></a></td><tr>';
	}
?>
    </tbody>
</table>
</center>
</div><!-- Content-End -->
<script>$(document).ready( function () {
    $('#table').DataTable({
        pageLength: 100,
        lengthChange: false,
        searching: true,
        ordering:  false,
		scrollY:        600,
        scrollCollapse: true,
        paging:         false
    });
} );
</script>

<!-- Footer-Start -->
<div id="footer"><div id="appMode"></div></div><!-- Footer-End -->

</div> <!-- Page-End -->
<?php else : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"></div>

<!-- Content-Start -->
<div id="content">
<center>Sie haben nicht die Berechtigung f&uuml;r diese Seite.<br/>Loggen Sie sich bitte zuerst <a href="javascript:;" onClick="logout();">hier</a> ein.</center>
</div>

<!-- Footer-Start -->
<div id="footer"><div id="console" style="color:black; float:left"></div><a href="javascript:;"><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></a></div>
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