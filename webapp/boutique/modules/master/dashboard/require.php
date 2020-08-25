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

$rupture = 0;
foreach ($produits as $key => $produit) {
	if ($produit->enBoutique($date2, $boutique->id) <= $params->ruptureStock) {
		$rupture++;
	}
}

$stats = VENTE::stats2(dateAjoute(-14), dateAjoute(), $boutique->id);


?>