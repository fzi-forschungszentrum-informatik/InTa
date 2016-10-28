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
 * Die setting.php dient zum löschen des Accounts oder zum ändern der Nutzerdaten wie Passwort oder E-Mail, hierbei werde zunächst die Nutzerdaten aus der Datenbank
 * geladen, zu der in der aktuellen Session hinterlegten Nutzerid, die Nutzerdaten werden dann in die Formularfelder eingesetzt. Diese können vom Nutzer geändert werden
 * und werden gegebenenfalls wieder in die Datenbank geschrieben. Falls der Nutzer sein Account löscht wird der vorgang zu Sicherheit nochmals abgefragt und anschließend
 * die SQL-Query in setData unter dem code deleteM ausgeführt. Dabei werden auch alle Interaktionen und mit diesen verbundenen Antworten gelöscht.
 */

// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
// Startet die Session
sec_session_start();
// SQL-Query
$sql = 'SELECT * FROM members WHERE id='.htmlentities($_SESSION['user_id']);
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
while($row = $result->fetch_assoc())
{
	$id = $row['id'];
	$name = $row['username'];
	$email = $row['email'];
	$password = $row['password'];
	$salt = $row['salt'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Einstellungen</title>
    
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
<div id="header"><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.php'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;"><?php echo htmlentities($_SESSION['username']); ?></div><a href="javascript:;" style="color:white; float:right" onclick="logout()">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a> | <a style="color:white;" href="settings.php">Einstellungen</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">

<div class="pure-g" id="view_one" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Einstellungen</h3>
            <p>Nutzerinformation:
            </p>
            <form class="pure-form pure-form-aligned">
    		<fieldset>
            <div class="pure-control-group">
                <label for="id">ID</label>
                <input id="id" type="text" value="<?php echo $id; ?>" disabled>
            </div>
            
            <div class="pure-control-group">
                <label for="name">Nutzername</label>
                <input id="name" type="text" value="<?php echo $name; ?>">
            </div>
            
            <div class="pure-control-group">
                <label for="mail">E-Mail</label>
                <input id="mail" type="text" value="<?php echo $email; ?>">
            </div>
            
            <div class="pure-control-group">
            	<label for="password">Passwort</label>
            	<input id="password" type="text" placeholder="neues passwort">
        	</div>
        	</fieldset>
			</form>
			<button class="button blue" style="width:100px;" id="change" onclick="changeM()">&auml;ndern</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <div id="deleteAccount"><p id="firstMessage">Sie k&ouml;nnen auch Ihren ganzen Account l&ouml;schen. Dadurch werden jedoch all Ihre Interaktionen und deren Antworten unwiderruflich gel&ouml;scht.<br \><br \>
    <button class="button red" style="width:200px;" onclick="$('#firstMessage').hide(); $('#secondMessage').show();">Account l&ouml;schen</button></p>
    <p id="secondMessage">Sind Sie sicher, dass Sie Ihren Account l&ouml;schen m&ouml;chten?<br \><br \><button class="button red" style="width:200px;" onclick="deleteAccount()">Ja</button> <button class="button red" style="width:200px; padding-left:10px" onclick="$('#secondMessage').hide(); $('#firstMessage').show();">Nein</button></p>
    </div>
    </div>
    </div>
    </div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->

</div> <!-- Page-End -->
<script>
$(document).ready(function () 
{
	$('#secondMessage').hide();
})
function changeM()
{
$.post("setData.php",
    	{
		  code: "changeM",
		  id: $("#id").val(),
		  username: $("#name").val(),
		  email: $("#mail").val(),
		  password:$("#password").val(),
		  salt:"<?php echo $salt; ?>"
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
				console.log("Alles OK");
				logout();
	  		}
	  		else
	  		{
				console.log("Fehler");
	  		};
    	});
}

function deleteAccount()
{
	$.post("setData.php",
    	{
		  code: "deleteM",
		  id: $("#id").val()
   		 },function(data,status)
		 {
      		if (status == "success")
	  		{
				console.log("Alles OK"+data);
				logout();
	  		}
	  		else
	  		{
				console.log("Fehler");
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