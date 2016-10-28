<?php

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

// Bindet die nötigen PHP-Files ein 
include_once 'db_connect.php';
include_once 'functions.php';

// Startet die PHP-Session
sec_session_start();
if (isset($_GET['email'], $_GET['p'])) {
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
	// Das gehashte Passwort.
    $password = $_GET['p'];
    
    if (login($email, $password, $mysqli) == true) {
        // Login erfolgreich
        header("Location: ../menu.php");
        exit();
    } else {
        // Login fehlgeschlagen
        header('Location: ../login_error.php?error=1');
        exit();
    }
} else {
    // Falls nicht die korrekten POST Variablen gesendet wurden  
    header('Location: ../error.php?err=Could not process login');
    exit();
}