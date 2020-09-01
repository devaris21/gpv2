<?php 
namespace Home;
unset_session("ressources");

$ressources = RESSOURCE::findBy(["isActive ="=>TABLE::OUI]);

$title = "GPV | Stock des ressources ";
?>