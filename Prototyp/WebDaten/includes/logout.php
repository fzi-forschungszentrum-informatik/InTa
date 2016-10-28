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
include_once 'functions.php';

// Startet die PHP-Session
sec_session_start();

// Setzt alle Sessionwerte zurück
$_SESSION = array();

// Holt die Session Parameter 
$params = session_get_cookie_params();

// Löscht das aktuelle Cookie 
setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Zerstört die Session 
session_destroy();
header("Location: ../login.php");
exit();
