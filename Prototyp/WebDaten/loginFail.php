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


$MailURL = EndCoden($_GET["link"]);

echo $MailURL;

function EndcodeMail($str){
     
    $strUe = ""; 
    
    while(strlen($str) > 0) {
        
        $strUe = $strUe .$str[0];
        $str = substr($str, 3);
    }
    
    //$counter$str = strlen($str);
    
    return $strUe;
}


function EndCoden($F_URL) { 

          $End_URL = substr($F_URL, 3, -7);
    
    $Tag = substr($End_URL , 0, 2);
    
    $Monat = substr($End_URL , 6, 2);
    
    $BenutzerLaenge = substr($End_URL , 13, 2);
    
        $End_URL2=substr($End_URL,18, ($BenutzerLaenge*3-2));  
    
    $BenutzerEndCode = EndcodeMail($End_URL2);
    
        
        $counterDomain = substr($End_URL , 18 + ($BenutzerLaenge*3), 2);
        
        $End_URL3 = substr($End_URL , 18 + ($BenutzerLaenge*3) + 2, $counterDomain*3);
         
    $DomainEndCode = EndcodeMail($End_URL3);
    
        $counterDomainEnd = substr($End_URL , 18 + ($BenutzerLaenge*3) + 2 +$counterDomain*3, 1);
    
    $End_URL4 = substr($End_URL , 21 + ($BenutzerLaenge*3)  + $counterDomain*3, $counterDomain*3);
    
    $DomainEndEndCode = EndcodeMail($End_URL4);
        
    //.$DomainEndCount .$DomainEndCode
    
   //print "\n" ."\n" . $End_URL4."\n";
    
    //$counterDomain = substr($End_URL, $split );  
    
        //$End_URL3=substr($End_URL2, ($BenutzerLaenge), ($counterDomain*3-2)); 
    
    //.$counterDomain .$domainCode
    
    return 
	
	/* "\n" 
    . "Tag: " .$Tag ."\n"
    . "Monat: " .$Monat ."\n"
    . "BenutzerLaenge: " .$BenutzerLaenge ."\n"
    . "Mail: " .
	*/
	$BenutzerEndCode ."@" .$DomainEndCode ."." .$DomainEndEndCode  
    //."\n". "URL: " . $End_URL 
    ;
}

// SQL-Query
$sql = "SELECT id, email FROM members WHERE email = '". $MailURL ."'";
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
         array('!', '?', '&', '%', '§', '$')
         );
    $password = '';
    for($i=0;$i<$pwLen;$i++){
        $setNr = $i<4 ? $i : rand(0,3);
        $key = array_rand($charSets[$setNr]);
        $password .= $charSets[$setNr][$key];
    }
    return str_shuffle($password);
    
}



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
	
// SQL-Query
$stmt = $mysqli->prepare("UPDATE members SET salt='".$salt."', password='".$password."' WHERE id='".$id."'");
// Ausführung der Anfrage
$stmt->execute();
// Error-Handling
$mysqli->error;
// Beendet die Datenbankverbindung
$stmt->close();
$mysqli->close();
	
$empfaenger = $mail;
$betreff = "Kennwort vergessen";
$from = "From: ".constant("MAIL")."";
$text = "Wir haben ein neues Kennwort angelegt, loggen Sie sich mit diesem ein und geben Sie unter Einstellungen ein neues Passwort an. Kennwort: ".$random_password;

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