<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les prospections";

$encours = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$prospections = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>