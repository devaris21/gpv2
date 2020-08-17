<?php 
namespace Home;

$title = "GPV | Tous les commerciaux";

COMMERCIAL::finDuMois();
$commerciaux = COMMERCIAL::findBy(["visibility ="=>1]);


?>