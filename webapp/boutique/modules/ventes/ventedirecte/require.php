<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes";


$encours = $boutique->fourni("vente", ["typevente_id ="=>TYPEVENTE::DIRECT, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$ventes = $boutique->fourni("vente", ["typevente_id ="=>TYPEVENTE::DIRECT, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);


?>