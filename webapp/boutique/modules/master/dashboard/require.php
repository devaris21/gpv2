<?php 
namespace Home;
unset_session("produits");
unset_session("commande-encours");

$params = PARAMS::findLastId();

COMMERCIAL::finDuMois();
GROUPECOMMANDE::etat();
VENTE::ResetProgramme();

$title = "GPV | Tableau de bord";

$tableau = [];
$produits = PRODUIT::findBy(["isActive ="=>TABLE::OUI]);
$quantites = QUANTITE::findBy(["isActive ="=>TABLE::OUI]);



for ($i=0; $i < 30; $i++) { 
	$date = dateAjoute(-30 + $i);
	$stats[] = 2;
}


$stats = VENTE::stats(dateAjoute(-14), dateAjoute(), $boutique->id);


?>