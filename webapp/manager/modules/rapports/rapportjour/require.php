<?php 
namespace Home;

if ($this->id != "") {
	$date = $this->id;
}else{
	$date = dateAjoute();
}

$commandes = COMMANDE::findBy(["DATE(created) = " => $date, "etat_id !="=>ETAT::ANNULEE]);
$livraisons = PROSPECTION::findBy(["DATE(created) = " => $date, "typeprospection_id="=>TYPEPROSPECTION::LIVRAISON, "etat_id > "=>ETAT::ANNULEE, "etat_id !="=>ETAT::PARTIEL]);
$approvisionnements = APPROVISIONNEMENT::findBy(["visibility ="=>1, "DATE(created) = " => $date, "etat_id !="=>ETAT::ANNULEE]);

$operations = OPERATION::findBy(["DATE(created) = " => $date]);
$entrees = $depenses = [];
foreach ($operations as $key => $value) {
	$value->actualise();
	if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
		$entrees[] = $value;
	}else{
		$depenses[] = $value;
	}
}


$datas = PRODUCTION::findBy(["ladate = " => $date]);
if (count($datas) == 1) {
	$production = $datas[0];
	$production->actualise();
	$production->fourni("ligneproduction");
}


$employes = [];
$connexions = CONNEXION::listeConnecterDuJour($date);
foreach ($connexions as $key => $value) {
	$datas = EMPLOYE::findBy(["id ="=>$value->employe_id]);
	if (count($datas) == 1) {
		$employes[] = $datas[0];
	}
}


$datas = COMPTEBANQUE::findBy(["id = " => COMPTEBANQUE::COURANT]);
if (count($datas) == 1) {
	$comptecourant = $datas[0];
}


$title = "GPV | Rapport général de la journée ";
?>