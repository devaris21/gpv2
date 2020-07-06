<?php 
namespace Home;

if ($this->getId() != "") {
	$tab = explode("@", $this->getId());
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = dateAjoute(-5);
	$date2 = dateAjoute();
}


$comptecourant = $boutique->comptebanque;


$operations = $boutique->fourni("operation", ["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
foreach ($operations as $key => $value) {
	$value->actualise();
	$value->fiche = "boncaisse";
	$value->type = $value->categorieoperation->name();
}
$clients = $boutique->fourni("REGLEMENTCLIENT", ["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
foreach ($clients as $key => $value) {
	$value->actualise();
	$value->fiche = "boncaisse";
	$value->type = "Reglement de client";
}

// $fournisseurs = REGLEMENTFOURNISSEUR::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
// foreach ($fournisseurs as $key => $value) {
// 	$value->actualise();
// 	$value->fiche = "boncaisse";
// 	$value->type = "Reglement de fournisseur";
// }
// $payes = LIGNEPAYEMENT::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
// foreach ($payes as $key => $value) {
// 	$value->actualise();
// 	$value->fiche = "boncaisse";
// 	$value->type = "Paye de commercial";
// }

$tableau = array_merge($operations, $clients);
usort($tableau, "comparerDateCreated");

$entrees = $depenses = 0;
foreach ($tableau as $key => $value) {
	if ($value->mouvement->comptebanque_id == $comptecourant->getId()) {
		if ($value->mouvement->typemouvement_id == TYPEMOUVEMENT::DEPOT) {
			$entrees += $value->mouvement->montant;
		}else{
			$depenses += $value->mouvement->montant;
		}
	}else{
		unset($tableau[$key]);
	}
	
}
$statistiques = OPERATION::statistiques($boutique->getId());

$title = "GPV | Compte de la caisse courante";

?>