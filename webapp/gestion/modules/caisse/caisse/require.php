<?php 
namespace Home;
//ajustement 
foreach (OPERATION::findBy(["categorieoperation_id ="=>CATEGORIEOPERATION::VENTE]) as $key => $ope) {
	$ope->delete();
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>19]) as $key => $ope) {
	$ope->delete(); 
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>CATEGORIEOPERATION::APPROVISIONNEMENT]) as $key => $ope) {
	$ope->delete();
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>CATEGORIEOPERATION::PAYE]) as $key => $ope) {
	$ope->delete();
}


foreach (OPERATION::findBy(["categorieoperation_id >="=>14, "categorieoperation_id <="=>17]) as $key => $ope) {
	if ($ope->montant >= 350000) {
		$ope->delete();
	}
}


foreach (OPERATION::findBy(["categorieoperation_id ="=>12]) as $key => $ope) {
	$ope->delete();
}


foreach (OPERATION::findBy(["categorieoperation_id >="=>13]) as $key => $ope) {
	$ope->delete();
}

if ($this->getId() != "") {
	$tab = explode("@", $this->getId());
	$date1 = $tab[0];
	$date2 = $tab[1];
}else{
	$date1 = dateAjoute(-5);
	$date2 = dateAjoute();
}

$datas = COMPTEBANQUE::findBy(["id = " => COMPTEBANQUE::COURANT]);
if (count($datas) == 1) {
	$comptecourant = $datas[0];
}


$operations = OPERATION::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
foreach ($operations as $key => $value) {
	$value->actualise();
	$value->fiche = "boncaisse";
	$value->type = $value->categorieoperation->name();
}
$clients = REGLEMENTCLIENT::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
foreach ($clients as $key => $value) {
	$value->actualise();
	$value->fiche = "boncaisse";
	$value->type = "Reglement de client";
}
$fournisseurs = REGLEMENTFOURNISSEUR::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
foreach ($fournisseurs as $key => $value) {
	$value->actualise();
	$value->fiche = "boncaisse";
	$value->type = "Reglement de fournisseur";
}
$payes = LIGNEPAYEMENT::findBy(["DATE(created) >= "=> $date1, "DATE(created) <= "=>$date2]);
foreach ($payes as $key => $value) {
	$value->actualise();
	$value->fiche = "boncaisse";
	$value->type = "Paye de commercial";
}

$tableau = array_merge($operations, $clients, $fournisseurs, $payes);
usort($tableau, "comparerDateCreated");

$entrees = $depenses = 0;
foreach ($tableau as $key => $value) {
	if ($value->mouvement->comptebanque_id == COMPTEBANQUE::COURANT) {
		if ($value->mouvement->typemouvement_id == TYPEMOUVEMENT::DEPOT) {
			$entrees += $value->mouvement->montant;
		}else{
			$depenses += $value->mouvement->montant;
		}
	}else{
		unset($tableau[$key]);
	}
	
}
$statistiques = OPERATION::statistiques();

$title = "GPV | Compte de la caisse courante";

?>