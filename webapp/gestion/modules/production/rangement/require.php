<?php 
namespace Home;

$title = "GPV | Rangements de la production";

$productions = PRODUCTIONJOUR::findBy(["etat_id !="=>ETAT::ENCOURS]);


?>