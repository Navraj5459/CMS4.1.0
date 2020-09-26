<?php

$dbserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbdatabasename = "CMS4.2.0";

$conn = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbdatabasename);


    /*create table categories(
    id int primary key AUTO_INCREMENT NOT null,
    title varchar(150),
    author varchar(150),
    datetime varchar(100)
); */

/*create table addnewpost(
	id int primary key AUTO_INCREMENT NOT null,
    post_title varchar(500),
    category varchar(500),
    author varchar(500),
    image varchar(500),
    post varchar(500),
    datetime varchar(500)
); */

/*create table comments(
    id int primary key AUTO_INCREMENT not null,
    `datetime` varchar(250) not null,
    name varchar(250),
    email varchar(250),
    `comment` varchar(500),
    approvedby varchar(250),
    `status` varchar(150),
    post_id int not null,
    CONSTRAINT FK_post_id FOREIGN KEY(post_id) REFERENCES addnewpost(id)
);

*/

/*
create table admins(
    id int PRIMARY KEY AUTO_INCREMENT not null,
    `datetime` varchar(200),
    username varchar(20),
    `password` varchar(100),
    name varchar(250),
    addedby varchar(250)
);
*/

/*ALTER tABLE admins
ADD headline varchar(250),
ADD bio varchar(500),
ADD images varchar(250); */