<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes directes";

$ventes = VENTE::findBy(["boutique_id ="=>$boutique->getId(), "typevente_id ="=>TYPEVENTE::DIRECT, "DATE(created) ="=>dateAjoute(-3)]);


?>