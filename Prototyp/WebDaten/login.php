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
 * Die login.php ist die Startseite in PowerPoint und wird auch bei der Manifest-Datei angegeben. Es wird zunächst überprüft ob der nutzer bereits angemeldet ist
 * Sind im localStorage die AnmeldeDaten hinterlegt wird der Nutzer automatisch eingeloggt und wird zum menu.php weitergeleitet nachdem die Daten in der process_login2.php
 * überprüft wurden, dies geschiet in der document(ready) Funktion. Ansonsten kann sich der Nutzer ganz normal über die Input-Felder per E-Mail und Passwort anmelden. Die
 * eingegebenen Daten werden zunächst gehashed und dann per POST Methode an process_login.php gesendet.
 */ 
 
// Bindet die nötigen PHP-Files ein  
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

// Startet Session
sec_session_start();

// Überprüft ob user eingeloggt oder nicht
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Login</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
    <script src="js/app.js" type="text/javascript"></script>
    <script src="js/audienceResponseSystem.js" type="text/javascript"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script> 

    <!-- CSS-Files -->
    <!-- <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400" rel="stylesheet" /> -->
	 <link href="css/fonts_googleapis.css" rel="stylesheet" type="text/css" />
    <link href="css/office.css" rel="stylesheet" type="text/css" />
    <link href="css/app.css" rel="stylesheet" type="text/css" />
    <link href="css/login.css" rel="stylesheet" type="text/css" /> 
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />   
</head>
<body>
<style>
#title {
  font-size: 50px;
  font-family: "Source Sans Pro", helvetica, sans-serif;
  color: white;
}
</style>
<!-- Page-Start -->
<div id="page">

<!-- Header-Start -->
<div id="header"><a href="http://www.fzi.de/startseite/"><img src="images/fzi-logo-c.png"/></a></div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">
<center>
<p><img src="images/Inta-Logo.png" height="140"\><br \><small style="font-size:20px">- Interactive Talk -<br \>(A mobile Audience Response System)</small></p>
</center>
<center><?php if (isset($_GET['error'])) {echo '<p class="error" style="color:white">Beim einloggen trat ein Fehler auf, bitte &uuml;berpr&uuml;fen Sie Ihre Eingabe!</p>';}?></center>
    <div id="form">
        <center><h1>Anmelden</h1>
            <form action="includes/process_login.php" method="post" name="login_form" class="ars-form ars-form-stacked">

                <fieldset class="ars-group">

                    <input type="email" name="email" placeholder="E-Mail" id="email" class="textInput" size="50"/>

                    <input type="password" name="password" placeholder="Kennwort" id="password" class="textInput" />

                </fieldset>

                <button type="submit" id="submit" class="button blue" style="width:300px;" onclick="formhash(this.form, this.form.password)">Anmelden</button>

            </form>
        </center>
        <div style="text-align:left; width:200px; padding-left:15px; padding-top:15px; float:left"><a href="login_fail.php">Kennwort vergessen?</a></div><div style="text-align:right; width:100px; padding-right:15px; padding-top:15px; float:right;"><a href="register.php">Registrieren</a></div>
    </div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><div id="console" style="color:black; float:left"></div><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
<script type="text/javascript">
$(document).ready(function () 
{
var email = localStorage.getItem("email");
var p = localStorage.getItem("p");
if ((email == null) || (email == "") || (typeof email == "undefined") || (p == null) || (p == "") || (typeof p == "undefined"))
{}
else
{
	parent.location.href = "includes/process_login2.php?email="+localStorage.getItem('email')+"&p="+localStorage.getItem('p');
}
});
</script>
</html>
