<?php

session_start();

$db_host                      = "https://localhost";
$db_username                  = "root";
$db_password                  = "Jabez2023";
$db_name                      = "attypay_cap";
$localhost					          = "DESKTOP-3OAGF1O";

$db = mysqli_connect($db_host, $db_username, $db_password, $db_name, $localhost);

if(!$db) {
  die("Connection failed: ".mysqli_connect_error());
}	