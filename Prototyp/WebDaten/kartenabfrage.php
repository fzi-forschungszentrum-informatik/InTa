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
 * Die kartenabfrage.php dient zur Darstellung und Interaktion des Kartenabfrage-Typs. Zunächst werden die nötigen Daten aus der Datenbank geladen,
 * sowie den Code-Block für die Darstellung. Anschließend werden die JavaScript Drop-Event Funktionen geladen für das Drag&Drop der Karten. Die create
 * Funktion dient zum erstellen der Listen, die Delete Funktion zum löschen von Listen. Wenn nun eine Karte in eine Liste gedropped wird, wird der Liste
 * ein Listen-Eintrag mit dem jeweiligen Titel der gedroppten Karte angelegt und die Karte per css unsichtbar gemacht. Beim löschen der Karte aus der Liste,
 * wird diese aus der Liste entfernt und die Karte per css im unteren Bildrand wieder sichtbar und kann neu zugeordnert werden.
 * DIe refreshTags Funktion dient zum neu laden der Karten aus der Datenbank. Die create_interaction Funktion dient zum erstellen einer neuen Interaction mit 
 * Fragetyp MultipleChoice, als Antwortmöglichkeiten werden die Titel der angelegten Listen genommen. Man wird direkt zum QR-Code der neuen Interaktion geleitet.
 */ 

// Bindet die nötigen PHP-Files ein  
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// Holt die GET-Variablen 
$preview = $_GET["preview"];
$source = $_GET["source"];
$interaction_id = $_GET["interaction_id"];


// SQL-Query
$stmt = $mysqli->prepare("SELECT representation_type, settings, user_id, question  FROM interactions WHERE id = ? LIMIT 1");
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $interaction_id);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($type, $settings, $user_id, $question);
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

// Gibt den HTML-Code aus 
echo '
<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Question</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
    <script src="js/jquery.tagcloud.js" type="text/javascript"></script>
	<script src="js/jquery.circliful.js" type="text/javascript"></script>
	<script src="js/highcharts.js" type="text/javascript"></script>
	<script src="js/jquery.dataTables.js" type="text/javascript"></script>

    <!-- CSS-Files -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet" /> -->
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
echo'
<style>
      ul { list-style-type: none; 
         margin: 0; padding: 0; width: 80%; }
      .default {
		 border: 1px solid #dddddd;
         background: #eeeeee;
         border: 1px solid #DDDDDD;
         color: #333333;
		 width: 160px;
		 margin: 0 3px 3px 3px; 
         padding: 0.4em; 
		 padding-left: 1.5em; 
         font-size: 17px; 
		 minheight: 20px;
		 text-align:center;
         }
      .wrap{
         display: table-row-group;
		 float:left; 
		 margin-left:10px; 
		 height:500px; 
		 width:240px;
         }
	#control{
		padding:10px 100px;
	}
	
html, body {
  height: 100%;
}
.page-wrap {
  min-height: 100%; 
}
.page-wrap:after {
  content: "";
  display: block;
}
.site-footer, .page-wrap:after {
  height: 100px; 
}
.site-footer {
  background: rgb(73,173,255);
}
   </style>
   <script>
   function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
	console.log("drag:"+ev.target.id);
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
	
    ev.preventDefault();
    var data2 = ev.dataTransfer.getData("text");
	var title = $("#"+data2).attr("title");
	var data3 = "<li class=\'default\' id=\'l"+data2+"\'>"+title+"<i class=\'fa fa-sign-in\' style=\'float:right;\' onclick=\'$(\"#"+data2+"\").css(\"display\",\"inline\"); $(\"#l"+data2+"\").remove(); $(\"#l"+data2+"\").remove();\'></i></li>";
    $("#"+ev.target.id).children().last().append(data3);
	$("#"+data2).css("display","none");
	console.log("drop:"+data2);
	console.log("drop:"+ev.target.id);
}
   </script>
<div class="page-wrap">   
<div id="content0" style="height:500px; padding-top:15px; display:block;"></div>
</div>
<footer class="site-footer"><div style="float:right; padding:15px 15px; display:none;" id="pageControl"><a class="fa fa-arrow-circle-left fa-lg" style="padding-left:10px;" onClick="if(currentDiv == 0){}else{ $(\'#content\'+(currentDiv-1)).show(); $(\'#content\'+currentDiv).hide(); console.log(currentDiv-1); currentDiv--;} "></a><a class="fa fa-arrow-circle-right fa-lg" style="padding-left:10px;" onClick="if(currentDiv == divCount){}else{$(\'#content\'+(currentDiv+1)).show(); $(\'#content\'+currentDiv).hide(); currentDiv++;}"></a></div>
<div id="control"><input id="title" type="text" value="Liste 1"><a class="fa fa-plus-square-o fa-lg" style="padding-left:10px;" onClick="create()"></a><p>Ein-Punkt Abfrage<a class="fa fa-caret-square-o-right fa-lg" style="padding-left:10px;" onClick="createInteraction()"></a></p></div>
</footer>
<script>
var i = 0;
var divCount = 0;
var currentDiv = 0;
$(document).ready(function () { 
refreshTags();
});
create = function()
{
	if(( $("#content"+divCount+" div").length % 5 == 0) && ($("#content"+divCount+" div").length > 4) ){ $("#pageControl").css("display","block"); $("#content"+divCount).css("display","none"); divCount++; currentDiv++; $(".page-wrap").append("<div id=\"content"+divCount+"\" style=\"height:500px; padding-top:15px; display:block;\" ></div>")}else{i++;
	$("#content"+divCount).append("<div class=\'wrap\' ondrop=\'drop(event)\' ondragover=\'allowDrop(event)\' id=\'wrap"+i+"\'><div class=\"fa fa-close\" style=\'float:right\' onclick=\"deleteDiv(\'"+i+"\')\"></div><input id=\'inp"+i+"\' type=\'text\' value=\'"+ $("#title").val()+"\' style=\'color:grey; font-weight:100; font-size:30px; width:200px; text-align:center; background-color: transparent; border-style: solid; border-width: 0px 0px 1px 0px; border-color: grey\'><ul id=\'sortable-"+i+"\'></ul></div><script> $(function() { $( \'#sortable-"+i+"\' ).sortable({start: function (event, ui) {},receive : function (event, ui){},stop: function (event, ui) {}});});<\/script>"); }
}
deleteDiv = function(id)
{
	for(var z=0; z<$("#sortable-"+id).children().length; z++)
	{
		var idk = $("#sortable-"+id).children().eq(z).attr("id")
		$("#"+idk.substring(1, idk.length)).css("display","inline");
	}
	$("#wrap"+id).remove();
	console.log("test "+id);
}

createInteraction = function()
{
	answers="";
	i++;
	for(z=0; z<i;z++)
	{
		if(typeof( $("#inp"+z).val()) !="undefined"){
		answers = answers +","+ "\""+ $(\'#inp\'+z).val()+ "\"";}
	}
	answers = answers.substr(1, answers.length);
	var anzahl = (answers.split(\',\').length);
	
	var order="";
	
	// Erstellt aktuellen Timestamp 
  	var timestamp = new Date();
  	var timestamp_read = timestamp.getTime();
	
	$.post("setData.php",
    	{
		  code: "interactions",
		  userID: ';echo $user_id; echo' ,
		  title: "Ein-Punkt Abfrage",
		  type:"MultipleChoice",
		  password:"",
		  presentation:"0",
		  presentationid: "0",
		  date:timestamp_read,
		  slide:"0",
		  slide_id:"0",
		  qr_slide:"0",
		  representation_slide: "0",
		  settings: \'{"only_one_answer":"true","answerCount":"\'+anzahl+\'","answerPossibilities":[\'+answers+\'],"order":[\'+order+\']}\',
		  question: "Ein-Punkt Abfrage",
		  representationType: "BarChart"
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
		  		$.post("getData.php",
    	{
		  code: "last_entry",
		  user_id: ';echo $user_id; echo'
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
				var source = "overview";
				parent.location.href = "qr.php?source="+source+"&preview=true&interaction_id="+data;
		  		console.log(data);
	  		}
	  		else
	  		{
	  		};
    	});
	  		}
	  		else
	  		{
	  		};
    	});
}

refreshTags = function() { 
$.post("getData.php", { code: "answers_kartenabfrage", interaction_id: interaction_id },function(data,status) 
{ 
	if (status == "success") { console.log("success"); answerArray = eval(data); console.log(answerArray); 
		if( $("#control div").length == answerArray.length)
		{}
		else
		{	
			for(i= $("#control div").length; i<answerArray.length;i++)
			{
				$("#control").append("<div id=\'k"+i+"\' title=\'"+answerArray[i]+"\' class=\'default\' style=\'position:absolute; left: 50%; margin-left: -80px; bottom:10px; width:160px; display:block;\' draggable=\'true\' ondragstart=\'drag(event)\'>"+answerArray[i]+"</div>");
			}
	}
	} 
	else { }; 
});
setTimeout("refreshTags()",1000); 
}
</script>
	
</div> <!-- Page-End -->
</body>
</html>';
?>