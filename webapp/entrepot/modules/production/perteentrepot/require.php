<?php 
namespace Home;

$title = "GPV | Toutes les pertes entrepots";

unset_session("produits");


$encours = $entrepot->fourni("perteentrepot", ["entrepot_id ="=>$entrepot->id, "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);


$datas = $entrepot->fourni("perteentrepot", ["entrepot_id ="=>$entrepot->id, "etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

?>