<?php 
namespace Home;

$title = "GPV | Tous les clients !";
$clients = CLIENT::findBy(["boutique_id ="=>$boutique->id],[],["name"=>"ASC"]);

?>