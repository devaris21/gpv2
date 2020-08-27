<?php 
namespace Home;
unset_session("emballages");
unset_session("ressources");

$emballages = EMBALLAGE::getAll();

$title = "GPV | Stock des emballages ";
?>