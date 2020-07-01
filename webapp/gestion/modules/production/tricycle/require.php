<?php 
namespace Home;

$title = "GPV | Toutes les livraisons par tricycle en cours";

$livraisons = VENTE::findBy(["vehicule_id ="=>VEHICULE::TRICYCLE, "etat_id ="=>ETAT::VALIDEE, "reste > "=>0]);
$total = count($livraisons);

?>