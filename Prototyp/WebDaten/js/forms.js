/* 
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function formhash(form, password) {
	console.log(form);
	console.log(password);
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
   
	localStorage.setItem("email", $("#email").val());
	localStorage.setItem("p", p.value);
	
	
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
	
	
    // Finally submit the form. 
    form.submit();
}

function regformhash(form, uid, email, password, conf) {
    // Check each field has a value
	console.log("test");
    if (uid.value == '' || email.value == '' || password.value == '' || conf.value == '') {
        $("#infoText").html("Bitte füllen Sie alle Felde aus!");
        return false;
    }
    
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
		$("#infoText").html("Der Nutzername darf nur aus Buchstaben, Nummern und aus Unterstrichen bestehen. Versuchen Sie es erneut!");
        form.username.focus();
        return false; 
    }
    
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
		$("#infoText").html("Das Passwort muss mindestens 6 Zeichen lan sein. Versuchen Sie es erneut!!");
        form.password.focus();
        return false;
    }
    
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if (!re.test(password.value)) {
		$("#infoText").html("Das Passwort muss aus mindestens einer Nummer, einem klein Buchstaben und einem Großbuchstaben bestehen. Versuchen Sie es erneut!");
        return false;
    }
    
    // Check password and confirmation are the same
    if (password.value != conf.value) {
		$("#infoText").html("Die Kennwortbestätigung stimmt nicht mit dem Kennwort überein. Versuchen Sie es erneut!");
        form.password.focus();
        return false;
    }
        
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";

    // Finally submit the form. 
    form.submit();
    return true;
}
