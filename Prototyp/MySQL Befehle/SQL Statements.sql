Copyright 2016 FZI Forschungszentrum Informatik

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

MySQL
Datenbanken:
SQL-Befehle

Erstellen der Tabelle login_attempts

CREATE TABLE login_attempts (
	user_id INT(11) NOT NULL,
    time VARCHAR(30) NOT NULL
);

Erstellen der Tabelle members

CREATE TABLE members(
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password CHAR(128) NOT NULL,
    salt CHAR(128) NOT NULL
);

Erstellen der Tabelle Questiontypes

CREATE TABLE question_types(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    codeblock_form TEXT,
    codeblock_mobile TEXT,
    codeblock_display TEXT
);

Erstellen der Tabelle Interactions

 CREATE TABLE interactions (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    type VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    password TEXT,
    presentation VARCHAR(100) NOT NULL,
    presentation_id INT NOT NULL,
    date VARCHAR(100) NOT NULL,
    slide VARCHAR(100) NOT NULL,
    slide_id INT NOT NULL,
    question TEXT,
    settings TEXT,
    representation_type VARCHAR(100),
    qr_slide INT,
    representation_slide INT
);

Erstellen der Tabelle answers

CREATE TABLE answers (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    interactions_id INT NOT NULL,
    answer TEXT,
    ip TEXT,
    os TEXT,
    browser TEXT,
    country TEXT,
    date TEXT,
    hostname TEXT,
    all_info TEXT
    );
    
Erstellen der Tabelle representation_types

CREATE TABLE representation_types (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    codeblock_representation_type TEXT
    );




