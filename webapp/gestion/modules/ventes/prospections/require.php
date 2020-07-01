<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes en cours";

$prospections = PROSPECTION::findBy(["typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION], [], ["created"=>"DESC"]);


?>