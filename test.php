<?php
$username=isset($_POST['username'])? $_POST['username']:"";

if(empty(trim($username)))
{
die("Dein Benutzername darf nicht leer sein");
}