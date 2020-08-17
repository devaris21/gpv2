<?php 
namespace Home;

$title = "GPV | Tous les clients !";
$clients = CLIENT::findBy(["visibility ="=>1],[],["name"=>"ASC"]);

?>