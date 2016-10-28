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
 * Die loginFail.php hier wird zunächst überprüft, ob die eingegeben E-Mail in der Datenbank vorhanden. Falls nicht wird dem Nutzer angezeigt, dass
 * die E-Mail nicht vorhanden ist und er kann erneut eine eingeben. Falls die E-Mail vorhanden, wird ein neues zufälliges Passwort generiert und gehasht und in der Datenbank
 * mit der neuen salt unter der E-Mail geupdatet. Anschließend wird das neue Passwort dem Nutzer per E-Mail zugesendet und aufgefordert, das Passwort schnellst möglich zu 
 * ändern.
 */
 
// Bindet die nötigen PHP-Files ein 
include_once 'includes/psl-config.php';
include_once 'includes/db_connect.php';

// SQL-Query
$sql = "SELECT id, email FROM members WHERE email = '". $_GET["email"]."'";
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
// Ergebniss wird zurückgegeben
$row = $result->fetch_assoc();
$id = $row['id'];
$mail = $row['email'];

function makePassword($pwLen) { 
    $charSets = array( 
         array_merge(range('A', 'N'), range('P', 'Z')),
         array_merge(range('a', 'n'), range('p', 'z')),
         str_split("123456789"),
         array('!', '_', '+', '#', '§', '$')
         );
    $password = '';
    for($i=0;$i<$pwLen;$i++){
        $setNr = $i<4 ? $i : rand(0,3);
        $key = array_rand($charSets[$setNr]);
        $password .= $charSets[$setNr][$key];
    }
    return str_shuffle($password);
    
}

function chunk_split_unicode($str, $l = 76, $e = "\r\n") {
    $tmp = array_chunk(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $l);
    $str = "";
    foreach ($tmp as $t) {
       $zu = makePassword(2);
        
        $str .= join("", $t) . $zu;
    }
    return $str;
}


//---------------------------------------------------


$counter = strlen($mail);

$arr1 = explode('@', $mail);


//Benutzer
$benutzer = $arr1[0];

$counterBenutzer = strlen($arr1[0]);
if($counterBenutzer<= 9){ $counterBenutzer = 0 .$counterBenutzer;};

//$benutzerCode = chunk_split($benutzer, 1, makePassword(10));

$benutzerCode = chunk_split_unicode($benutzer, 1);

//echo "Test: " .$benutzerCode ."\n";


//Domain
$arr2 =explode('.', $arr1[1]);

$domain = $arr2[0];
$counterDomain = strlen($domain);
$domainCode = chunk_split_unicode($domain, 1);

if($counterDomain <= 9){ $counterDomain = 0 .$counterDomain;};

//print $benutzer ."\n" .$arr2[0] ."\n"  .$arr2[1] ."\n";

//if($counter < 9){ $counter = 0 .$counter;};


//Domain Ende

$DomainEnd = $arr2[1];
$DomainEndCount = strlen($DomainEnd);
$DomainEndCode = chunk_split_unicode($DomainEnd, 1);

//$counterDomain = strlen($domain);
//$domainCode = chunk_split_unicode($domain, 1);

//.$DomainEndCount .$DomainEndCode



$tag = date("d");
$monat = date("m");

$abstand3 = makePassword(3);
$abstand4 = makePassword(4);
$abstand5 = makePassword(5);

$URL = $abstand3 .$tag .$abstand4 .$monat .$abstand5 .$counterBenutzer .$abstand3 .$benutzerCode .$counterDomain .$domainCode .$DomainEndCount .$DomainEndCode .$abstand5;

//----------------------------------------------------------


if($result->num_rows==1)
{

// Zufälliges Passwort
$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
//$random_password = "aLK1223".rand(1, 99999);
// $random_password = substr(md5(rand()),0,15);

$random_password = makePassword(12);

$random_password2 = hash('sha512', $random_password);	
$random_password2 = hash('sha512', $random_password2 . $random_salt);

	
$password = $random_password2;
$salt = $random_salt;

/*	
// SQL-Query
$stmt = $mysqli->prepare("UPDATE members SET salt='".$salt."', password='".$password."' WHERE id='".$id."'");
// Ausführung der Anfrage
$stmt->execute();
// Error-Handling
$mysqli->error;
// Beendet die Datenbankverbindung
$stmt->close();
$mysqli->close();
*/

$empfaenger = $mail;
$betreff = "Kennwort vergessen";
$from = "From: ".constant("MAIL")."";
$text = "Sehr geehrter Nutzer,

wir haben eine 'Kennwort vergessen' Anfrage für Ihre E-Mail Adresse erhalten.

Sofern Sie es waren, klicken Sie bitte den folgenden Link an:\n\n"

.'https://inta.fzi.de/inta/loginFail.php?link='.$URL

."\n\nSofern Sie es nicht waren, können Sie diese Nachricht ignorieren.";

mail($empfaenger, $betreff, $text, $from);
header('Location: login.php?');
}
else
{
// Gibt den HTML-Code aus  	
echo '<?php

/**
 * Copyright (C) 2014 Lorenz Haas
 * Masterthesis
 * - Erweiterung von Standardpräsentationssoftware zur Förderung der Publikumsinteraktion -
 * Institut für Angewandte Informatik
 * und Formale Beschreibungsverfahren
 * des Karlsruher Instituts für Technologie
 *
 * Referent: Prof. Dr. Andreas Oberweis
 * Betreuer: Dipl.-Inform.Wirt Sascha Alpers
 *
 * Karlsruhe, den 15 Juli 2014
 *
 */
 
include_once \'includes/register.inc.php\';
include_once \'includes/functions.php\';
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
	<script src="js/office.js" type="text/javascript"></script>
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
<center><p style="color:red">Die von Ihnen angegebene E-Mail Adresse existiert nicht.</p><p id="infoText">Sie haben Ihr Kennwort vergessen? Geben Sie bitte Ihre E-Mail Adresse an und wir schicken Ihnen ein neues Kennwort zu. Bitte &auml;ndern Sie dieses sofort.</p></center>
    <div id="form" style="height:200px; margin-top: -50px;">
        <center><h1>Kennwort vergessen</h1>
        <form class="ars-form ars-form-stacked" method="get" name="loginFail_form" action="loginFail.php">
            <fieldset class="ars-group">
            <input type="email" placeholder="E-Mail" id="email" name="email" maxlength="50" class="textInput" />
            </fieldset>
            <button type="submit" id="submit" class="button blue" style="width:300px;">senden</button>
        </form>
        </center>
         <div style="text-align:center; width:100px; padding-right:15px; padding-top:15px; float:right;"><a href="login.php">zur&uuml;ck</a></div>
    </div>
</div><!-- Content-End -->

<!-- Footer-Start -->
<div id="footer"><span class="fa fa-info-circle fa-3x" onclick="javascript:location.href=\'info.php\'" style="padding-top:10px; padding-right:15px; float:right;"></span></div><!-- Footer-End -->
</div> <!-- Page-End -->
</body>
</html>';
}
?>