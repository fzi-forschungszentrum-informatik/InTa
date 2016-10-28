/* Häufige App-Funktion */
var tmp = "";
var app = (function () {
    "use strict";

    var app = {};

    // Häufige Initialisierungsfunktion (von jeder Seite aufzurufen)
    app.initialize = function () {
		
       
	   		// Überprüft den Modus und wechselt entsprechend die Sicht
            Office.context.document.addHandlerAsync("activeViewChanged", function (args) {
                if (args.activeView == "read") {
					//var slideID = localStorage.getItem("slideID");
					//var rep_mode = localStorage.getItem(slideID+"mode");
					//var interaction_id = localStorage.getItem(slideID);
					if( rep_mode == "qr")
					{
						$("#x").hide();
  						
						//parent.location.href = "qr.php?interaction_id="+interaction_id;
						
					}
					else if
					( rep_mode == "graph")
					{
						$("#x").hide();
						/*var email = localStorage.getItem("email");
						if ((email === null) || (email == "") || (typeof email == "undefined"))
						{
						}
						else
						{
						//parent.location.href = "graph.php?interaction_id="+interaction_id;
						}*/
					}
                    
                }
                else if (args.activeView == "edit") {
                    //parent.location.href = "menu.php";
					$("#x").show();
                }
            });


        app.getSlideID = function () {
			console.log("Hallo Welt");
            Office.context.document.getSelectedDataAsync(Office.CoercionType.SlideRange, function (asyncResult) {
                if (asyncResult.status == "failed") {

                }
                else {
                    localStorage.setItem("slideID", JSON.stringify(asyncResult.value.slides[0].id));
                    Office.context.document.settings.set('slideID', JSON.stringify(asyncResult.value.slides[0].id));
                    Office.context.document.settings.saveAsync(function (asyncResult) {
                        if (asyncResult.status == Office.AsyncResultStatus.Failed) {
                            console.log('Settings save failed. Error: ' + asyncResult.error.message);
                        } else {
                            console.log('Settings saved.');
                        }
                    });
                }

            });
        }


       app.getURL = function () {
            var docUrl = Office.context.document.url;
            return docUrl;
        }
		
		
		// Holt die ID der aktuellen Folie und gibt diese zurück
		 app.slide_id = function () {
			 var slide;
			 Office.context.document.getSelectedDataAsync(Office.CoercionType.SlideRange, function (asyncResult) {
                if (asyncResult.status == "failed") {

                }
                else {
                    slide = JSON.stringify(asyncResult.value.slides[0].id);  
                }}); return slide;
        }
		
		app.overview = function () {
			 var slide;
			 Office.context.document.getSelectedDataAsync(Office.CoercionType.SlideRange, function (asyncResult) {
                if (asyncResult.status == "failed") {

                }
                else {
                    slide = JSON.stringify(asyncResult.value.slides[0].id); 
					if($('#qr_'+slide).html() == slide)
					{
						$('#qr_'+slide).parent().css("background", "rgb(240,240,240)");
						$('#qr_'+slide).next().next().find("i").eq(3).css("color", "rgb(255,0,0)");
					}
					else if($('#graph_'+slide).html() == slide)
					{
						$('#graph_'+slide).parent().css("background", "rgb(240,240,240)");
						$('#graph_'+slide).next().find("i").eq(4).css("color", "rgb(255,0,0)");
					}
                }});
        }
		
		app.setValue = function (val1, val2) {
			 Office.context.document.settings.set(val1, val2);
			 Office.context.document.settings.saveAsync(function (asyncResult) {
             if (asyncResult.status == Office.AsyncResultStatus.Failed) 
			 {
             	console.log('Settings save failed. Error: ' + asyncResult.error.message);
             } 
			 else 
			 {
                console.log('Settings saved.');
             }
             });
		}
		
		app.getValue = function (val1) {
			
			return Office.context.document.settings.get(val1);
		}
		
		

        app.getSlide = function () {
            Office.context.document.getSelectedDataAsync(Office.CoercionType.SlideRange, function (asyncResult) {
                if (asyncResult.status == "failed") {

                }
                else {
                    localStorage.setItem("slide", JSON.stringify(asyncResult.value.slides[0].index));
                    Office.context.document.settings.set('slide', JSON.stringify(asyncResult.value.slides[0].index));
                    Office.context.document.settings.saveAsync(function (asyncResult) {
                        if (asyncResult.status == Office.AsyncResultStatus.Failed) {
                            console.log('Settings save failed. Error: ' + asyncResult.error.message);
                        } else {
                            console.log('Settings saved.');
                        }
                    });
                }

            });
        }
    };
    return app;
})();