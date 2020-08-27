<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$params = PARAMS::findLastId();

COMMERCIAL::finDuMois();
GROUPECOMMANDE::etat();
VENTE::ResetProgramme();

$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);


$title = "GPV | Tableau de bord";


$stats = VENTE::stats(dateAjoute(-14), dateAjoute(), $entrepot->id);


?>