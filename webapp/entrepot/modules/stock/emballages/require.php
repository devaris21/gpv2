<?php 
namespace Home;
unset_session("emballages");

$emballages = EMBALLAGE::getAll();

$title = "GPV | Stock des emballages ";
?>