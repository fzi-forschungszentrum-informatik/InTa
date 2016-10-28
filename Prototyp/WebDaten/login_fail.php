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
 * Die login_fail.php wird angezeigt, falls der Nutzer sein Passwort vergessen hat und kann sich dieses neu zuschicken lassen. Dazu muss er eine E-Mail Adresse angeben
 * Diese wird per GET Methode an loginFail.php weiter gegeben.
 */

// Bindet die nötigen PHP-Files ein  
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
    <!-- <script src="https://appsforoffice.microsoft.com/lib/1.1/hosted/office.js" type="text/javascript"></script> -->
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
<center><p id="infoText">Sie haben Ihr Kennwort vergessen? Geben Sie bitte Ihre E-Mail Adresse an und wir schicken Ihnen ein neues Kennwort zu. Bitte &auml;ndern Sie dieses sofort.</p></center>
    <div id="form" style="height:200px; margin-top: -50px;">
        <center><h1>Kennwort vergessen</h1>
        <form class="ars-form ars-form-stacked" method="get" name="loginFail_form" action="loginFail1.php">
            <fieldset class="ars-group">
            <input type="email" placeholder="E-Mail" id="email" name="email" maxlength="50" class="textInput" />
            </fieldset>
            <button type="submit" id="submit" class="button blue" style="width:300px;">senden</button>
        </form>
        </center>
         <div style="text-align:center; width:100px; padding-right:15px; padding-top:15px; float:right;"><a href="login.php">zurück</a></div>
    </div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href='info.php'" style="padding-top:10px; padding-right:15px; float:right;"></span></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>