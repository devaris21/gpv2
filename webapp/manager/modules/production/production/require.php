<?php 
namespace Home;

$title = "GPV | Toutes les productions";

unset_session("produits");

$typeproduits = TYPEPRODUIT::findBy(["isActive ="=>TABLE::OUI]);

$mises__ = PRODUCTION::findBy(["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);;
$encours2 = PRODUCTION::findBy(["etat_id ="=>ETAT::PARTIEL], [], ["created"=>"DESC"]);
$encours = array_merge($mises__, $encours2);


$datas1 = PRODUCTION::findBy(["etat_id ="=>ETAT::VALIDEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas2 = PRODUCTION::findBy(["etat_id ="=>ETAT::ANNULEE, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);
$datas = array_merge($datas1, $datas2);

?>