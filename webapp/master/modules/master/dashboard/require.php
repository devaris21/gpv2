<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$params = PARAMS::findLastId();

COMMERCIAL::finDuMois();
GROUPECOMMANDE::etat();
VENTE::ResetProgramme();


$groupes__ = GROUPECOMMANDE::encours();
$prospections__ = PROSPECTION::findBy(["etat_id ="=>ETAT::ENCOURS, "typeprospection_id ="=>TYPEPROSPECTION::PROSPECTION]);;
$ventecaves__ = PROSPECTION::findBy(["etat_id ="=>ETAT::ENCOURS, "typeprospection_id ="=>TYPEPROSPECTION::VENTECAVE]);
$livraisons__ = PROSPECTION::findBy(["etat_id ="=>ETAT::ENCOURS, "typeprospection_id ="=>TYPEPROSPECTION::LIVRAISON]);
$approvisionnements__ = APPROVISIONNEMENT::encours();

$title = "GPV | Tableau de bord";

$stats = VENTE::stats2(dateAjoute(-30), dateAjoute());


?>