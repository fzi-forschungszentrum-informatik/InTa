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
 * Die setDatabase.php dient zum anlegen der Datenbank und der Servereinstellungen. Dabei werden die in der initialize.php eingegebenen Daten hier entgegengenommen.
 * Die Daten werden zunächst geholt und in Variablen gespeichert, falls der Nutzer angegeben hat, dass die Konfigurationsdatei überschrieben werden soll, werden die
 * vom Nutzer eingegebenen DAten genommen, falls nicht werden die Daten aus der Konfigurationsdatei genommen. Anschließend wird diesbezüglich die Datenbankverbindung
 * aufgebaut und die Tabellen und Tabelleneinträge geschrieben. Es werden auch Testnutzer und Testdaten angelegt. Hier befinden sich auch die Code-Blöcke für die Fragetypen,
 * und Darstellungstypen. Nachdem die Daten in die Datenbank geschrieben wurden, wird die Konfigurationsdatei falls angegeben mit den Nutzereingaben überschrieben.
 * Hier sollten auch falls neue Fragetypen oder Darstellungstypen erstellt wurden eingefügt werden. Diese werden dann anschließend im Prototyp angezeigt und können 
 * ausgewäht werden.
 */

// Bindet die nötigen PHP-Files ein
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/psl-config.php';

// Holt die POST Variablen
$overwrite = $_POST['overwrite'];

if($overwrite == "on")
{
// Nutzereingaben werden geholt
$host = $_POST['host'];
$user = $_POST['user'];
$password = $_POST['password'];
$database = $_POST['database'];
$url = $_POST['url'];
$email = $_POST['email'];
}
else
{
$host = constant("HOST");
$user = constant("USER");
$password = constant("PASSWORD");
$database = constant("DATABASE");
$url = constant("URL");
$email = constant("MAIL");
}

// Überprüft Datenbankverbindung
$con=mysqli_connect($host,$user,$password);
if (mysqli_connect_errno()) 
{
  $message = "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Erstellt neue Datenbank
$sql="CREATE DATABASE ".$database;
if (mysqli_query($con,$sql)) 
{
  $message = "Database created successfully";
} 
else 
{
  $message = "Error creating database: " . mysqli_error($con);
}
mysqli_close($con);

// Baut Datenbankverbindung zur neu erstellten DB auf
$con=mysqli_connect($host,$user,$password,$database);
// Überprüft Datenbankverbindung
if (mysqli_connect_errno()) 
{
  $message = "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Löscht vorhandene Tabellen
$sql="DROP TABLE IF EXISTS login_attempts";
// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) {$message = "Drop Table successfully";} else {$message = "Error dropping table: " . mysqli_error($con);}

$sql="DROP TABLE IF EXISTS members";
// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) {$message = "Drop Table successfully";} else {$message = "Error dropping table: " . mysqli_error($con);}

$sql="DROP TABLE IF EXISTS question_types";
// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) {$message = "Drop Table successfully";} else {$message = "Error dropping table: " . mysqli_error($con);}

$sql="DROP TABLE IF EXISTS interactions";
// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) {$message = "Drop Table successfully";} else {$message = "Error dropping table: " . mysqli_error($con);}

$sql="DROP TABLE IF EXISTS answers";
// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) {$message = "Drop Table successfully";} else {$message = "Error dropping table: " . mysqli_error($con);}

$sql="DROP TABLE IF EXISTS representation_types";
// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) {$message = "Drop Table successfully";} else {$message = "Error dropping table: " . mysqli_error($con);}

// Erstellt die Tabelle login_attempts
$sql="CREATE TABLE login_attempts (
	user_id INT(11) NOT NULL,
	time VARCHAR(30) NOT NULL
)";

// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) 
{
  $message = "Table login_attempts created successfully";
} 
else 
{
  $message = "Error creating table login_attempts: " . mysqli_error($con);
}

// Erstellt die Tabelle members
$sql="CREATE TABLE members(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password CHAR(128) NOT NULL,
    salt CHAR(128) NOT NULL
);";

// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) 
{
  $message = "Table members created successfully";
} 
else 
{
  $message = "Error creating table members: " . mysqli_error($con);
}

// Fügt den Testnutzer Admin hinzu
mysqli_query($con,"INSERT INTO members (id, username, email, password, salt) VALUES ('1', 'admin','admin@test.de','8cc031c06cae4d5ef931927c4ab18071cb84a78a0df85bbb646da8fee4b5858e29b6b8277181ca6925a35b5c99c9b1064d408cfbfc4dae81a829643a5db31930','bbe35b07dd769cb1afe260664395d2b1da76434227115f8272acd7c00bed2473d28536c875942297e7874f1a3a46221a6a34bc761cea170ad46c52f6226b944f')");


// Erstellt die Tabelle question_types
$sql="CREATE TABLE question_types(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    codeblock_form TEXT,
    codeblock_mobile TEXT,
    codeblock_display TEXT
);";

// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) 
{
  $message = "Table question_types created successfully";
} 
else 
{
  $message = "Error creating table question_types: " . mysqli_error($con);
}

// Fügt Daten in die Tabelle ein (Fragetypen)
// Freitextfrage
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><div class=\"pure-control-group\"><label for=\"inputType\">Antowrttyp</label><select id=\"inputType\" class=\"ars-select\" onChange=\"iType(this.value)\"><option>Text</option><option>Zahl</option><option>Datum</option></select></div><label for=\"cb\" class=\"pure-checkbox\"><input id=\"cb\" type=\"checkbox\"> Nur eine Antwort pro Teilnehmer m&ouml;glich.</label><div class=\"pure-control-group\" id=\"range\" style=\"display:none\"><label>Spanne</label><br \\\\><label for\"range_from\">Von</label><input id=\"range_from\" type=\"text\" placeholder=\"0\"><br \\\\><label for\"range_till\">Bis</label><input id=\"range_till\" type=\"text\" placeholder=\"100\"></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und bestimmen ob ein Teilnehmer &ouml;fters oder nur einmal abstimmen darf.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/freitext_text.png\" height=\"500\"\\\\></p></center></div></div><script>iType = function(type){if(type == \"Zahl\"){\$(\"#range\").show();\$( \"#type_image\" ).html(\\\\''<img src=\"images/freitext_zahl.png\" height=\"500\"\\\\>\\\\'');}else if(type == \"Text\"){\$(\"#range\").hide();\$( \"#type_image\" ).html(\\\\''<img src=\"images/freitext_text.png\" height=\"500\"\\\\>\\\\'');}else if(type == \"Datum\"){\$(\"#range\").hide();\$(\"#type_image\").html(\\\\''<img src=\"images/freitext_datum.png\" height=\"500\"\\\\>\\\\'');}};var settings=\"\"; getValues = function(){ settings=\\\\''{\"type\":\"\\\\''+document.getElementById(\"inputType\").value+\\\\''\", \"only_one_answer\":\"\\\\''+document.getElementById(\"cb\").checked+\\\\''\",\"from\":\"\\\\''+document.getElementById(\"range_from\").value+\\\\''\",\"till\":\"\\\\''+document.getElementById(\"range_till\").value+\\\\''\"}\\\\''}";
$codeblock_mobile = "<form id=\"form\"><input type=\"text\" name=\"fname\" id=\"answer\" placeholder=\"Antwort...\"><input type=\"button\" value=\"senden\" onClick=\"sendAnswer()\"></form><script>\$(document).ready(function () { var from = settings[\"from\"];  var till = settings[\"till\"];  var mid = settings[\"from\"]/2; var type = settings[\"type\"];  if(settings[\"type\"] == \"Text\")  {   \$(\"#form\").html(''<input type=\"text\" name=\"fname\" id=\"answer\" placeholder=\"Antwort...\"><input type=\"button\" value=\"senden\" onClick=\"sendAnswer()\">'')  }   else if(settings[\"type\"] == \"Zahl\") { if (from != \"\" && till != \"\") { \$(\"#form\").html(''<label for=\"slider\">Zahl</label><input type=\"range\" name=\"slider\" id=\"answer\" value=\"''+mid+''\" min=\"''+from+''\" max=\"''+till+''\" /><input type=\"button\" value=\"senden\" onClick=\"sendAnswer()\">'') } } else if(settings[\"type\"] == \"Datum\")  {   \$(\"#form\").html(''<label for=\"date\">Datum</label><input type=\"date\" id=\"answer\" data-role=\"date\" data-inline=\"true\"><input type=\"button\" value=\"senden\" onClick=\"sendAnswer()\">'') } });";

$codeblock_display ="<div class=\"pure-u-1-2\"><div class=\"l-box\"><h3>Darstellungs-Einstellungen</h3><form class=\"pure-form pure-form-aligned\"><fieldset><div class=\"pure-control-group\"><label for=\"representationType\">Darstellung</label><select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\"><option>Top10</option><option>WordCloud</option><option>ColumnChart</option></select></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p><center><p id=\"representationType_image\"><img src=\"images/representationType_top10.png\" height=\"500\"\\\\></p></center></div></div><script>rType = function(type){if(type == \"Top10\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_top10.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"WordCloud\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_wordCloud.png\" height=\"500\"\\\\>\\\\'');}else if(type == \"ColumnChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_columnChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('1', 'Freitextfrage','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// Alternativfrage
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" >    <h3>Frage</h3>    <p>Umfrage-Einstellungen:</p>    <form class=\"pure-form pure-form-aligned\">      <fieldset id=\"form_i\">        <div class=\"pure-control-group\">          <label for=\"question\">Frage</label>          <input id=\"question\" type=\"text\" placeholder=\"Ist Brainstorming sinnvoll?\">        </div>        <div class=\"pure-control-group\">          <label for\"pro\">Pro</label>          <input id=\"pro\" type=\"text\" placeholder=\"ja, pro, true, 1, +, ...\">          <br/>          <label for\"contra\">Contra</label>          <input id=\"contra\" type=\"text\" placeholder=\"nein, contra, false, 0, -, ...\">        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button>    <button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und die beiden Antwortalternativen festlegen.</p>    <h3>Beispiel</h3>    <center>      <p id=\"type_image\"><img src=\"images/alternativfrage.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"true\",\"pro\":\"\\\\''+document.getElementById(\"pro\").value+\\\\''\",\"contra\":\"\\\\''+document.getElementById(\"contra\").value+\\\\''\"}\\\\''}";
$codeblock_mobile ="<form id=\"form\"><input id=\"pro\" type=\"button\" value=\"\" onClick=\"setAnswer(''pro'')\"><p>oder</p><input id=\"contra\" type=\"button\" value=\"\" onClick=\"setAnswer(''contra'')\"></form><input type=\"text\" name=\"fname\" id=\"answer\" value=\"\" style=\"display:none\"><script>\$(document).ready(function () {  var pro = settings[\"pro\"];  var contra = settings[\"contra\"];  \$(\"#pro\").attr(\"value\",pro); \$(\"#contra\").attr(\"value\",contra);});setAnswer = function(id){ if(id == \"pro\") {   \$(\"#answer\").attr(\"value\",settings[\"pro\"]);  } else  {   \$(\"#answer\").attr(\"value\",settings[\"contra\"]); } sendAnswer();}";
$codeblock_display ="<div class=\"pure-u-1-2\">  <div class=\"l-box\">    <h3>Darstellungs-Einstellungen</h3>    <form class=\"pure-form pure-form-aligned\">      <fieldset>        <div class=\"pure-control-group\">          <label for=\"representationType\">Darstellung</label>          <select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\">            <option>BarChart</option>            <option>DonutChart</option>          </select>        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button>    <button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p>    <center>      <p id=\"representationType_image\"><img src=\"images/representationType_barChart.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>rType = function(type){if(type == \"BarChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_barChart.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"DonutChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_donutChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('2', 'Alternativfrage','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// MultipleChoice
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><label for=\"cb\" class=\"pure-checkbox\"><input id=\"cb\" type=\"checkbox\" onChange=\"mType(this.checked)\"> Nur eine Antwort ausw&auml;hlbar.</label><div class=\"pure-control-group\" id=\"answerPossibilities\"><p><label for=\"question\">Antwortm&ouml;glichkeit 1</label><input id=\"answer1\" type=\"text\" placeholder=\"Ideenfindungs-Methode\"><a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deleteAnswer()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addAnswer()\"></i></a></p></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen, sowie die m&ouml;glichen Antwortalternativen.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/multipleChoice.png\" height=\"500\"\\\\></p></center></div></div><script>var num=\"2\"; addAnswer = function(){if(\$(\"#answerPossibilities label\").length == 10){}else{ \$(\"#answerPossibilities\").find(\"a\").remove(); \$(\"#answerPossibilities\").append(\\\\''<p><label for=\"question\">Antwortm&ouml;glichkeit \\\\''+num+\\\\''</label><input id=\"answer\\\\''+num+\\\\''\" type=\"text\" placeholder=\"Ideenfindungs-Methode\"><a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deleteAnswer()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addAnswer()\"></i></a></p>\\\\''); num = \$(\"#answerPossibilities label\").length+1;}}; deleteAnswer = function(){if(\$(\"#answerPossibilities label\").length == 1){} else{ num--;\$(\"#answerPossibilities\").children().last().remove(); \$(\"#answerPossibilities\").children().last().append(\\\\''<a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deleteAnswer()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addAnswer()\"></i></a></p>\\\\'');}}; var settings=\"test\"; getValues = function(){ var answerPossibilities =\"\"; for( var i=1; i < \$(\"#answerPossibilities label\").length+1; i++){ answerPossibilities = answerPossibilities +\\\\'',\"\\\\''+document.getElementById(\"answer\"+i).value+\\\\''\"\\\\'';}; console.log(answerPossibilities); var answerP = \"[\"+answerPossibilities.substr(1, answerPossibilities.length)+\"]\"; settings=\\\\''{\"only_one_answer\":\"\\\\''+document.getElementById(\"cb\").checked+\\\\''\",\"answerCount\":\"\\\\''+\$(\"#answerPossibilities label\").length+\\\\''\",\"answerPossibilities\":\\\\''+answerP+\\\\''}\\\\''; console.log(settings);}; mType = function(val){console.log(settings); if(val == true){\$(\"#type_image\").html(\\\\''<img src=\"images/multipleChoice.png\" height=\"500\"\\\\>\\\\'')}else{\$(\"#type_image\").html(\\\\''<img src=\"images/multipleChoice.png\" height=\"500\"\\\\>\\\\'')}}";
$codeblock_mobile ="<form id=\"form\">  </form><input type=\"text\" name=\"fname\" id=\"answer\" value=\"\" style=\"display:none\"><script>\$(document).ready(function () {     \$(\"#form\").html(\"\");   for(i=0; i<settings[\"answerCount\"];i++)   {   \$(\"#form\").append(''<input id=\"''+settings.answerPossibilities[i]+''\" type=\"button\" value=\"''+settings.answerPossibilities[i]+''\" onClick=\"setAnswer(\\\\''''+settings.answerPossibilities[i]+''\\\\'')\">'');    }   });setAnswer = function(id){  \$(\"#answer\").attr(\"value\",id); sendAnswer();}";
$codeblock_display ="<div class=\"pure-u-1-2\">  <div class=\"l-box\">    <h3>Darstellungs-Einstellungen</h3>    <form class=\"pure-form pure-form-aligned\">      <fieldset>        <div class=\"pure-control-group\">          <label for=\"representationType\">Darstellung</label>          <select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\">            <option>BarChart</option>            <option>PieChart</option>          </select>        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button>    <button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p>    <center>      <p id=\"representationType_image\"><img src=\"images/representationType_barChart.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>rType = function(type){if(type == \"BarChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_barChart.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"PieChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_pieChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('3', 'MultipleChoice','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// SingleChoice
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><div class=\"pure-control-group\" id=\"answerPossibilities\"><p><label for=\"question\">Antwortm&ouml;glichkeit 1</label><input id=\"answer1\" type=\"text\" placeholder=\"Ideenfindungs-Methode\"><a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deleteAnswer()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addAnswer()\"></i></a></p></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen, sowie die m&ouml;glichen Antwortalternativen.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/multipleChoice.png\" height=\"500\"\\\\></p></center></div></div><script>var num=\"2\"; addAnswer = function(){if(\$(\"#answerPossibilities label\").length == 10){}else{ \$(\"#answerPossibilities\").find(\"a\").remove(); \$(\"#answerPossibilities\").append(\\\\''<p><label for=\"question\">Antwortm&ouml;glichkeit \\\\''+num+\\\\''</label><input id=\"answer\\\\''+num+\\\\''\" type=\"text\" placeholder=\"Ideenfindungs-Methode\"><a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deleteAnswer()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addAnswer()\"></i></a></p>\\\\''); num = \$(\"#answerPossibilities label\").length+1;}}; deleteAnswer = function(){if(\$(\"#answerPossibilities label\").length == 1){} else{ num--;\$(\"#answerPossibilities\").children().last().remove(); \$(\"#answerPossibilities\").children().last().append(\\\\''<a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deleteAnswer()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addAnswer()\"></i></a></p>\\\\'');}}; var settings=\"test\"; getValues = function(){ var answerPossibilities =\"\"; for( var i=1; i < \$(\"#answerPossibilities label\").length+1; i++){ answerPossibilities = answerPossibilities +\\\\'',\"\\\\''+document.getElementById(\"answer\"+i).value+\\\\''\"\\\\'';}; console.log(answerPossibilities); var answerP = \"[\"+answerPossibilities.substr(1, answerPossibilities.length)+\"]\"; settings=\\\\''{\"only_one_answer\":\"true\",\"answerCount\":\"\\\\''+\$(\"#answerPossibilities label\").length+\\\\''\",\"answerPossibilities\":\\\\''+answerP+\\\\''}\\\\''; console.log(settings);};";
$codeblock_mobile ="<form id=\"form\">  </form><input type=\"text\" name=\"fname\" id=\"answer\" value=\"\" style=\"display:none\"><script>\$(document).ready(function () {     \$(\"#form\").html(\"\");   for(i=0; i<settings[\"answerCount\"];i++)   {   \$(\"#form\").append(''<input id=\"''+settings.answerPossibilities[i]+''\" type=\"button\" value=\"''+settings.answerPossibilities[i]+''\" onClick=\"setAnswer(\\\\''''+settings.answerPossibilities[i]+''\\\\'')\">'');    }   });setAnswer = function(id){  \$(\"#answer\").attr(\"value\",id); sendAnswer();}";
$codeblock_display ="<div class=\"pure-u-1-2\">  <div class=\"l-box\">    <h3>Darstellungs-Einstellungen</h3>    <form class=\"pure-form pure-form-aligned\">      <fieldset>        <div class=\"pure-control-group\">          <label for=\"representationType\">Darstellung</label>          <select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\">            <option>BarChart</option>            <option>PieChart</option>          </select>        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button>    <button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p>    <center>      <p id=\"representationType_image\"><img src=\"images/representationType_barChart.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>rType = function(type){if(type == \"BarChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_barChart.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"PieChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_pieChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('4', 'SingleChoice','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// ProContraListe
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><label for=\"cb\" class=\"pure-checkbox\"><input id=\"cb\" type=\"checkbox\"> Nur eine Antwort pro Teilnehmer m&ouml;glich.</label></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und bestimmen ob ein Teilnehmer &ouml;fters oder nur einmal abstimmen darf.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/proContra.png\" height=\"500\"\\\\></p></center></div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"\\\\''+document.getElementById(\"cb\").checked+\\\\''\"}\\\\''}";
$codeblock_mobile ="<form id=\"form\"><fieldset data-role=\"controlgroup\" id=\"list\">        <label for=\"pro\">Pro</label>        <input type=\"radio\" name=\"list\" id=\"pro\" value=\"pro\" checked=\"true\">        <label for=\"contra\">Contra</label>        <input type=\"radio\" name=\"list\" id=\"contra\" value=\"contra\">  </fieldset><input type=\"text\" name=\"fname\" id=\"answer1\" placeholder=\"Antwort...\"><input type=\"button\" value=\"senden\" onClick=\"setAnswer()\"><input type=\"text\" name=\"fname\" id=\"answer\" value=\"\" style=\"display:none\"></form><script>setAnswer = function(){ var answer = \$(\"#list :radio:checked\").val()+ \":\" + \$(\"#answer1\").val();  \$(\"#answer\").attr(\"value\",answer); sendAnswer();}";
$codeblock_display ="<div class=\"pure-u-1-2\"><div class=\"l-box\"><h3>Darstellungs-Einstellungen</h3><form class=\"pure-form pure-form-aligned\"><fieldset><div class=\"pure-control-group\"><label for=\"representationType\">Darstellung</label><select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\"><option>ProContraListe</option></select></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p><center><p id=\"representationType_image\"><img src=\"images/representationType_top10.png\" height=\"500\"\\\\></p></center></div></div><script>rType = function(type){if(type == \"Pro/Contra Liste\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_proContra.png\" height=\"500\"\\\\>\\\\'')}}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('5', 'ProContraListe','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// SWOT Analyse
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><label for=\"cb\" class=\"pure-checkbox\"><input id=\"cb\" type=\"checkbox\"> Nur eine Antwort pro Teilnehmer m&ouml;glich.</label></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und bestimmen ob ein Teilnehmer &ouml;fters oder nur einmal abstimmen darf.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/swot.png\" height=\"500\"\\\\></p></center></div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"\\\\''+document.getElementById(\"cb\").checked+\\\\''\"}\\\\''}";
$codeblock_mobile ="<form id=\"form\"><fieldset data-role=\"controlgroup\" id=\"list\">        <label for=\"str\">Strengths (St&auml;rken)</label>        <input type=\"radio\" name=\"list\" id=\"str\" value=\"str\" checked=\"true\">        <label for=\"wea\">Weaknesses (Schw&auml;chen)</label>        <input type=\"radio\" name=\"list\" id=\"wea\" value=\"wea\">        <label for=\"opp\">Opportunities (Chancen)</label>        <input type=\"radio\" name=\"list\" id=\"opp\" value=\"opp\">        <label for=\"thr\">Threats (Gefahren)</label>        <input type=\"radio\" name=\"list\" id=\"thr\" value=\"thr\"> </fieldset><input type=\"text\" name=\"fname\" id=\"answer1\" placeholder=\"Antwort...\"><input type=\"button\" value=\"senden\" onClick=\"setAnswer()\"><input type=\"text\" name=\"fname\" id=\"answer\" value=\"\" style=\"display:none\"></form><script>setAnswer = function(){ var answer = \$(\"#list :radio:checked\").val()+ \":\" + \$(\"#answer1\").val();  \$(\"#answer\").attr(\"value\",answer); sendAnswer();}";
$codeblock_display ="<div class=\"pure-u-1-2\"><div class=\"l-box\"><h3>Darstellungs-Einstellungen</h3><form class=\"pure-form pure-form-aligned\"><fieldset><div class=\"pure-control-group\"><label for=\"representationType\">Darstellung</label><select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\"><option>SWOTAnalyse</option></select></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p><center><p id=\"representationType_image\"><img src=\"images/representationType_swot.png\" height=\"500\"\\\\></p></center></div></div><script>rType = function(type){if(type == \"SWOT-Analyse\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_swot.png\" height=\"500\"\\\\>\\\\'')}}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('6', 'SWOTAnalyse','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// Skalenfrage
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><label for=\"cb\" class=\"pure-checkbox\"><input id=\"cb\" type=\"checkbox\"> Nur eine Antwort pro Teilnehmer m&ouml;glich.</label></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und bestimmen ob ein Teilnehmer &ouml;fters oder nur einmal abstimmen darf.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/bewertungsfrage.png\" height=\"500\"\\\\></p></center></div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"\\\\''+document.getElementById(\"cb\").checked+\\\\''\"}\\\\''}";
$codeblock_mobile ="<form id=\"form\"><label for=\"slider\">(Skala von 0 sehr schlecht bis 10 sehr gut)</label><input type=\"range\" name=\"slider\" id=\"answer\" value=\"5\" min=\"0\" max=\"10\" /><input type=\"button\" value=\"senden\" onClick=\"sendAnswer()\"></form><script>\$(document).ready(function () {});";
$codeblock_display ="<div class=\"pure-u-1-2\"><div class=\"l-box\"><h3>Darstellungs-Einstellungen</h3><form class=\"pure-form pure-form-aligned\"><fieldset><div class=\"pure-control-group\"><label for=\"representationType\">Darstellung</label><select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\"><option>Top10</option><option>WordCloud</option><option>ColumnChart</option></select></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p><center><p id=\"representationType_image\"><img src=\"images/representationType_top10.png\" height=\"500\"\\\\></p></center></div></div><script>rType = function(type){if(type == \"Top10\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_top10.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"WordCloud\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_wordCloud.png\" height=\"500\"\\\\>\\\\'');}else if(type == \"ColumnChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_columnChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('7', 'Skalenfrage','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// Kartenabfrage
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset id=\"form_i\"><div class=\"pure-control-group\"><label for=\"question\">Frage</label><input id=\"question\" type=\"text\" placeholder=\"Was ist Brainstorming?\"></div><label for=\"cb\" class=\"pure-checkbox\"><input id=\"cb\" type=\"checkbox\"> Nur eine Antwort pro Teilnehmer m&ouml;glich.</label></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und bestimmen ob ein Teilnehmer &ouml;fters oder nur einmal abstimmen darf.</p><h3>Beispiel</h3><center><p id=\"type_image\"><img src=\"images/kartenabfrage.png\" height=\"500\"\\\\></p></center></div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"\\\\''+document.getElementById(\"cb\").checked+\\\\''\"}\\\\''}";
$codeblock_mobile ="<form id=\"form\"><input type=\"text\" name=\"fname\" id=\"answer\" placeholder=\"Antwort...\"><input type=\"button\" value=\"senden\" onClick=\"sendAnswer()\"></form><script>";
$codeblock_display ="<div class=\"pure-u-1-2\"><div class=\"l-box\"><h3>Darstellungs-Einstellungen</h3><form class=\"pure-form pure-form-aligned\"><fieldset><div class=\"pure-control-group\"><label for=\"representationType\">Darstellung</label><select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\"><option>Kartenabfrage</option></select></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"><p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gew&uuml;nschte Darstellungsform ausw&auml;hlen.</p><center><p id=\"representationType_image\"><img src=\"images/representationType_kartenabfrage.png\" height=\"500\"\\\\></p></center></div></div><script>rType = function(type){if(type == \"Kartenabfrage\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_kartenabfrage.png\" height=\"500\"\\\\>\\\\'')}}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('8', 'Kartenabfrage','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");

// MultiQuestionSet
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" ><h3>Frage</h3><p>Umfrage-Einstellungen:</p><form class=\"pure-form pure-form-aligned\"><fieldset><div class=\"pure-control-group\" id=\"pollPossibilities\">                <label for=\"poll1\">Interaktion 1</label>                <select id=\"poll1\" class=\"ars-select\"></select><a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deletePoll()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addPoll()\"></i></a></div></fieldset></form><button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zur&uuml;ck</button><button class=\"button blue\" style=\"width:100px;margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button></div></div><div class=\"pure-u-1-2\" style=\"color:grey\"><div class=\"l-box\"></div></div><script>var pollList =\"\";\$.post(\"getData.php\",    	{		  code: \"multiQuestionSet\",		  userID: \$(\"#userID\").val()   		 },function(data,status)		 {      		if (status == \"success\")	  		{		  		console.log(data);				pollList = data;				\$(\"#poll1\").html(data);	  		}	  		else	  		{				\$(\"#message\").html(\"Bei der Datenbanksynchronisation trat ein Fehler auf, versuchen Sie diese Aktion zu einem sp&auml;teren Zeitpunkt nochmals.\");	  		};    	});			var num=\"2\"; addPoll = function(){	console.log(\"addPoll\");	if(\$(\"#pollPossibilities label\").length == 10){}	else{ \$(\"#pollPossibilities\").find(\"a\").remove(); 	\$(\"#pollPossibilities\").append(\\\\''<p><label for=\"polls\">Interaktion \\\\''+num+\\\\''</label><select id=\"poll\\\\''+num+\\\\''\" class=\"ars-select\">\\\\''+pollList+\\\\''</select><a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deletePoll()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addPoll()\"></i></a></p>\\\\''); num = \$(\"#pollPossibilities label\").length+1;}}; deletePoll = function(){if(\$(\"#pollPossibilities label\").length == 1){} else{ num--;\$(\"#pollPossibilities\").children().last().remove(); \$(\"#pollPossibilities\").children().last().append(\\\\''<a href=\"javascript:;\"><i class=\"fa fa-minus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"deletePoll()\"></i></a><a href=\"javascript:;\"><i class=\"fa fa-plus-square-o fa-lg\" style=\"padding-left:10px;\" onClick=\"addPoll()\"></i></a></p>\\\\'');}}; var settings=\"\"; getValues = function(){ var pollPossibilities =\"\"; for( var i=1; i < \$(\"#pollPossibilities label\").length+1; i++){ pollPossibilities = pollPossibilities +\\\\'',\"\\\\''+document.getElementById(\"poll\"+i).value+\\\\''\"\\\\'';}; console.log(pollPossibilities); var pollP = \"[\"+pollPossibilities.substr(1, pollPossibilities.length)+\"]\"; settings=\\\\''{\"pollCount\":\"\\\\''+\$(\"#pollPossibilities label\").length+\\\\''\",\"pollPossibilities\":\\\\''+pollP+\\\\''}\\\\''; console.log(settings);}";
$codeblock_mobile ="<script>\$(document).ready(function () {javascript:location.href=\"showTime2.php?pollPossibilities=\"+settings.pollPossibilities+\"&pollCount=\"+settings.pollCount+\"\";});";
$codeblock_display ="<div class=\"pure-u-1-2\">  <div class=\"l-box\">    <h3>Darstellungs-Einstellungen</h3><p>Die Darstellung muss f&uuml;r die einzelnen Interaktionen extra vorgenommen werden.</p>        <button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zur&uuml;ck</button>    <button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\"></div></div><script>";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('9', 'MultiQuestionSet','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");


// Evaluation 1
/*$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" >    <h3>Frage</h3>    <p>Umfrage-Einstellungen:</p>    <form class=\"pure-form pure-form-aligned\">      <fieldset id=\"form_i\">        <div class=\"pure-control-group\">          <label for=\"question\">Frage</label>          <input id=\"question\" type=\"text\" placeholder=\"Ist Brainstorming sinnvoll?\">        </div>        <div class=\"pure-control-group\">          <label for\"pro\">Pro</label>          <input id=\"pro\" type=\"text\" placeholder=\"ja, pro, true, 1, +, ...\">          <br/>          <label for\"contra\">Contra</label>          <input id=\"contra\" type=\"text\" placeholder=\"nein, contra, false, 0, -, ...\">        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zurück</button>    <button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Umfrage-Einstellungen können Sie Ihre Frage festlegen und die beiden Antwortalternativen festlegen.</p>    <h3>Beispiel</h3>    <center>      <p id=\"type_image\"><img src=\"images/alternativ.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"true\",\"pro\":\"\\\\''+document.getElementById(\"pro\").value+\\\\''\",\"contra\":\"\\\\''+document.getElementById(\"contra\").value+\\\\''\"}\\\\''}";
$codeblock_mobile ="<script>\$(document).ready(function () {javascript:location.href=\"evaluation.php?id=9999\";});";
$codeblock_display ="<div class=\"pure-u-1-2\">  <div class=\"l-box\">    <h3>Darstellungs-Einstellungen</h3>    <form class=\"pure-form pure-form-aligned\">      <fieldset>        <div class=\"pure-control-group\">          <label for=\"representationType\">Darstellung</label>          <select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\">            <option>BarChart</option>            <option>DonutChart</option>          </select>        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zurück</button>    <button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Darstellungs-Einstellungen können Sie die gewünschte Darstellungsform auswählen.</p>    <center>      <p id=\"representationType_image\"><img src=\"images/representationType_barChart.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>rType = function(type){if(type == \"BarChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_barChart.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"DonutChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_donutChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('8', 'Evaluation','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");*/

// Evaluation 2
$codeblock_form = "<div class=\"pure-u-1-2\"><div class=\"l-box\" >    <h3>Frage</h3>    <p>Umfrage-Einstellungen:</p>    <form class=\"pure-form pure-form-aligned\">      <fieldset id=\"form_i\">        <div class=\"pure-control-group\">          <label for=\"question\">Frage</label>          <input id=\"question\" type=\"text\" placeholder=\"Ist Brainstorming sinnvoll?\">        </div>        <div class=\"pure-control-group\">          <label for\"pro\">Pro</label>          <input id=\"pro\" type=\"text\" placeholder=\"ja, pro, true, 1, +, ...\">          <br/>          <label for\"contra\">Contra</label>          <input id=\"contra\" type=\"text\" placeholder=\"nein, contra, false, 0, -, ...\">        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_two_button_back\" onclick=\"change_view(\\\\''view_two_button_back\\\\'')\">zurück</button>    <button class=\"button blue\" style=\"width:100px;  margin-left:200px;\" id=\"view_two_button\" onclick=\"change_view(\\\\''view_two_button\\\\''); ; getValues()\">weiter</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Umfrage-Einstellungen k&ouml;nnen Sie Ihre Frage festlegen und die beiden Antwortalternativen festlegen.</p>    <h3>Beispiel</h3>    <center>      <p id=\"type_image\"><img src=\"images/alternativ.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>var settings=\"\"; getValues = function(){ settings=\\\\''{\"only_one_answer\":\"true\",\"pro\":\"\\\\''+document.getElementById(\"pro\").value+\\\\''\",\"contra\":\"\\\\''+document.getElementById(\"contra\").value+\\\\''\"}\\\\''}";
$codeblock_mobile ="<script>\$(document).ready(function () {javascript:location.href=\"evaluation2.php?id=9999\";});";
$codeblock_display ="<div class=\"pure-u-1-2\">  <div class=\"l-box\">    <h3>Darstellungs-Einstellungen</h3>    <form class=\"pure-form pure-form-aligned\">      <fieldset>        <div class=\"pure-control-group\">          <label for=\"representationType\">Darstellung</label>          <select id=\"representationType\" class=\"ars-select\" onChange=\"rType(this.value)\">            <option>BarChart</option>            <option>DonutChart</option>          </select>        </div>      </fieldset>    </form>    <button class=\"button blue\" style=\"width:100px;\" id=\"view_three_button_back\" onclick=\"change_view(\\\\''view_three_button_back\\\\'')\">zurück</button>    <button class=\"button blue\" style=\"width:100px; margin-left:200px;\" id=\"send\" onclick=\"change_view(\\\\''send\\\\'')\">erstellen</button>  </div></div><div class=\"pure-u-1-2\" style=\"color:grey\">  <div class=\"l-box\">    <p>In den Darstellungs-Einstellungen k&ouml;nnen Sie die gewünschte Darstellungsform auswählen.</p>    <center>      <p id=\"representationType_image\"><img src=\"images/representationType_barChart.png\" height=\"500\"\\\\></p>    </center>  </div></div><script>rType = function(type){if(type == \"BarChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_barChart.png\" height=\"500\"\\\\>\\\\'')}else if(type == \"DonutChart\"){\$(\"#representationType_image\").html(\\\\''<img src=\"images/representationType_donutChart.png\" height=\"500\"\\\\>\\\\'');}};";
mysqli_query($con,"INSERT INTO question_types (id, name, codeblock_form, codeblock_mobile, codeblock_display) VALUES ('10', 'Evaluation2','".$codeblock_form."','".$codeblock_mobile."','".$codeblock_display."')");



// Erstellt die Tabelle interactions
$sql="CREATE TABLE interactions (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    type VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    password TEXT,
    presentation VARCHAR(100) NOT NULL,
    presentation_id INT NOT NULL,
    date VARCHAR(100) NOT NULL,
    slide VARCHAR(100) NOT NULL,
    slide_id INT NOT NULL,
    question TEXT,
    settings TEXT,
    representation_type VARCHAR(100),
    qr_slide INT,
    representation_slide INT
);";

// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) 
{
  $message = "Table interactions created successfully";
} 
else 
{
  $message = "Error creating table interactions: " . mysqli_error($con);
}

// Erstellt die Tabelle answers
$sql="CREATE TABLE answers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    interactions_id INT NOT NULL,
    answer TEXT,
    ip TEXT,
    os TEXT,
    hostname TEXT,
    all_info TEXT,
    country TEXT,
    date TEXT
    );";

// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) 
{
  $message = "Table answers created successfully";
} 
else 
{
  $message = "Error creating table answers: " . mysqli_error($con);
}

// Erstellt die Tabelle representation_types
$sql="CREATE TABLE representation_types (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    codeblock_representation_type TEXT
    );";

// Führt SQL-Abfrage aus
if (mysqli_query($con,$sql)) 
{
  $message = "Table representation_types created successfully";
} 
else 
{
  $message = "Error creating table representation_types: " . mysqli_error($con);
}

// Fügt Daten in die Tabelle ein (Darstellungstypen)
// WordCloud
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('1', 'WordCloud', '<center> <div id=\"tagCloud\" style=\"height:400px; width:800px; border:solid 2px; border-color:rgb(73,173,255); position:absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: -200px;\"></div> </center> <script> $(document).ready(function () { refreshTags(); }); $.fn.tagcloud.defaults = { size: {start: 10, end: 60, unit: \"pt\"}, color: {start: \"#cde\", end: \"#f52\"} }; refreshTags = function() { $.post(\"getData.php\", { code: \"answers\", interaction_id: interaction_id },function(data,status) { if (status == \"success\") { console.log(\"success\"); console.log(data); $(\"#tagCloud\").html(''<div id=\"tags\" style=\"width:800px\">''+data+''</div>''); $(\"#tags a\").tagcloud(); } else { }; }); setTimeout(\"refreshTags()\",1000); } </script>');");

// Top10
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('2', 'Top10', '<center><div id=\"top10\" style=\"height:400px; width:800px; position:absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: -200px;\"><table id=\"table\" class=\"display\"> </table></div></center> <script>var oldData; \$(document).ready(function () {\$(''#table'').DataTable({        \"columns\": [            { \"title\": \"Rang\" },            { \"title\": \"Antwort\" },            { \"title\": \"Anzahl\" }        ],pageLength: 10,        lengthChange: false,        searching: false,        ordering:  false    }); refreshTable(); }); refreshTable = function() { \$.post(\"getData.php\", { code: \"answers_top10\", interaction_id: interaction_id },function(data,status) { if (status == \"success\") {if(oldData != data){var table = \$(''#table'').DataTable();table.clear().draw();table.rows.add(eval(data)).draw();} oldData = data;}else { }; }); setTimeout(\"refreshTable()\",1000); } </script>');");

// DonutChart
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('3', 'DonutChart', '<center id=\"stat\"><div id=\"circleStat\" data-dimension=\"400\" data-text=\"35%\" data-info=\"New Clients\" data-width=\"30\" data-fontsize=\"38\" data-total=\"100\" data-part=\"50\" data-fgcolor=\"#61a9dc\" data-bgcolor=\"#eee\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -200px; margin-top: -200px;\"></div></center>    <script>$(document).ready(function () {   refreshTags();});var olddata =\"\";refreshTags = function(){    $.post(\"getData.php\",      {      code: \"answers_donutGraph\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {        console.log(\"success\");        console.log(data);        console.log(olddata);        var val = jQuery.parseJSON(data);                if(data != olddata)        {        $(\"#circleStat\").remove();        $(\"#stat\").append(''<div id=\"circleStat\" data-dimension=\"400\" data-text=\"35%\" data-info=\"New Clients\" data-width=\"30\" data-fontsize=\"38\" data-total=\"100\" data-part=\"50\" data-fgcolor=\"#61a9dc\" data-bgcolor=\"#eee\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -200px; margin-top: -200px;\"></div>''); if(typeof val[val[1]] == \"undefined\") {var part1 = 0;} else { var part1 = parseInt(val[val[1]]);} if(typeof val[val[2]] == \"undefined\") {var part2 = 0;} else { var part2 = parseInt(val[val[2]]);} var total = part1+part2;        console.log(total); if(typeof val[1] == \"undefined\") {var text1 = \"ja\";} else { var text1 = val[1];} if(typeof val[2] == \"undefined\") {var text2 = \"nein\";} else { var text2 = val[2];}   if(((part1/total)*100).toFixed(2) == \"NaN\") {var percentage = 0;} else { var percentage = ((part1/total)*100).toFixed(2);}    $(\"#circleStat\").attr(\"data-info\",\"\"+part1+\" \"+text1+\"  : \"+part2+\" \"+text2+\" \");        $(\"#circleStat\").attr(\"data-text\",\"\"+percentage+\"% - \"+text1+\"\");        $(\"#circleStat\").attr(\"data-total\",\"\"+total+\"\");        $(\"#circleStat\").attr(\"data-part\",\"\"+part1+\"\");        $(\"#circleStat\").circliful();        }        olddata = data;        }        else        {        };      });setTimeout(\"refreshTags()\",5000);   }</script>');");

// BarChart
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('4', 'BarChart', '<center><div id=\"container\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -200px; margin-top: -200px;\"></div></center>    <script>$(document).ready(function () {   refreshTags();});var olddata =\"\";refreshTags = function(){    $.post(\"getData.php\",      {      code: \"answers_donutGraph\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {        console.log(\"success\");        console.log(data);        console.log(olddata);        var val = jQuery.parseJSON(data);        console.log(Object.keys(val).length);        var categories=\"\";                var series =\"\";        for(i=1;i<(Object.keys(val).length)/2+1;i++)        {                 categories = categories +'',\"''+val[i]+''\"'';                 series = series + \",\"+parseInt(val[val[i]]);        }        categories = \"[\"+categories.substr(1, categories.length)+\"]\";        series = series.substr(1, series.length);        console.log(categories);        console.log(series);        if(data != olddata)        {        $(\"#container\").highcharts({        chart: {            type: \"bar\"        },        title: {            text: \"\"        },        xAxis: {            categories: eval(\"(\" + categories + \")\")        },        yAxis: {tickInterval:1,            min: 0,            title: {                text: \"Anzahl\"            }        },        legend: {            reversed: true        },        plotOptions: {            series: {                stacking: \"normal\"            }        },        series: [{            data: eval(\"[\" + series + \"]\")        }]    });                }        olddata = data;        }        else        {        };      });setTimeout(\"refreshTags()\",5000);   }</script>');");


// PieChart
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('5', 'PieChart', '<center><div id=\"container\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -200px; margin-top: -200px;\"></div></center>    <script>$(document).ready(function () {   refreshTags();});var olddata =\"\";refreshTags = function(){    $.post(\"getData.php\",      {      code: \"answers_donutGraph\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {        console.log(\"success\");        console.log(data);        console.log(olddata);        var val = jQuery.parseJSON(data);        console.log(Object.keys(val).length);        var categories=\"\";                var series =\"\";        for(i=1;i<(Object.keys(val).length)/2+1;i++)        {         series = series +'',[\"''+val[i]+''\"''+\",\"+parseInt(val[val[i]])+\"]\"        }        series = series.substr(1, series.length);        console.log(series);        if(data != olddata)        {        $(\"#container\").highcharts({        chart: {            type: \"pie\"        },        title: {            text: \"\"        },        legend: {            reversed: true        },        plotOptions: {            series: {                stacking: \"normal\"            }        },        series: [{            data: eval(\"[\" + series + \"]\")        }]    });                }        olddata = data;        }        else        {        };      });setTimeout(\"refreshTags()\",5000);   }</script>');");

// ProContra Liste
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('6', 'ProContraListe', '<center><div id=\"top10pro\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: -200px;\"><table class=\"pure-table pure-table-horizontal\">    <thead><h2>Pro</h2>        <tr>            <th>Rang</th>            <th>Antwort</th>      <th>Anzahl</th>        </tr>    </thead>    <tbody id=\"tbody\">    </tbody></table></div><div id=\"top10contra\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: 0px; margin-top: -200px;\"><table class=\"pure-table pure-table-horizontal\">    <thead><h2 style=\"color:red\">Contra</h2>        <tr>            <th>Rang</th>            <th>Antwort</th>      <th>Anzahl</th>        </tr>    </thead>    <tbody id=\"tbody2\">    </tbody></table></div></center><script>$(document).ready(function () {    refreshTable();});refreshTable = function(){  $.post(\"getData.php\",      {      code: \"answers_top10Pro\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {        $(\"#tbody\").html(\"\"+data+\"\");        }        else        {        };      });      $.post(\"getData.php\",      {      code: \"answers_top10Contra\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {        $(\"#tbody2\").html(\"\"+data+\"\");        }        else        {        };      }); setTimeout(\"refreshTable()\",1000);    }</script>');");

// SWOT Analyse
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('7', 'SWOTAnalyse', '<center><div id=\"top10s\" style=\"height:250px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: -250px; border-bottom: 1px solid black; border-right: 1px solid black;\"><table class=\"pure-table pure-table-horizontal\">    <thead><h2>Strengths (Stärken)</h2>        <tr>            <th>Rang</th>            <th>Antwort</th>      <th>Anzahl</th>        </tr>    </thead>    <tbody id=\"tbody\">    </tbody></table></div><div id=\"top10w\" style=\"height:250px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: 0px; margin-top: -250px; border-bottom: 1px solid black; border-left: 1px solid black;\"><table class=\"pure-table pure-table-horizontal\">    <thead><h2 style=\"color:orange\">Weaknesses (Schwächen)</h2>        <tr>            <th>Rang</th>            <th>Antwort</th>     <th>Anzahl</th>        </tr>    </thead>    <tbody id=\"tbody2\">    </tbody></table></div><div id=\"top10o\" style=\"height:250px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -400px; margin-top: 0px; border-top: 1px solid black; border-right: 1px solid black;\"><table class=\"pure-table pure-table-horizontal\">    <thead><h2 style=\"color:green\">Opportunities (Chancen)</h2>        <tr>            <th>Rang</th>            <th>Antwort</th>      <th>Anzahl</th>        </tr>    </thead>    <tbody id=\"tbody3\">    </tbody></table></div><div id=\"top10t\" style=\"height:250px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: 0px; margin-top: 0px; border-top: 1px solid black; border-left: 1px solid black;\"><table class=\"pure-table pure-table-horizontal\">    <thead><h2 style=\"color:red\">Threats (Gefahren)</h2>        <tr>            <th>Rang</th>            <th>Antwort</th>     <th>Anzahl</th>        </tr>    </thead>    <tbody id=\"tbody4\">    </tbody></table></div></center><script>$(document).ready(function () {   refreshTable();});refreshTable = function(){  $.post(\"getData.php\",     {     code: \"answers_swot1\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {       $(\"#tbody\").html(\"\"+data+\"\");       }       else        {       };      });     $.post(\"getData.php\",     {     code: \"answers_swot2\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {       $(\"#tbody2\").html(\"\"+data+\"\");        }       else        {       };      });     $.post(\"getData.php\",     {     code: \"answers_swot3\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {       $(\"#tbody3\").html(\"\"+data+\"\");        }       else        {       };      });           $.post(\"getData.php\",     {     code: \"answers_swot4\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {       $(\"#tbody4\").html(\"\"+data+\"\");        }       else        {       };      });     setTimeout(\"refreshTable()\",1000);    }</script>');");

// ColumnChart
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('8', 'ColumnChart', '<center><div id=\"container\" style=\"height:400px; width:400px; position:absolute; left: 50%; top: 50%; margin-left: -200px; margin-top: -200px;\"></div></center>    <script>\$(document).ready(function () {   refreshTags();});var olddata =\"\";refreshTags = function(){    \$.post(\"getData.php\",      {      code: \"answers_columnGraph\",      interaction_id: interaction_id       },function(data,status)     {          if (status == \"success\")        {        console.log(\"success\");        console.log(data);        console.log(olddata);        eval(data);        console.log(b); if(data != olddata)        {        \$(\"#container\").highcharts({        chart: {            type: \"column\"        },        title: {            text: \"\"        },        xAxis: {            categories: eval(\"[\"+a+\"]\")        },        yAxis: {tickInterval:1,            min: 0,            title: {                text: \"Anzahl\"            }        },        legend: {            reversed: true        },        plotOptions: {            series: {                stacking: \"normal\"            }        },        series: [{ name:\"Bewertung\",           data: eval(b)         }]    });                }        olddata = data;        }        else        {        };      });setTimeout(\"refreshTags()\",5000);   }</script>');");

// Kartenabfrage
$codeblock_representation_type = "<script>$(document).ready(function () {javascript:location.href='kartenabfrage.php?preview=true&interaction_id='+interaction_id});</script>";
mysqli_query($con,"INSERT INTO representation_types (id, name, codeblock_representation_type) VALUES ('9', 'Kartenabfrage', '".addslashes($codeblock_representation_type)."')");

// Fügt Testdaten dem Testnutzer Admin hinzu
mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('1', 'Fußball 1', 'Freitextfrage', '1', '', 'Präsentation 1', '0', '1417780179760', '0', '0', 'Was fällt Ihnen zum Thema Fußball ein?', '{\"type\":\"Text\", \"only_one_answer\":\"false\",\"from\":\"\",\"till\":\"\"}', 'Top10', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('2', 'Fußball 2', 'Freitextfrage', '1', '', 'Präsentation 1', '0', '1417780238306', '0', '0', 'Wann gewann Deutschland einen WM-Titel?', '{\"type\":\"Datum\", \"only_one_answer\":\"false\",\"from\":\"\",\"till\":\"\"}', 'WordCloud', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('3', 'Fußball 3', 'Freitextfrage', '1', '', 'Präsentation 1', '0', '1417780295097', '0', '0', 'Mit wieviel Jahren haben SIe begonnen Fußball zu spielen?', '{\"type\":\"Zahl\", \"only_one_answer\":\"false\",\"from\":\"0\",\"till\":\"120\"}', 'WordCloud', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('4', 'Fußball 4', 'Alternativfrage', '1', '', 'Präsentation 1', '0', '1417780368763', '0', '0', 'Gefällt Ihnen Fußball?', '{\"only_one_answer\":\"true\",\"pro\":\"ja\",\"contra\":\"nein\"}', 'DonutChart', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('5', 'Fußball 5', 'MultipleChoice', '1', '', 'Präsentation 1', '0', '1417780368763', '0', '0', 'Welcher Fußballspieler stand bei der WM 2014 im deutschen Tor?', '{\"only_one_answer\":\"true\",\"answerCount\":\"4\",\"answerPossibilities\":[\"Manuel Neuer\",\"Oliver Kahn\",\"Philipp Lahm\",\"Thomas Müller\"]}', 'BarChart', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('6', 'Fußball 6', 'ProContraListe', '1', '', 'Präsentation 1', '0', '1417780481312', '0', '0', 'Was gefällt Ihnen an Fußball und was nicht?', '{\"only_one_answer\":\"false\"}', 'ProContraListe', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('7', 'Fußball 7', 'SWOTAnalyse', '1', '', 'Präsentation 1', '0', '1417780531128', '0', '0', 'Thema Fußball', '{\"only_one_answer\":\"false\"}', 'SWOTAnalyse', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('8', 'Fußball 8', 'Skalenfrage', '1', '', 'Präsentation 1', '0', '1417780555068', '0', '0', 'Wie sinnvoll halten Sie Fußball?', '{\"only_one_answer\":\"false\"}', 'ColumnChart', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('9', 'Fußball 9', 'Kartenabfrage', '1', '', 'Präsentation 1', '0', '1417780588505', '0', '0', 'Thema Fußball', '{\"only_one_answer\":\"false\"}', 'Kartenabfrage', '0', '0')");

mysqli_query($con,"INSERT INTO interactions (id, title, type, user_id, password, presentation, presentation_id, date, slide, slide_id, question, settings, representation_type, qr_slide, representation_slide) VALUES ('10', 'Fußball 10', 'MultiQuestionSet', '1', '', 'Präsentation 1', '0', '1417780624731', '0', '0', 'Thema Fußball', '{\"pollCount\":\"3\",\"pollPossibilities\":[\"1\",\"2\",\"3\"]}', '', '0', '0')");




// Erstellt die Konfigurationsdatei mit den eingegebenen Daten
if($overwrite == "on")
{
$datei = fopen("includes/psl-config.php","w");
fwrite($datei, '<?php

/** 
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This file contains global configuration variables
 * Things like whether anyone can register.
 * 
 * Whether or not its a secure (https) connection could
 * also go here...
 */

/**
 * These are the database login details
 */
define("HOST", "'.$host.'"); 			// The host you want to connect to. 
define("USER", "'.$user.'"); 			// The database username. 
define("PASSWORD", "'.$password.'"); 	// The database password. 
define("DATABASE", "'.$database.'");    // The database name.
define("URL", "'.$url.'");				// The url.
define("MAIL", "'.$email.'");		// The E-Mail.

/**
 * Who can register and what the default role will be
 * Values for who can register under a standard setup can be:
 *      any  == anybody can register (default)
 *      admin == members must be registered by an administrator
 *      root  == only the root user can register members
 * 
 * Values for default role can be any valid role, but its hard to see why
 * the default "member" value should be changed under the standard setup.
 * However, additional roles can be added and so theres nothing stopping
 * anyone from defining a different default.
 */
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

/**
 * Is this a secure connection?  The default is FALSE, but the use of an
 * HTTPS connection for logging in is recommended.
 * 
 * If you are using an HTTPS connection, change this to TRUE
 */
define("SECURE", FALSE);    // For development purposes only!!!!

');
fclose($datei);
}

// Gibt Ergebnisseite aus
echo '
<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Initialize</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>

    <!-- CSS-Files -->
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
<center><p id="infoText"><p>'.$message.'</p>
<p>Host: '.$host.'</p>
<p>User: '.$user.'</p>
<p>Password: '.$password.'</p>
<p>Database: '.$database.'</p>
<p>URL: '.$url.'</p>
<p>URL: '.$email.'</p>
<button class="button white" style="width:300px;" onclick="javascript:location.href=\'login.php\'">weiter</button>
</center>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>';
mysqli_close($con);
?>
