<?php 
namespace Home;

$title = "GPV | Conditionnements de la production";

unset_session("produits");


$mises__ = CONDITIONNEMENT::findBy(["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);;
$encours2 = CONDITIONNEMENT::findBy(["etat_id ="=>ETAT::PARTIEL], [], ["created"=>"DESC"]);
$encours = array_merge($mises__, $encours2);


$datas1 = CONDITIONNEMENT::findBy(["etat_id ="=>ETAT::VALIDEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas2 = CONDITIONNEMENT::findBy(["etat_id ="=>ETAT::ANNULEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas = array_merge($datas1, $datas2);

?>