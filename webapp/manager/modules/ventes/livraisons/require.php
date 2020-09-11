<?php 
namespace Home;

$title = "GPV | Toutes les livraisons";

$encours = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::LIVRAISON, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$livraisons = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::LIVRAISON, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

$total = count($encours);

?>