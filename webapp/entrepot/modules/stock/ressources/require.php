<?php 
namespace Home;
unset_session("ressources");

$ressources = RESSOURCE::getAll();

$title = "GPV | Stock des ressources ";
?>