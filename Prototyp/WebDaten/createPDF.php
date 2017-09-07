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
 * Die createPDF.php dient zur Erstellung einer PDF Datei mit den Analysedaten der gewählten Interaktion und dessen Versand an die gewünschte E-Mail Adresse
 * Falls eine Bilddatei per POST Methode übergeben wurde, wird diese temporär im Ordner statistics gespeichert. Anschließend werden die Daten zur gewählten Interaktion aus der
 * Datenbank geladen, sowie die abgegebenen Antworten zur Interaktion. Anschließend werden die Daten und ggf. das Bild als HTML-Code in die Variable $content gespeichert. 
 * Dieser HTML-Code wird dann durch das DOMPDF-Framework in eine PDF umgewandelt und im Ordner statistics abgespeichert. Am Ende wird der E-Mail-Header erstellt mit
 * der PDF als Anhang und über den Server versendet. Am Ende werden die temporären Dateien im Ordner statistics gelöscht.
 * 
 */ 

// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
require_once("includes/dompdf_config.inc.php");


date_default_timezone_set('Europe/Berlin');
$id = $_GET['id'];
$data = str_replace(' ', '+', $_POST['bin_data']);
$data = base64_decode($data);
$fileName = 'statistics/statistik'.$id.'.png';
$im = imagecreatefromstring($data);
 
if ($im !== false) {
    // Save image in the specified location
    imagepng($im, $fileName);
    imagedestroy($im);
    echo "Saved successfully";
}
else {
    echo 'An error occurred.';
}

// SQL-Query
$sql = 'SELECT id, user_id, date, settings, title, type, question, representation_type FROM interactions WHERE id ='.$id;
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
$row = $result->fetch_assoc();

// SQL-Query
$sql = 'SELECT * FROM answers WHERE interactions_id ='.$id;
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
$answerData = "";
while($row3 = $result->fetch_assoc())
{
	$answerData = $answerData. "ID: ".$row3['id']." Antwort: ".$row3['answer']." Datum: ".date('r', $row3['date'])."<br>";
}

// File-Path
$filePath = 'statistics/statistik'.$row['id'].'.pdf';
$filePath2 = 'statistics/statistik'.$row['id'].'.png';

// Erstellung des PDF-Files
$content = "
<html><head>
    <meta charset=\"UTF-8\" /><body>
    <div style='color:rgb(73,173,255); text-align:center; font-size: 20px; font-weight: 200;'><b>Statistik</b></div>
    <br>
	<p style='color:grey; text-align:center; font-size: 10px;'>Masterthesis<br>
 - Erweiterung von Standardpr&auml;sentation&szlig;oftware zur F&ouml;rderung der Publikumsinteraktion -<br>
 Institut f&uuml;r Angewandte Informatik <br>
 und Formale Beschreibungsverfahren <br>
 des Karlsruher Instituts f&uuml;r Technologie <br><br>
 Referent: Prof. Dr. Andreas Oberweis <br>
 Betreuer: Dipl.-Inform.Wirt Sascha Alpers <br><br>
 Karlsruhe, den 15 Juli 2014</p><br><br>
 <div style='border-style: solid; border-width: 1px; border-color: rgb(73,173,255); color:black; font-size: 14px;'>
 	<b>&Uuml;berblick</b><br><br>
	Interaktions ID: ".$row['id']."<br>
	Titel: ".$row['title']."<br>
	Frage: ".$row['question']."<br>
	Typ: ".$row['type']."<br>
	Darstellung: ".$row['representation_type']."<br>
	Datum: ".date('r', $row['date']/1000)."<br>
	Settings: ".$row['settings']."<br>
 </div><br><br>
 <div style='border-style: solid; border-width: 1px; border-color: rgb(73,173,255); color:black; font-size: 14px;'>
 	<b>Antworten</b><br><br>
	".$answerData."
 </div><br><br>
 <p><img height:400 src='statistics/statistik".$row['id'].".png'/></p>	
</body></html>"; 

$html =
  '<html><body>'.
  '<p>Put your html here, or generate it with your favourite '.
  'templating system.</p>'.
  '</body></html>';

// HTML zu PDF umwandlung 
$dompdf = new DOMPDF();
$dompdf->load_html($content);
$dompdf->render();
$output = $dompdf->output();
file_put_contents($filePath, $output);
//$dompdf->stream($filePath);

// SQL-Query
$sql = 'SELECT username, email FROM members WHERE id ='.$row['user_id'];
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
$row2 = $result->fetch_assoc();


// E-Mail versand mit dem erstellten PDF-File als Anhang

$Empfaenger = $row2['email'];
$Betreff = "Statistiken zu Ihrer Umfrage";
$mail_content = "Hallo ".$row2['username'].", anbei haben wir dir die Statistiken zu deiner Umfrage (Interaktion ".$row['id'].")"; 
$datei="statistics/statistik".$row['id'].".pdf"; 

$mail_header = "From: ARS<".constant('MAIL').">"; 
$boundary = strtoupper(md5(uniqid(time()))); 
$mail_header .= "\r\nMIME-Version: 1.0"; 
$mail_header .= "\r\nContent-Type: multipart/mixed; boundary=$boundary"; 
$mail_header .= "\r\nThis is a multi-part message in MIME format  --  Dies ist eine mehrteilige Nachricht im MIME-Format"; 
$mail_header .= "\r\n--$boundary"; 
$mail_header .= "\r\nContent-Type: text/plain"; 
$mail_header .= "\r\nContent-Transfer-Encoding: 8bit"; 
$mail_header .= "\r\n$mail_content"; 
$mail_header .= "\r\n--$boundary"; 
$mail_header .= "\r\nContent-Disposition: attachment; filename=statistik".$row['id'].".pdf"; 
$mail_header .= "\r\nContent-Type: application/pdf; name=statistik".$row['id'].".pdf"; 
$mail_header .= "\r\nContent-Transfer-Encoding: base64"; 
$file_content = chunk_split(base64_encode(file_get_contents($datei))); 
$mail_header .= "\r\n$file_content"; 
#$mail_header .= "\n"; 
$mail_header .= "--$boundary--"; 
var_dump(mail($Empfaenger, $Betreff, $mail_content, $mail_header));

// Löscht die erstellten Dateien
if (file_exists($filePath)) 
{
        unlink($filePath);
		unlink($filePath2);
}
?>
