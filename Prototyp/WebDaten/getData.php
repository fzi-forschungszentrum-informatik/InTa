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
 * Informationen zu den genutzen Frameworks finden Sie unter dem Menu-Punkt Info
 *
**/

/**
 * Quellcode-Beschreibung 
 * Die getData.php dient zur Abfrage aus der Datenbank.
 * Per POST-Methode werdend die nötigen Daten, sowie den code hierher übermittelt durch den code kann die richtige SQL-Query ausgeführt werden. 
 * Je nach Abfrage werden Daten zurückgeschickt.
 */

// Bindet die db_connect.php ein zum Aufbau der Datenbankverbindung
include_once 'includes/db_connect.php';

// Hier sind die unterschiedlichen DB Queries gespeichert, welche Daten aus der Datenbank anfordern.
// Anforderung der Präsentations ID
if ($_POST['code'] == "")
{

}

// Anforderung der Interaktions ID
elseif ($_POST['code'] == "qr")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT id FROM interactions WHERE user_id = ? AND presentation_id = ? AND slide_id = ?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('iss',$_SESSION['user_id'], $_POST['presentation_id'], $_POST['slide_id']);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($id);
// Ergebniss wird zurückgegeben
echo $id;
}

// Anforderung des Interaktions Passworts
elseif ($_POST['code'] == "password")
{
// SQL-Query
$sql = "SELECT password FROM interactions WHERE id = ".$_POST['id']." LIMIT 1";
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
$password = $result->fetch_assoc();						
// Ergebniss wird zurückgegeben
if ($password['password'] == $_POST['password'])
{
	echo 'true';
}
else
{
	echo 'false';
}
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
/*echo '<a rel="22">Lorenz</a>';
echo ' <a rel="7">ist</a>';
echo ' <a rel="12">der</a>';
echo ' <a rel="14">Beste</a>';*/
while($stmt->fetch())
{
	
    echo '<a rel="'.$anz.'">'.$answer.'</a>';
}
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_kartenabfrage")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer FROM answers WHERE interactions_id = ?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer);
// Ergebniss wird zurückgegeben
$tmp ="";
$tmp2 ="";
$tmp3 ="";
while($stmt->fetch())
{
	$tmp = ',"'.$answer.'"';
    $tmp2 = $tmp2 .$tmp;
}
$tmp3 = '['. substr($tmp2,1). ']';
echo $tmp3;
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_top10")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer ORDER BY Anz DESC"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$num = 1;
while($stmt->fetch())
{
	$tmp = ',["'.$num.'","'.$answer.'","'.$anz.'"]';
	$tmp2 = $tmp2 .$tmp;
    //echo '<tr><td>'.$num.'</td><td>'.$answer.'</td><td>'.$anz.'</td><tr>';
	//echo ',["'.$num.'","'.$answer.'","'.$anz.'"]';
	$num++;
}
$tmp3 = '['. substr($tmp2,1). ']';
echo $tmp3;
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_top10Pro")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer ORDER BY Anz DESC"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$num = 1;
while($stmt->fetch())
{
	if($answer{0}=='p')
	{
    echo '<tr><td>'.$num.'</td><td>'.substr($answer,4).'</td><td>'.$anz.'</td><tr>';
	$num++;
	}
	if ($num==11) break;
}
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_top10Contra")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer ORDER BY Anz DESC"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$num = 1;
while($stmt->fetch())
{
	if($answer{0}=='c')
	{	
    echo '<tr><td>'.$num.'</td><td>'.substr($answer,7).'</td><td>'.$anz.'</td><tr>';
	$num++;
	}
	if ($num==11) break;
}
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_swot1")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer ORDER BY Anz DESC"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$num = 1;
while($stmt->fetch())
{
	if($answer{0}=='s')
	{	
    echo '<tr><td>'.$num.'</td><td>'.substr($answer,4).'</td><td>'.$anz.'</td><tr>';
	$num++;
	}
	if ($num==6) break;
}
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_swot2")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer ORDER BY Anz DESC"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$num = 1;
while($stmt->fetch())
{
	if($answer{0}=='w')
	{	
    echo '<tr><td>'.$num.'</td><td>'.substr($answer,4).'</td><td>'.$anz.'</td><tr>';
	$num++;
	}
	if ($num==6) break;
}
}

// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_donutGraph")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer");
// Variablenübergabe an die SQL-Query
$stmt->bind_param('i', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$num = 1;
$tmp ="";
$tmp2 ="";
$tmp3 ="";
while($stmt->fetch())
{
	
	$tmp = ',"'.$num.'":"'.$answer.'", "'.$answer.'":"'.$anz.'"';
    $tmp2 = $tmp2 .$tmp;
	$num++;
}
$tmp3 = '{'. substr($tmp2,1). '}';
echo $tmp3;
}


// Anforderung der Interaktionen
elseif ($_POST['code'] == "multiQuestionSet")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT id, title FROM interactions WHERE user_id = ?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["userID"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($id, $title);
// Ergebniss wird zurückgegeben
$num = 1;
while($stmt->fetch())
{
	echo '<option value="'.$id.'" class="ars-select">'.$title.'</option>';
	$num++;
}
}


// Anforderung der Interaktionen
elseif ($_POST['code'] == "codeblock_mobile")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT codeblock_mobile FROM question_types WHERE name = ? LIMIT 1"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["name"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($codeblock_mobile);
// Ergebniss wird zurückgegeben
while($stmt->fetch())
{
	echo $codeblock_mobile."</script>";
}
}

// Anforderung der Interaktionen
elseif ($_POST['code'] == "interaction")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT type, question, title, password, settings  FROM interactions WHERE id = ? LIMIT 1"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($type, $question, $title, $password, $settings);
// Ergebniss wird zurückgegeben

while($stmt->fetch())
{
	
	echo '{"Typ":"'.$type.'","Question":"'.$question.'","Title":"'.$title.'","Password":"'.$password.'","Settings":['.$settings.']}';
	
}
}



// Anforderung der Interaktionsantworten
elseif ($_POST['code'] == "answers_columnGraph")
{
// SQL-Query
$stmt = $mysqli->prepare("SELECT answer, COUNT(*) AS 'Anz' FROM answers WHERE interactions_id = ? GROUP BY answer ORDER BY CAST(answer AS UNSIGNED) ASC"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["interaction_id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($answer, $anz);
// Ergebniss wird zurückgegeben
$tmpc ="";
$tmpc2 ="";
$tmps ="";
$tmps2 ="";
$tmps3 ="";
$tmpc3 ="";
while($stmt->fetch())
{
	$tmpc = ',"'.$answer.'"';
	$tmpc2 = $tmpc2 .$tmpc;
	
	$tmps = ','.$anz;
	$tmps2 = $tmps2 .$tmps;
}
$tmpc3 = ''. substr($tmpc2,1). '';
$tmps3 = '['. substr($tmps2,1). ']';
echo 'var a=\''.$tmpc3.'\'; var b = "'.$tmps3.'";';
//echo '[\''.$tmpc3.'\',\''.$tmps3.'\']';
}

elseif ($_POST['code'] == "presentation_id")
{
	$sql = 'SELECT presentation_id FROM interactions WHERE user_id = '.$_POST["user_id"].' ORDER BY presentation_id DESC LIMIT 1';
// Ausführung der Anfrage und Error-Handling
if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
while($row = $result->fetch_assoc())
						{
    						echo $row['presentation_id'];
						}
}

/*
elseif ($_POST['code'] == "answerTime")
{
$stmt = $mysqli->prepare("SELECT COUNT(*) AS 'Anz', a.date FROM interactions AS i JOIN answers AS a ON i.id = a.interactions_id WHERE i.id = ? GROUP BY a.date"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('s', $_POST["id"]);
// Ausführung der Anfrage
$stmt->execute();
// Speichern der Ergebnisse aus der Anfrage
$stmt->store_result();
// Die Ergebnisse aus der Anfrage werden an eine Variable übergeben
$stmt->bind_result($anz, $date);
// Ergebniss wird zurückgegeben
$tmpc ="";
$tmpc2 ="";
$tmps ="";
$tmps2 ="";
$tmps3 ="";
$tmpc3 ="";
while($stmt->fetch())
{
	$tmpc = ','.$anz.'';
	$tmpc2 = $tmpc2 .$tmpc;
	
	$tmps = ','.$date;
	$tmps2 = $tmps2 .$tmps;
}
$tmpc3 = '['. substr($tmpc2,1). ']';
$tmps3 = substr($tmps2,1);
echo 'var a=\''.$tmpc3.'\'; var b = "'.$tmps3.'";';
}


// Error-Handling
$mysqli->error;
// Beendet die Datenbankverbindung
$stmt->close();
$mysqli->close();
*/

?>