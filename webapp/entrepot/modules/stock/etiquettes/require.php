<?php 
namespace Home;
unset_session("ressources");

$etiquettes = ETIQUETTE::getAll();

$title = "GPV | Stock des etiquettes ";
?>