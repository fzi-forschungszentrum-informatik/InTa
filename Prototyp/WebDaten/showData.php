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

// Setzt die Zeitzone auf Europa/Berlin
date_default_timezone_set('Europe/Berlin'); 
// Bindet die nötigen PHP-Files ein
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
// Startet die Session
sec_session_start();
// SQL Query
$stmt = $mysqli->prepare("SELECT i.id, i.title, i.type, i.question, i.representation_type, a.id, a.answer, a.ip, a.os, a.hostname, a.country, a.date FROM interactions AS i JOIN answers AS a ON i.id = a.interactions_id WHERE i.id = ?");
// Bindet die id ein
$stmt->bind_param('s', $id);
$id = $_GET["id"];
$stmt->execute();
$stmt->store_result();
// Speichert die Ergebnisse in die Variablen
$stmt->bind_result($interaction_id, $title, $type, $question, $representation_type, $answer_id, $answer, $ip, $os, $hostname, $country, $date);

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
    <script src="js/app.js" type="text/javascript"></script>
    <script src="js/audienceResponseSystem.js" type="text/javascript"></script>
    <script src="js/jquery.dataTables.js" type="text/javascript"></script>
    <script src="js/highcharts.js" type="text/javascript"></script>
    <script src="js/jquery.tagcloud.js" type="text/javascript"></script>
	<script src="js/jquery.circliful.js" type="text/javascript"></script>
    <!-- <script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script>
	<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/StackBlur.js"></script>
	<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script>
	-->

    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="css/pure-min.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.circliful.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.dataTables.css" rel="stylesheet" type="text/css" />     
</head>

<body>
<style>
html, body {
  overflow:scroll !important;
}

#header{
position: fixed !important;
width: 100% !important;
z-index:99;
}

#footer{
position: fixed !important;
}
</style>
<?php if (login_check($mysqli) == true) : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.php'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;"><?php echo htmlentities($_SESSION['username']); ?></div><a href="javascript:;" style="color:white; float:right; padding-right:30px" onclick="logout()">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a> | <a style="color:white;" href="overview.php">&Uuml;berblick</a> | <a style="color:white;" href="showData.php">Statistik</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="content2" style="padding:100px;">
<p>Umfrageergebnisse:</p>
<p>
Interaction ID:
<?php 
// SQL-Query
$sql = 'SELECT * FROM interactions WHERE id = '.$id;
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
while($row = $result->fetch_assoc())
{
	$interaction_id = $row['id'];
	$title = $row['title'];
	$question = $row['question'];
	$type = $row['type'];
	$representation_type = $row['representation_type'];
	
	echo ''.$row['id'] . "<br>";
	echo 'Titel: '.$row['title'] . "<br>";
	echo 'Frage: '.$row['question'] . "<br>";
	echo 'Typ: '.$row['type'] . "<br>";
	echo 'Darstellung: '.$row['representation_type'] . "<br>";
	echo "<p><a onclick='sendData()'>Statistiken per E-Mail senden</a></p>";
}
?>

</p>
<center>
<table id="table2" class="display" >
    <thead>
        <tr>
            <th>id</th>
            <th>Antwort</th>
            <th>Nutzer IP</th>
            <th>Betriebssystem</th>
            <th>Hostname</th>
            <th>Land</th>
            <th>Datum</th>
            <th>Aktion</th>
        </tr>
    </thead>

    <tbody>
<?php 
while($stmt->fetch()){
    // Schreibt die Antwort Eigenschaften in die Tabelle
	echo '<tr><td>'.$answer_id.'</td><td>'.$answer.'</td><td>'.$ip.'</td><td>'.$os.'</td><td>'.$hostname.'</td><td>'.$country.'</td><td>'.date('r', $date/1000).'</td><td><a href="javascript:;"><i class="fa fa-trash fa-lg" onclick="delete_answer('.$answer_id.','.$interaction_id.')" title="Antwort löschen" alt="Antwort löschen"></i></a></td></tr>';
}
?>
    </tbody>
</table>
<div id="container2" style="min-width: 310px; height: 300px; margin: 0 auto; padding:50px 0px 300px"></div>
<!-- canvas tag to convert SVG -->
<canvas id="canvas" style="display:none;"></canvas>
<?php
// SQL-Query
$sql = 'SELECT codeblock_representation_type FROM representation_types WHERE name ="'.$representation_type.'"';
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
$row2 = $result->fetch_assoc();
echo utf8_encode($row2['codeblock_representation_type']); 
?>
</center>
</div><!-- Content-End -->
<script>
var interaction_id = <?php echo $interaction_id ?> ;
$(document).ready( function () {
	$('#tagCloud').css('top','');
	$('#container').css('top','');
	$('#top10').css('top','');
	$('#top10pro').css('top','');
	$('#top10contra').css('top','');
	$('#top10s').css('top','');
	$('#top10w').css('top','');
	$('#top10o').css('top','');
	$('#top10t').css('top','');
	$('#circleStat').css('top','');
	$('#table2').DataTable({
        pageLength: 10,
        lengthChange: false,
        searching: true,
        ordering:  false
    });
	
	// Speichert die eingegebenen Daten aus dem Formular in der Datenbank unter Interaction
	$.post("getData.php",
    	{
		  code: "answerTime",
		  id: <?php echo $id ?>
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
				eval(data);
				b = b.split(",");
				var d = new Date(parseInt(b[0]));
    			var curr_date = d.getDate();
				var cat ="";
				var tmp ="";
				for(i=0;i<b.length;i++)
				{
					var d = new Date(parseInt(b[i]));
					tmp = tmp + ",'"+d.getHours() +":"+d.getMinutes()+ "'";
				}
				cat = "["+tmp.substring(1, tmp.length)+"]";
		  		
				$('#container2').highcharts({
        chart: {
            zoomType: 'x'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            //type: 'datetime',
            //minRange: 14 * 24 * 3600000 // fourteen days
			categories: eval(cat)
        },
        yAxis: {
            title: {
                text: 'Anzahl'
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },

        series: [{
            type: 'area',
            
            data: eval(a)
        }]
    });
	  		}
	  		else
	  		{};
    	});
} );

sendData = function()
{
	var data ="";
	var svg = document.getElementById('container');
	if(svg == null)
	{}
	else
	{
	var svg = document.getElementById('container').children[0].innerHTML;
    canvg(document.getElementById('canvas'),svg);
    var img = canvas.toDataURL("image/png"); //img is data:image/png;base64
    img = img.replace('data:image/png;base64,', '');
    data = "bin_data=" + img;
	}
	
	$.ajax({
          type: "POST",
          url: "createPDF.php?id="+interaction_id,
		  data: data,
          success: function(data){
			  console.log(data);
			  javascript:location.href='overview.php'
          }
        });
}
</script>

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->

</div> <!-- Page-End -->

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