<?php 
namespace Home;

$title = "GPV | Toutes les commandes en cours";

GROUPECOMMANDE::etat();
$groupes = GROUPECOMMANDE::encours();

?>