<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les prospections";

$encours = $boutique->fourni("prospection", ["typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$prospections = $boutique->fourni("prospection", ["typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>