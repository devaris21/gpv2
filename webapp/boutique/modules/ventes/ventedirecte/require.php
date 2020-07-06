<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes directes";


$ventes = $boutique->fourni("vente", ["typevente_id ="=>TYPEVENTE::DIRECT, "DATE(created) >="=>dateAjoute(-7)]);


?>