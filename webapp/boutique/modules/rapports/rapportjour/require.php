<?php 
namespace Home;

if ($this->id != "") {
	$date = $this->id;
}else{
	$date = dateAjoute();
}

$commandes = $boutique->fourni("commande", ["DATE(created) = " => $date, "etat_id !="=>ETAT::ANNULEE]);
$livraisons = $boutique->fourni("prospection", ["DATE(created) = " => $date, "typeprospection_id="=>TYPEPROSPECTION::LIVRAISON, "etat_id > "=>ETAT::ANNULEE, "etat_id !="=>ETAT::PARTIEL]);

$operations = $boutique->fourni("operation", ["DATE(created) = " => $date]);
$entrees = $depenses = [];
foreach ($operations as $key => $value) {
	$value->actualise();
	if ($value->categorieoperation->typeoperationcaisse_id == TYPEOPERATIONCAISSE::ENTREE) {
		$entrees[] = $value;
	}else{
		$depenses[] = $value;
	}
}



$employes = [];
$connexions = CONNEXION::listeConnecterDuJour($date);
foreach ($connexions as $key => $value) {
	$datas = EMPLOYE::findBy(["id ="=>$value->employe_id]);
	if (count($datas) == 1) {
		$employes[] = $datas[0];
	}
}

$comptecourant = $boutique->comptebanque;


$title = "GPV | Rapport général de la journée ";
?>