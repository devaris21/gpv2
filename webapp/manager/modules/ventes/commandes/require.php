<?php 
namespace Home;

$title = "GPV | Toutes les commandes en cours";

GROUPECOMMANDE::etat();
$encours = GROUPECOMMANDE::encours();
$groupes = GROUPECOMMANDE::findBy(["etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

?>