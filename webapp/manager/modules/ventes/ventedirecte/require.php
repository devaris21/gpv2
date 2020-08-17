<?php 
namespace Home;

unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes directes";

$ventes = VENTE::findBy(["typevente_id ="=>TYPEVENTE::DIRECT, "DATE(created) >= "=>dateAjoute(-8)], [], ["created"=>"DESC"]);
$ventes__ = VENTE::findBy(["typevente_id ="=>TYPEVENTE::DIRECT, "DATE(created) ="=>dateAjoute()]);


?>