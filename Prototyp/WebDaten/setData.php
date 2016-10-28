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
 * Die setData.php dient zum Schreiben/Löschen oder Updaten von Daten in der Datenbank
 * Per POST-Methode werdend die nötigen Daten, sowie den code hierher übermittelt durch den code kann die richtige SQL-Query ausgeführt werden. 
 * Je nach Abfrage werden Daten zurückgeschickt.
 */

// Bindet die db_connect.php ein zum Aufbau der Datenbankverbindung
include_once 'includes/db_connect.php';
include_once 'psl-config.php';

// Hier sind die unterschiedlichen DB Queries gespeichert, welche Daten in die Datenbank speichern, ändern oder löschen.
// Löscht Interaktion und dazugehörige Antworten
if ($_POST['code'] == "delete")
{
// SQL-Query
$stmt = $mysqli->prepare("DELETE FROM interactions WHERE id=?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('i',$_POST['id']);
// Ausführung der Anfrage
$stmt->execute();

// SQL-Query
$stmt = $mysqli->prepare("DELETE FROM answers WHERE interactions_id=?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('i',$_POST['id']);
// Ausführung der Anfrage
$stmt->execute();
}

// Löscht einzelne Antwort
if ($_POST['code'] == "delete_answer")
{
// SQL-Query
$stmt = $mysqli->prepare("DELETE FROM answers WHERE id=?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('i',$_POST['id']);
// Ausführung der Anfrage
$stmt->execute();
}

// Speichert eine Interaktion
elseif ($_POST['code'] == "interactions")
{
// SQL-Query
$stmt = $mysqli->prepare("INSERT INTO interactions (user_id, title, type, password, presentation, presentation_id, date, slide, slide_id, settings, question, representation_type, qr_slide, representation_slide) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('ssssssssssssss',$_POST['userID'], $_POST['title'], $_POST['type'], $_POST['password'], $_POST['presentation'], $_POST['presentationid'], $_POST['date'], $_POST['slide'], $_POST['slide_id'], $_POST['settings'], $_POST['question'], $_POST['representationType'], $_POST['qr_slide'], $_POST['representation_slide']);
// Ausführung der Anfrage
$stmt->execute();
echo $_POST['qrslide'];
}

// Speichert die Antworten
elseif ($_POST['code'] == "answers")
{
// SQL-Query
$stmt = $mysqli->prepare("INSERT INTO answers (interactions_id, answer, ip, os, country, date, hostname, all_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('isssssss',$_POST['id'], $_POST['answer'], $_POST['ip'], $_POST['os'], $_POST['country'], $_POST['date'], $_POST['hostname'], $_POST['usrinfo']);
// Ausführung der Anfrage
$stmt->execute();
}

// Weist dem QR-Modus eine Folie zu
elseif ($_POST['code'] == "add_qr")
{
// SQL-Query
$stmt = $mysqli->prepare("UPDATE interactions SET qr_slide=? WHERE id=?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('ss',$_POST['slideID'], $_POST['id']);
// Ausführung der Anfrage
$stmt->execute();
}

// Weist dem Graph-Modus eine Folie zu
elseif ($_POST['code'] == "add_graph")
{
// SQL-Query
$stmt = $mysqli->prepare("UPDATE interactions SET representation_slide=? WHERE id=?"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('ss',$_POST['slideID'], $_POST['id']);
// Ausführung der Anfrage
$stmt->execute();
}

// Ändert die Interaktions-Werte
elseif ($_POST['code'] == "update")
{
// SQL-Query
$stmt = $mysqli->prepare("UPDATE interactions SET title='".$_POST['title']."', user_id='".$_POST['userID']."', type='".$_POST['type']."', password='".$_POST['password']."', presentation='".$_POST['presentation']."', presentation_id='".$_POST['presentationid']."', date='".$_POST['date']."', slide='".$_POST['slide']."', slide_id='".$_POST['slide_id']."', settings='".$_POST['settings']."', question='".$_POST['question']."', representation_type='".$_POST['representationType']."', qr_slide='".$_POST['qr_slide']."', representation_slide='".$_POST['representation_slide']."' WHERE id='".$_POST['interactionID']."'");
// Ausführung der Anfrage
$stmt->execute();
}

// Nutzereigenschaften ändern
elseif ($_POST['code'] == "changeM")
{
	if($_POST['password'] == "")
	{
	// SQL-Query
	$stmt = $mysqli->prepare("UPDATE members SET username='".$_POST['username']."', email='".$_POST['email']."' WHERE id='".$_POST['id']."'");
	}
	else
	{
	$password = hash('sha512', $_POST['password']);	
	$password = hash('sha512', $password . $_POST['salt']);
	// SQL-Query
	$stmt = $mysqli->prepare("UPDATE members SET username='".$_POST['username']."', email='".$_POST['email']."', password='".$password."' WHERE id='".$_POST['id']."'");
	}
// Ausführung der Anfrage
$stmt->execute();
}

// Nutzeraccount löschen
elseif ($_POST['code'] == "deleteM")
{
// Antworten löschen
// SQL-Query
$stmt = $mysqli->prepare("DELETE FROM answers WHERE interactions_id IN (SELECT interactions_id FROM interactions WHERE user_id=?)"); 
// Variablenübergabe an die SQL-Query
$stmt->bind_param('i',$_POST['id']);
// Ausführung der Anfrage
$stmt->execute();

// Interaktionen löschen
// SQL-Query
$stmt2 = $mysqli->prepare("DELETE FROM interactions WHERE user_id=?"); 
// Variablenübergabe an die SQL-Query
$stmt2->bind_param('i',$_POST['id']);
// Ausführung der Anfrage
$stmt2->execute();

// Nutzer löschen
// SQL-Query
$stmt3 = $mysqli->prepare("DELETE FROM members WHERE id=?"); 
// Variablenübergabe an die SQL-Query
$stmt3->bind_param('i',$_POST['id']);
// Ausführung der Anfrage
$stmt3->execute();
}


// Error-Handling
$mysqli->error;
// Beendet die Datenbankverbindung
$stmt->close();
$mysqli->close();
?>