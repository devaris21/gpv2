<?php 
namespace Home;

$title = "GPV | Conditionnements de la production";

unset_session("produits");


$encours = $entrepot->fourni("conditionnement", ["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);


$datas = $entrepot->fourni("conditionnement", ["etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

?>