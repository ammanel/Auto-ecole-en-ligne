<?php 
header("Content-Type: text/plain ; charset=utf-8");

$bdd = new PDO('mysql:host=localhost;dbname=auto_ecole','root','');

$messages = $bdd->query("SELECT * from messages");

while($f = $messages->fetch())
{
    echo $f["contenu"];
}

?>