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

$rupture = 0;
foreach ($produits as $key => $produit) {
	if ($produit->enBoutique($date2, $boutique->id) <= $params->ruptureStock) {
		$rupture++;
	}
}


$stats = VENTE::stats(dateAjoute(-14), dateAjoute(), $entrepot->id);


?>