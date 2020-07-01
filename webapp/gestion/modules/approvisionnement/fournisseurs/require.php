<?php 
namespace Home;

$title = "GPV | Tous les fournisseurs";

$fournisseurs = FOURNISSEUR::findBy(["visibility ="=>1]);


?>