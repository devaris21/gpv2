<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

COMMERCIAL::finDuMois();
GROUPECOMMANDE::etat();
VENTE::ResetProgramme();

$title = "GPV | Tableau de bord";

$tableau = [];
$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);
$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]);


$stats = VENTE::stats2(dateAjoute(-14), dateAjoute(), $boutique->id);


?>