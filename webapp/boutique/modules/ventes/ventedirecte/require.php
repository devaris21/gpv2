<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes directes";


$encours = $boutique->fourni("vente", ["boutique_id ="=>$boutique->id, "etat_id ="=>ETAT::ENCOURS]);

$ventes = $boutique->fourni("vente", ["boutique_id ="=>$boutique->id, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2]);


?>