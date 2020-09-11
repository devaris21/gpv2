<?php 
namespace Home;

$title = "GPV | Tous les fournisseurs";

$fournisseurs = FOURNISSEUR::findBy(["entrepot_id ="=>$entrepot->id]);


?>