<?php 
namespace Home;

$title = "GPV | Toutes les livraisons en cours";

$encours = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::LIVRAISON, "boutique_id ="=>$boutique->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);

$livraisons = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::LIVRAISON, "boutique_id ="=>$boutique->id, "etat_id ="=>ETAT::VALIDEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

$total = count($encours);

?>