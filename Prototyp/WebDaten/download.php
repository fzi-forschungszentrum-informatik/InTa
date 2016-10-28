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
 * Die download.php ist nicht aktiv, wurde geschrieben um die erstellte PDF-Datei herunterzuladen. Dies funktioniert nur im Browser und nicht in PowerPoint
 * 
 */
 
// Bindet die nötigen PHP-Files ein 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/psl-config.php';

$file = basename($_GET['file']);
$file = constant("URL").'statistics/'.$file;

if(!$file){ // Falls die Datei nicht existiert
    die('file not found');
} else {
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");

    // Liest die Datei
    readfile($file);
}
?>