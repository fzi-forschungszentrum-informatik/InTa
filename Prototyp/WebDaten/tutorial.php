<?php

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
 
 /**
 * Quellcode-Beschreibung 
 * Die tutorial.php dient zum anzeigen der Hilfeseiten für die Funktionen des Prototyps. Der Nutzer kann zwischen den unterschiedlichen Pages hin und her springen.
 * Auf diesen ist ein kurzer Beschreibungstext und auf der rechten Seite wird ein mp4 Video angezeigt. Dieses wird ohne Steuerelemente angezeigt und wird in einer Endlosschleife
 * angezeigt.
 */

// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
// Startet die Session
sec_session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <!-- MetaTags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    
    <title>AudienceResponseSystem-Tutorial</title>
    
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
<div id="header"><div id="usrIcon"><span class="fa fa-user fa-4x" onclick="javascript:location.href='info.php'" style="padding-top:15px; padding-right:15px; padding-left:28px; float:left;"></span></div><div id="usrInfo" style="padding: 15px 100px; font-size:16px;"><?php echo htmlentities($_SESSION['username']); ?></div><a href="javascript:;" style="color:white; float:right" onclick="logout()">logout</a><div id="breadcrumbs" style="padding: 0px 100px;"><a style="color:white;" href="menu.php">Menu</a> | <a style="color:white;" href="tutorial.php">Tutorial</a></div>
</div><!-- Header-End -->

<!-- Content-Start -->
<div id="content">
<div class="pure-g" id="view_one" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 1/14</h3>
            <p>Hier werden Ihnen die einzelnen Funktionen der Anwendung vorgestellt:</p>
            <p><b>Neue Interaktion erstellen</b>
            <ul>
            <li>Das Hauptmenu besteht aus vier Programmpunkten, "Erstellen", "&Uuml;bersicht", "Tutorial" und "Einstellungen".</li>
            <li>Im oberen Bildrand befindet sich ein "breadcrumb trail", der die aktuelle Position in der Programmnavigation angibt. &Uuml;ber diesen kann man auch zu den &Uuml;berpunkten zur&uuml;ck wechseln</li>
            <li>Um eine neue Interaktion zu erstellen, gehen Sie im Hauptmenu auf den Programmpunkt "Erstellen".</li>
            </ul>
            </p>
			<button class="button blue" style="width:100px;" onclick='$("#view_one").hide(); $("#view_two").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip1a.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_two" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 2/14</h3>
            <p><b>Neue Interaktion erstellen</b>
            <ul>
            <li>Unter dem Programmpunkt "Erstellen" k&ouml;nnen Sie eine neue Interaktion anlegen und in der Datenbank speichern. Zun&auml;chst m&uuml;ssen Sie einige allgemeine Informationen zu Ihrer neuen Interaktion eingeben.</li>
            <li>Als Erstes k&ouml;nnen Sie einen Titel f&uuml;r Ihre Interaktion definieren. Dieser sollte kurz und aussagekr&auml;ftig sein.</li>
            <li>Als n&auml;chstes k&ouml;nnen Sie aus mehreren vorgegebenen M&ouml;glichkeiten Ihren Fragetyp festlegen.</li>
            <li>Optional ist es auch m&ouml;glich ein Passwort f&uuml;r Ihre Interaktion zu definieren. Dies ist n&uuml;tlzlich um den Personenkreis und damit den Zugriff auf Ihre Interaktion einzuschr&auml;nken.</li>
            <li>Die nachfolgenden Punkte werden automatisch vom Programm f&uuml;r Ihre Interaktion festgelget.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_two").hide(); $("#view_one").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_two").hide(); $("#view_three").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip1b.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_three" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 3/14</h3>
            <p><b>Neue Interaktion erstellen</b>
            <ul>
            <li>In dem Abschnitt Frage k&ouml;nnen Sie Ihre Interaktion n&auml;her definieren. Die Einstellungsm&ouml;glichkeiten h&auml;ngen von dem ausgew&auml;hlten Fragetyp ab.</li>
            <li>Zun&auml;chst m&uuml;ssen Sie die Frage, welche Sie von Ihrem Publikum beantwortet haben m&ouml;chten eingeben.</li>
            <li>Danach k&ouml;nnen Sie je nach ausgew&auml;hltem Fragetyp die Antwortm&ouml;glichkeiten einschr&auml;nken bzw. n&auml;her bestimmen.</li>
            <li>Sie k&ouml;nnen hier auch festlegen ob ein Teilnehmer nur eine oder mehrere Antworten abgeben darf</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_three").hide(); $("#view_two").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_three").hide(); $("#view_four").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip1c.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_four" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 4/14</h3>
            <p><b>Neue Interaktion erstellen</b>
            <ul>
            <li>Im letzten Abschnitt den Darstellungsoptionen k&ouml;nnen Sie n&auml;her definieren, wie Ihre Interaktion sp&auml;ter die Ergebnisse darstellen soll. Die Einstellungsm&ouml;glichkeiten h&auml;ngen von dem ausgew&auml;hlten Fragetyp ab.</li>
            <li>Auf der rechten Seite sehen Sie ein Vorschaubild, wie der Darstellungstyp sp&auml;ter in Ihrer Pr&auml;sentation dargestellt wird.</li>
            <li>Nachdem Sie auf "erstellen" gedr&uuml;ckt haben, werden die von Ihnen getroffenen Einstellungen in der Datenbank gespeichert. Sie k&ouml;nnen die nun neu erstellte Interaktion unter dem Programmpunkt "&Uuml;bersicht" ansehen.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_four").hide(); $("#view_three").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_four").hide(); $("#view_five").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip1d.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_five" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 5/14</h3>
            <p><b>Erstellte Interaktion in die Pr&auml;sentation einbauen</b>
            <ul>
            <li>Um eine Interaktion in Ihre PowerPoint Pr&auml;sentation einzubauen, m&uuml;ssen Sie den QR-Code eine Folie zuweisen und die Umfrage-Ergebnisse eine Folie zuweisen.</li>
            <li>Dazu m&uuml;ssen Sie im Hauptmenu auf den Programmpunkt "&Uuml;bersicht" gehen. Hier werden alle Ihre erstellten Interaktionen dargestellt.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_five").hide(); $("#view_four").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_five").hide(); $("#view_six").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip2a.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_six" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 6/14</h3>
            <p><b>Erstellte Interaktion in die Pr&auml;sentation einbauen</b>
            <ul>
            <li>Hier werden all Ihre bisher erstellten Interaktionen aufgelistet und verwaltet.</li>
            <li>Um der aktuellen Folie den QR-Code der Interaktion zuzuweisen klicken Sie auf das QR-Code Symbol der gew&uuml;nschten Umfrage.</li>
            <li>Durch diesen QR-Code oder &uuml;ber den abgebildeten Link, kann Ihr Publikum mit hilfe eines mobilen Endger&auml;tes auf Ihre Interaktion zugreifen und die Frage beantworten.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_six").hide(); $("#view_five").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_six").hide(); $("#view_seven").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip2b.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_seven" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 7/14</h3>
            <p><b>Erstellte Interaktion in die Pr&auml;sentation einbauen</b>
            <ul>
            <li>Sie haben bereits eine Folie erstellt auf der ein QR-Code abgebildet ist, welcher zu Ihrer Umfrage f&uuml;hrt. Um nun auch die Ergebnisse der Publikumsbefragung anzuzeigen, brauchen Sie eine weitere Folie. Dazu k&ouml;nnen Sie die aktuelle Folie duplizieren und analog wie bei dem QR-Code nun den Punkt Umfrage-Ergebnisse anklicken. Dadurch wird der Folie die Darstellung der Ergebnisse zugewiesen.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_seven").hide(); $("#view_six").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_seven").hide(); $("#view_eight").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip2c.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_eight" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 8/14</h3>
            <p><b>Erstellte Interaktion in die Pr&auml;sentation einbauen</b>
            <ul>
            <li>Weisen Sie nun analog wie bei dem QR-Code der aktuellen Folie den Ergebnis-Graph zu.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_eight").hide(); $("#view_seven").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_eight").hide(); $("#view_nine").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip2d.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_nine" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 9/14</h3>
            <p><b>Erstellte Interaktion in die Pr&auml;sentation einbauen</b>
            <ul>
            <li>Sie k&ouml;nnen nun die PowerPoint Pr&auml;sentation starten und die gew&uuml;nschten Folien werden angezeigt.</li>
            <li>Ihr Publikum gelangt durch den QR-Code auf eine mobile WebApp wo es Ihre Frage beantworten kann. Die Antworten werden live auf der Umfrage-Ergebniss Folie dargestellt. </li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_nine").hide(); $("#view_eight").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_nine").hide(); $("#view_ten").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip2e.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_ten" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 10/14</h3>
            <p><b>Programmpunkt &Uuml;bersicht</b>
            <ul>
            <li>Im Programmpunkt &Uuml;bersicht, k&ouml;nnen Sie Ihre Interaktionen verwalten.</li>
            <li>Sie k&ouml;nnen hier nicht nur die Interaktionen den Folien zuweisen, sondern auch die erstellten Interaktionen bearbeiten.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_ten").hide(); $("#view_nine").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_ten").hide(); $("#view_eleven").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip3a.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_eleven" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 11/14</h3>
            <p><b>Programmpunkt &Uuml;bersicht</b>
            <ul>
            <li>Sie k&ouml;nnen hier die unterschiedlichen Eigenschaften Ihrer Interaktion bearbeiten.</li>
            <li>Zum einen k&ouml;nnen Sie den Titel, das Passwort und den Titel der Pr&auml;sentation bearbeiten.</li>
            <li>Zum anderen k&ouml;nnen Sie auch die Frage, dessen Eigenschaften und den Anzeigetyp bearbeiten.</li>
            <li>Sie k&ouml;nnen auch eine andere Folie f&uuml;r QR und Graph definieren.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_eleven").hide(); $("#view_ten").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_eleven").hide(); $("#view_twelve").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip3b.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_twelve" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 12/14</h3>
            <p><b>Programmpunkt &Uuml;bersicht</b>
            <ul>
            <li>Ein weiterer Punkt hier ist die Statistik &uuml;ber die Interaktion.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_twelve").hide(); $("#view_eleven").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_twelve").hide(); $("#view_thirteen").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip3c.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_thirteen" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 13/14</h3>
            <p><b>Programmpunkt &Uuml;bersicht</b>
            <ul>
            <li>Falls vorhanden werden hier die abgegebenen Antworten angezeigt, welche einzeln auch gel&ouml;scht werden k&ouml;nnen. Des Weiteren werden Informationen und Statistiken &uuml;ber die Interaktion dargestellt.</li>
            <li>Es gibt auch die M&ouml;glichkeit sich die Statistiken per E-Mail zuschicken zu lassen. Die Statistiken werden dabei an die von Ihnen in der Registrierung angegebenen E-Mail Adresse gesendet</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_thirteen").hide(); $("#view_twelve").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick='$("#view_thirteen").hide(); $("#view_fourteen").show();'>weiter</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip3d.mp4" type="video/mp4"></video>
    </div>
    </div>
</div>

<div class="pure-g" id="view_fourteen" style="display:block; padding-left:15px;">
    <div class="pure-u-1-2">
    	<div class="l-box">
        	<h3>Tutorial 14/14</h3>
            <p><b>Programmpunkt Einstellungen</b>
            <ul>
            <li>Unter dem Programmpunkt "Einstellungen", k&ouml;nnen Sie Ihr Passwort, E-Mail oder Nutzername &auml;ndern.</li>
            <li>Des Weiteren können Sie auch Ihren kompletten Account unwiderruflich löschen.</li>
            </ul>
            </p>
            <button class="button blue" style="width:100px;" onclick='$("#view_fourteen").hide(); $("#view_thirteen").show();'>zur&uuml;ck</button>
			<button class="button blue" style="width:100px;" onclick="javascript:location.href='menu.php';">fertig</button>
        </div>
     </div>
    <div class="pure-u-1-2" style="color:grey">
    <div class="l-box">
    <video height="400" autoplay loop><source src="images/clip3f.mp4" type="video/mp4"></video>
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
	$("#view_two").hide();
	$("#view_three").hide();
	$("#view_four").hide();
	$("#view_three").hide();
	$("#view_five").hide();
	$("#view_six").hide();
	$("#view_seven").hide();
	$("#view_eight").hide();
	$("#view_nine").hide();
	$("#view_ten").hide();
	$("#view_eleven").hide();
	$("#view_twelve").hide();
	$("#view_thirteen").hide();
	$("#view_fourteen").hide();
	$("#view_fiveteen").hide();
})
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