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
 * Die register.php dient zum Registrieren am System. Dabei wird Nutzername, E-Mail und zweimal das Passwort abgefragt. Die eingegebenen Informationen werden von 
 * der register.inc.php und der functions.php überprüft. (Ob Daten schon vorhanden und korrekt)
 */
 
// Bindet die n&ouml;tigen PHP-Files ein 
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Register</title>
    
    <!-- JavaScript-Files -->
    <script src="js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script>
	<!-- <script src="js/office.js" type="text/javascript"></script> -->
    <script src="js/app.js" type="text/javascript"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>

    <!-- CSS-Files -->
    <link href="css/office.css" rel="stylesheet" type="text/css" />
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
<center><p id="infoText">Hier k&ouml;nnen Sie sich f&uuml;r den Service registrieren.<br/> F&uuml;llen Sie einfach das untere Formular aus<br/>und best&auml;tigen Sie Ihre Eingabe durch den Registrieren-Button.</p><p>Beachten Sie dabei bitte folgendes:<br/>Der Nutzername darf nur aus Groß- und Kleinbuchstaben bestehen. Und weder Leer- noch Sonderzeichen beinhalten.<br/>Das Kennwort muss aus mindestens 6 Zeichen bestehen und mindestens einen Groß-, einen Kleinbuchstaben und eine Zahl beinhalten.</p></center>
    <div id="form" style="height:300px; margin-top: -50px;">
        <center><h1>Registrieren</h1>
        <form class="ars-form ars-form-stacked" method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
            <fieldset class="ars-group">
            <input type="text" placeholder="Nutzername" id="username" name="username" maxlength="30" class="textInput" />
            <input type="email" placeholder="E-Mail" id="email" name="email" maxlength="50" class="textInput" />
            <input type="password" placeholder="Kennwort" id="password" name="password" class="textInput" />
            <input type="password" placeholder="Kennwort bestätigen" id="confirmpwd" name="confirmpwd" class="textInput" />
            </fieldset>
            <button type="submit" id="submit" class="button blue" style="width:300px;" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);">Registrieren</button>
        </form>
        </center>
         <div style="text-align:right; width:100px; padding-right:15px; padding-top:15px; float:right;"><a href="login.php">zur&uuml;ck</a></div>
    </div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>
