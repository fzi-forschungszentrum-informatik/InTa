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
 * Die inizialize.php dient zur Erstellung der Datenbank und den Server-Einstellungen. Zunächst werden die Lese- und Schreibrechte der psl-config.php überprüft.
 * Diese Rechte werden benötigt, falls nicht vorhanden wird der Nutzer daraufhingewiesen. Anschließend folgt ein Formular welches der Nutzer ausfüllen kann.
 * Mit HOST, USER, PASSWORT, DATABASE, URL und EMAIL. Dann kann der Nutzer noch angeben ob die Konfigurations-Datei psl-config mit den eingegebenen Werten
 * überschrieben werden soll oder ob einfach die setDatabase.php aufgerufen werden soll um die Datenbak zu überschreiben. Die Daten werden per POST-Methode an
 * die setDatabase.php übergeben.
 */
?> 
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
<center><p id="infoText"><h1><b style="color:white;">Initialisierung</b></h1><p style="color:red">
<?php
// Überprüft die Dateirechte von psl-config.php
$perms = fileperms('includes/psl-config.php');

if (($perms & 0xC000) == 0xC000) {
    // Socket
    $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
    // Symbolischer Link
    $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
    // Regulär
    $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
    // Block special
    $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
    // Verzeichnis
    $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
    // Character special
    $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
    // FIFO pipe
    $info = 'p';
} else {
    // Unknown
    $info = 'u';
}

// Besitzer
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

// Gruppe
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

// Andere
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));

// Falls keine Schreib- und Leserechte erlaubt sind wird der Nutzer darauf hingewiesen
if(substr($info,0,3) =="-r-")
{echo "Bitte ändern Sie die Rechte f&uuml;r psl-config.php auf lesen und schreiben!";}
?>
</p><p>Diese Seite dient dazu, die Applikation auf dem Server einzurichten.</p><p>Dabei wird die Datenbank und die Konfigurationsdatei mit den entsprechenden Einstellugnen angelegt<br />Beachten Sie bitte, dass eventuell vorhandene Daten &uuml;berschrieben werden!</p></center>
    <div id="form" style="width: 600px; height: 400px; position:absolute; left: 50%; top: 50%; margin-left: -300px; margin-top: -100px;">
        <center><h2 style="color:black">Server-Einstellungen</h2>
            <form action="setDatabase.php" method="post" class="ars-form ars-form-stacked">

                <fieldset class="ars-group">

                    <input type="text" name="host" placeholder="HOST" id="host" class="textInput" title="Der Host mit dem Sie sich verbinden wollen."/>
                    <input type="text" name="user" placeholder="USER" id="user" class="textInput" title="Der Datenbank User-Name."/>
                    <input type="text" name="password" placeholder="PASSWORD" id="password" class="textInput" title="Das Password der Datenbank."/>
                    <input type="text" name="database" placeholder="DATABASE" id="database" class="textInput" title="Der Name der Datenbank."/>
                    <input type="text" name="url" placeholder="URL (ex http://www.mysite.de/)" id="url" class="textInput" title="Die URL der Website."/>
                    <input type="email" name="email" placeholder="Server E-Mail (ex email@domain.de)" id="email" class="textInput" title="Die E-Mail der Website."/>

                </fieldset>
                <p style="color:black"><input type="checkbox" name="overwrite" id="overwrite" class="checkbox" title="Config-Datei überschreiben."/> Config-Datei &uuml;berschreiben</p>
                <button type="submit" class="button blue" style="width:300px;">Anlegen</button>

            </form>
        </center>
        </div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>

