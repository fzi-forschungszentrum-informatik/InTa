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
 * Die menu.php zeigt lediglich die Programm Punkte an und verlinkt zu diesen. Hier wird wie bei den anderen Seiten auch überprüft ob der Nutzer eingeloggt ist oder nicht
 * falls nicht wird er an die login.php verwiesen. Im oberen Teil wird noch der Nutzername angezeigt, dieser ist in der Session gespeichert.
 */

// Bindet die nötigen PHP-Files ein  
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// Startet die PHP-Session
sec_session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Menu</title>
    
    <!-- JavaScript-Files -->
	<!-- Test -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script>-->
    <!-- <script src="js/office.js" type="text/javascript"></script>  -->
	<script src="js/app.js" type="text/javascript"></script>
    <script src="js/audienceResponseSystem.js" type="text/javascript"></script>

    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />   
</head>

<body>
<?php if (login_check($mysqli) == true) : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.php'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;">Herzlich Willkommen, <?php echo htmlentities($_SESSION['username']); ?> !</div><a href="javascript:;" style="color:white; float:right" onClick="logout();">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="content"><a href="javascript:;"><div id="create" class="menuItem blue" style="margin-left: -370px;" onclick="javascript:location.href='create.php'"><span class="fa fa-file-text-o fa-4x" style="padding-top:50px;"></span><p style="color:white;">Erstellen</p></div></a><a href="javascript:;"><div id="overview" class="menuItem blue" style="margin-left: -170px;" onclick="javascript:location.href='overview.php'"><span class="fa fa-table fa-4x" style="padding-top:50px;"></span><p style="color:white;">&Uuml;bersicht</p></div></a><a href="javascript:;"><div id="tutorial" class="menuItem blue" style="margin-left: 30px;" onclick="javascript:location.href='tutorial.php'"><span class="fa fa-book fa-4x" style="padding-top:50px;"></span><p style="color:white;">Tutorial</p></div></a><a href="javascript:;"><div id="settings" class="menuItem blue" style="margin-left: 230px;" onclick="javascript:location.href='settings.php'"><span class="fa fa-cog fa-4x" style="padding-top:50px;"></span><p style="color:white;">Einstellungen</p></div></a></div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><div id="appMode"></div></div><!-- Footer-End -->

</div> <!-- Page-End -->
<?php else : ?>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"></div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">
<center>Sie haben nicht die Berechtigung f&uuml;r diese Seite.<br/>Loggen Sie sich bitte zuerst <a onClick="logout();">hier</a> ein.</center>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><div id="console" style="color:black; float:left"></div><a href="javascript:;"><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></a></div><!-- Footer-End -->
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