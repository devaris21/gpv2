<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes";


$encours = VENTE::findBy(["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$ventes = VENTE::findBy(["etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>