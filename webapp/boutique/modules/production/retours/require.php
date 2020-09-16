<?php 
namespace Home;

$title = "GPV | Toutes les pertes boutiques";

unset_session("produits");


$encours = $boutique->fourni("perteboutique", ["etat_id ="=>ETAT::ENCOURS], [], ["created"=>"DESC"]);


$datas = $boutique->fourni("perteboutique", ["etat_id !="=>ETAT::ENCOURS, "DATE(created) >="=>$date1, "DATE(created) <="=>$date2], [], ["created"=>"DESC"]);

?>