<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");


$params = PARAMS::findLastId();

$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
$parfums = PARFUM::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
$types_parfums = TYPEPRODUIT_PARFUM::findBy(["isActive ="=>TABLE::OUI]);
$types = TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI], [], ["name"=>"ASC"]);
$ressources = RESSOURCE::getAll([], [], ["name"=>"ASC"]);



$title = "GPV | Tableau de bord";



?>