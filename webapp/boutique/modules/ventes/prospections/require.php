<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$title = "GPV | Toutes les ventes en cours";

$prospections = $boutique->fourni("prospection", ["typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION, "DATE(created) >="=> dateAjoute(-15)], [], ["created"=>"DESC"]);


?>