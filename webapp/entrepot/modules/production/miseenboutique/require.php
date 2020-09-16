<?php 
namespace Home;

unset_session("produits");

$title = "GPV | Mise en boutique de la production";

$mises__ = $entrepot->fourni("miseenboutique", [ "etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);;
$encours2 = $entrepot->fourni("miseenboutique", [ "etat_id ="=>ETAT::PARTIEL], [], ["created"=>"DESC"]);
$encours = array_merge($mises__, $encours2);


$datas1 = $entrepot->fourni("miseenboutique", [ "etat_id ="=>ETAT::VALIDEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas2 = $entrepot->fourni("miseenboutique", [ "etat_id ="=>ETAT::ANNULEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas = array_merge($datas1, $datas2);

?>