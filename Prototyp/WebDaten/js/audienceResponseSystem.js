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
**/

/*
(function () {
"use strict";
// Die Initialisierungsfunktion muss bei jedem Laden einer neuen Seite ausgeführt werden.
Office.initialize = function (reason) {

// Aufruf wenn Dokument fertig geladen
$(document).ready(function () {
	app.initialize();
	app.presentation_id();
	app.overview();
	app.changeView();
	
});		
};  
})();
*/
// Meldet den Nutzer ab
logout = function ()
{
	console.log("logout");
	localStorage.setItem("email","");
	localStorage.setItem("p","");
	javascript:location.href='includes/logout.php';
}

// Speichert die FolienID zur QR-Anzeige
mode_qr = function (interactionid)
{
	app.setSlideQR(interactionid);
	//+var slideID = app.slide_id();
	// Speichert Folien ID, Interaktions ID und den Modus im Dokument
	//+app.setValue(slideID,interactionid);
	//+app.setValue(slideID+"mode","qr");
	// Ändert die Farbe der Icons
	//+$("i").attr( "style", "padding-left:10px; color:rgb(73,173,255);" );
	//+$("#mode_qr"+interactionid).attr( "style", "padding-left:10px; color:red;" );
	// Ruft die setData.php auf und übergibt die Interaktions ID
	/*$.post("setData.php",
    	{
		  code: "add_qr",	
		  id: interactionid,
		  slideID: 5//slideID
   		 },function(data,status){if (status == "success"){console.log("success");console.log(data);}else{console.log("Fehler");}});*/
		 // Aktualisiert die Seite overview.php nach 1sec
		 	
	/*Office.initialize();
	// Holt sich die Folien ID
	var slideID = localStorage.getItem("slideID");
	// Holt sich die Interaktions ID für die ausgewälte Folie
	var interaction_id = localStorage.getItem(slideID);
	// Speichert beides
	localStorage.setItem(slideID,interaction_id);
	// Speichert den Modus für die aktuelle Folie
	localStorage.setItem(slideID+"mode","qr");
	// Ändert die Farbe der Icons
	$("#mode_qr").attr( "style", "float:left; color:black;" );
	$("#mode_graph").attr( "style", "padding-left:20px; float:left; color:white;" );*/
	//var source = "overview";
	//parent.location.href = "qr.php?source="+source+"&preview=true&interaction_id="+interactionid;
}

// Speichert die FolienID zur Graph-Anzeige
mode_graph = function (interactionid)
{
	app.setSlideGraph(interactionid);
	/*+var slideID = app.slide_id();
	app.setValue(slideID,interactionid);
	app.setValue(slideID+"mode","graph");
	$("i").attr( "style", "padding-left:10px; color:rgb(73,173,255);" );
	$("#mode_graph"+interactionid).attr( "style", "padding-left:10px; color:red;" );
	$.post("setData.php",
    	{
		  code: "add_graph",	
		  id: interactionid,
		  slideID: slideID
   		 },function(data,status){if (status == "success"){console.log("success");console.log(data);}else{console.log("Fehler");}});
		 // Aktualisiert die Seite overview.php nach 1sec
		 var delay = 1000;
		 setTimeout(function(){//javascript:location.href='overview.php'
		 },delay);+*/	
	/*Office.initialize();
	// Holt sich die Folien ID
	var slideID = localStorage.getItem("slideID");
	// Holt sich die Interaktions ID für die ausgewälte Folie
	var interaction_id = localStorage.getItem(slideID);
	// Speichert beides
	localStorage.setItem(slideID,interaction_id);
	// Speichert den Modus für die aktuelle Folie
	localStorage.setItem(slideID+"mode","graph");
	// Ändert die Farbe der Icons
	$("#mode_qr").attr( "style", "float:left; color:white;" );
	$("#mode_graph").attr( "style", "padding-left:20px; float:left; color:black;" );*/
	//var source = "overview";
	//parent.location.href = "graph.php?source="+source+"&preview=true&interaction_id="+interactionid;
}

setZeroQR = function (slideID, interactionID)
{
	// Speichert die Werte im Dokument
	app.setValue(slideID, "");
	// Speichert die Werte in der DB
	$.post("setData.php",
    	{
		  code: "add_qr",	
		  id: interactionID,
		  slideID: "0"
   		 });
		 // Aktualisiert die Seite overview.php
		javascript:location.href='overview.php';
}

setZeroGraph = function (slideID, interactionID)
{
	// Speichert die Werte im Dokument
	app.setValue(slideID, "");
	// Speichert die Werte in der DB
	$.post("setData.php",
    	{
		  code: "add_graph",	
		  id: interactionID,
		  slideID: "0"
   		 });
		 // Aktualisiert die Seite overview.php
		 javascript:location.href='overview.php';
}

// Löscht die ausgewählte Interaktion
delete_interaction = function (id)
{
	// Ruft die setData.php auf und übergibt die Interaktions ID
	$.post("setData.php",
    	{
		  code: "delete",	
		  id: id
   		 },function(data,status){if (status == "success"){console.log("success");console.log(data);}else{console.log("Fehler");}});
		 // Aktualisiert die Seite overview.php nach 1sec
		 var delay = 1000;
		 setTimeout(function(){javascript:location.href='overview.php'},delay);	 
}

// Bearbeiten der ausgewählte Interaktion
update_interaction = function (id)
{
	javascript:location.href='update.php?id='+id;
}

// Löscht die ausgewählte Antwort
delete_answer = function (answer_id, interaction_id)
{
	// Ruft die setData.php auf und übergibt die Interaktions ID
	$.post("setData.php",
    	{
		  code: "delete_answer",	
		  id: answer_id
   		 },function(data,status){if (status == "success"){console.log("success");console.log(data);}else{console.log("Fehler");}});
		 // Aktualisiert die Seite overview.php nach 1sec
		 var delay = 1000;
		 setTimeout(function(){javascript:location.href='showData.php?id='+interaction_id},delay);	 	
}
